<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Organization;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->query('search', ''));
        $status = (string) $request->query('status', '');
        $roleId = $request->integer('role_id') ?: null;
        $organizationId = $request->integer('organization_id') ?: null;

        $users = User::query()
            ->with(['organization', 'role'])
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($inner) use ($search) {
                    $inner->where('first_name', 'like', "%{$search}%")
                        ->orWhere('last_name', 'like', "%{$search}%")
                        ->orWhere('username', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhereHas('role', function ($roleQuery) use ($search) {
                            $roleQuery->where('name', 'like', "%{$search}%")
                                ->orWhere('code', 'like', "%{$search}%");
                        })
                        ->orWhereHas('organization', function ($organizationQuery) use ($search) {
                            $organizationQuery->where('organization_name', 'like', "%{$search}%");
                        });
                });
            })
            ->when(in_array($status, User::STATUSES, true), fn ($query) => $query->where('status', $status))
            ->when($roleId, fn ($query) => $query->where('role_id', $roleId))
            ->when($organizationId, fn ($query) => $query->where('organization_id', $organizationId))
            ->orderBy('first_name')
            ->orderBy('last_name')
            ->paginate(15)
            ->withQueryString();

        $organizations = Organization::query()
            ->orderBy('organization_name')
            ->get();

        $roles = Role::query()
            ->where('is_active', true)
            ->orderBy('id')
            ->get();

        return view('users.index', [
            'users' => $users,
            'organizations' => $organizations,
            'roles' => $roles,
            'statuses' => User::STATUSES,
        ]);
    }

    public function access(): View
    {
        $roles = Role::query()
            ->withCount('users')
            ->orderBy('id')
            ->get();

        $roleStats = $roles->map(fn (Role $role) => [
            'id' => $role->id,
            'name' => $role->name,
            'code' => $role->code,
            'description' => $role->description,
            'level' => $role->workflow_level,
            'users' => $role->users_count,
            'can_manage_users' => $role->can_manage_users,
            'can_assign_super_admin' => $role->can_assign_super_admin,
        ]);

        return view('users.access', [
            'roleStats' => $roleStats,
            'totalUsers' => User::count(),
            'activeUsers' => User::where('status', 'Active')->count(),
            'inactiveUsers' => User::where('status', 'Inactive')->count(),
            'adminUsers' => User::whereHas('role', fn ($query) => $query->where('can_manage_users', true))->count(),
        ]);
    }

    public function store(StoreUserRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $actor = $request->user();
        $role = Role::findOrFail($data['role_id']);

        if ($role->isSuperAdmin() && ! $actor->isSuperAdmin()) {
            return back()
                ->withInput()
                ->with('error', 'Only a Super Admin can assign the Super Admin role.');
        }

        User::create($data);

        return redirect()
            ->route('users.index')
            ->with('success', 'User created successfully.');
    }

    public function update(UpdateUserRequest $request, User $user): RedirectResponse
    {
        $data = $request->validated();
        $actor = $request->user();
        $requestedRole = Role::findOrFail($data['role_id']);

        if ($user->isSuperAdmin() && ! $actor->isSuperAdmin()) {
            return back()
                ->withInput()
                ->with('error', 'Only a Super Admin can modify a Super Admin account.');
        }

        if ($requestedRole->isSuperAdmin() && ! $actor->isSuperAdmin()) {
            return back()
                ->withInput()
                ->with('error', 'Only a Super Admin can assign the Super Admin role.');
        }

        if ($actor->is($user)) {
            if ($data['status'] !== 'Active') {
                return back()
                    ->withInput()
                    ->with('error', 'You cannot deactivate your own account.');
            }

            if (! $requestedRole->isAdminRole()) {
                return back()
                    ->withInput()
                    ->with('error', 'You cannot remove your own administrator role.');
            }
        }

        if (
            $this->isLastActiveSuperAdmin($user)
            && (! $requestedRole->isSuperAdmin() || $data['status'] !== 'Active')
        ) {
            return back()
                ->withInput()
                ->with('error', 'The last active Super Admin cannot be demoted or deactivated.');
        }

        if (blank($data['password'] ?? null)) {
            unset($data['password']);
        }

        $user->update($data);

        return redirect()
            ->route('users.index')
            ->with('success', 'User updated successfully.');
    }

    public function destroy(Request $request, User $user): RedirectResponse
    {
        $actor = $request->user();

        if ($actor->is($user)) {
            return redirect()
                ->route('users.index')
                ->with('error', 'You cannot delete your own account.');
        }

        if ($user->isSuperAdmin() && ! $actor->isSuperAdmin()) {
            return redirect()
                ->route('users.index')
                ->with('error', 'Only a Super Admin can delete a Super Admin account.');
        }

        if ($this->isLastActiveSuperAdmin($user)) {
            return redirect()
                ->route('users.index')
                ->with('error', 'The last active Super Admin cannot be deleted.');
        }

        try {
            $user->delete();
        } catch (QueryException) {
            return redirect()
                ->route('users.index')
                ->with('error', 'This user is referenced by other records and cannot be deleted.');
        }

        return redirect()
            ->route('users.index')
            ->with('success', 'User deleted successfully.');
    }

    private function isLastActiveSuperAdmin(User $user): bool
    {
        if (! $user->isSuperAdmin() || ! $user->isActive()) {
            return false;
        }

        return User::query()
            ->where('role_id', Role::SUPER_ADMIN_ID)
            ->whereRaw('LOWER(status) = ?', ['active'])
            ->count() <= 1;
    }
}
