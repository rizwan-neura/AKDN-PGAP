@extends('layouts.master')

@section('title')
    User Management
@endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            PGAP
        @endslot
        @slot('title')
            User Management
        @endslot
    @endcomponent

    @php
        $currentUser = auth()->user();
        $assignableRoles = $currentUser->isSuperAdmin()
            ? $roles
            : $roles->reject(fn ($role) => $role->isSuperAdmin())->values();
        $formContext = old('form_context');
    @endphp

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="ri-checkbox-circle-line me-1"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="ri-error-warning-line me-1"></i>
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Please fix the following:</strong>
            <ul class="mb-0 mt-2">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header border-0">
                    <div class="d-flex flex-wrap align-items-center justify-content-between gap-2">
                        <div>
                            <h4 class="card-title mb-1">Users</h4>
                            <p class="text-muted mb-0">
                                Manage PGAP accounts, organizations, roles, and account status.
                            </p>
                        </div>

                        <div class="d-flex gap-2">
                            <a href="{{ route('users.access') }}" class="btn btn-soft-primary">
                                <i class="ri-shield-user-line me-1"></i>
                                Access Overview
                            </a>

                            <button type="button"
                                    class="btn btn-success"
                                    data-bs-toggle="modal"
                                    data-bs-target="#addUserModal">
                                <i class="ri-user-add-line me-1"></i>
                                Add User
                            </button>
                        </div>
                    </div>
                </div>

                <div class="card-body border-top">
                    <form method="GET" action="{{ route('users.index') }}" class="row g-2 align-items-end">
                        <div class="col-lg-4 col-md-6">
                            <label class="form-label" for="search">Search</label>
                            <div class="position-relative">
                                <input type="text"
                                       id="search"
                                       name="search"
                                       value="{{ request('search') }}"
                                       class="form-control"
                                       placeholder="Name, username, email, role...">
                                <i class="ri-search-line position-absolute top-50 end-0 translate-middle-y me-3 text-muted"></i>
                            </div>
                        </div>

                        <div class="col-lg-3 col-md-6">
                            <label class="form-label" for="organization_id">Organization</label>
                            <select id="organization_id" name="organization_id" class="form-select">
                                <option value="">All organizations</option>
                                @foreach($organizations as $organization)
                                    <option value="{{ $organization->id }}"
                                        {{ (string) request('organization_id') === (string) $organization->id ? 'selected' : '' }}>
                                        {{ $organization->organization_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-lg-2 col-md-4">
                            <label class="form-label" for="role_id">Role</label>
                            <select id="role_id" name="role_id" class="form-select">
                                <option value="">All roles</option>
                                @foreach($roles as $role)
                                    <option value="{{ $role->id }}" {{ (string) request('role_id') === (string) $role->id ? 'selected' : '' }}>
                                        {{ $role->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-lg-2 col-md-4">
                            <label class="form-label" for="status">Status</label>
                            <select id="status" name="status" class="form-select">
                                <option value="">All statuses</option>
                                @foreach($statuses as $status)
                                    <option value="{{ $status }}" {{ request('status') === $status ? 'selected' : '' }}>
                                        {{ $status }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-lg-1 col-md-4">
                            <button type="submit" class="btn btn-primary w-100" title="Apply filters">
                                <i class="ri-filter-3-line"></i>
                            </button>
                        </div>
                    </form>

                    @if(request()->hasAny(['search', 'organization_id', 'role_id', 'status']))
                        <div class="mt-2">
                            <a href="{{ route('users.index') }}" class="small text-muted">
                                <i class="ri-close-circle-line me-1"></i>
                                Clear filters
                            </a>
                        </div>
                    @endif
                </div>

                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>User</th>
                                    <th>Username</th>
                                    <th>Organization</th>
                                    <th>Role</th>
                                    <th>Status</th>
                                    <th class="text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($users as $user)
                                    @php
                                        $canManageTarget = ! $user->isSuperAdmin() || $currentUser->isSuperAdmin();
                                    @endphp
                                    <tr>
                                        <td>
                                            <div>
                                                <h6 class="mb-1">{{ $user->full_name ?: 'N/A' }}</h6>
                                                <a href="mailto:{{ $user->email }}" class="text-muted small">
                                                    {{ $user->email }}
                                                </a>
                                            </div>
                                        </td>

                                        <td>{{ $user->username }}</td>

                                        <td>
                                            {{ $user->organization?->organization_name ?? 'Not assigned' }}
                                        </td>

                                        <td>
                                            @if($user->isSuperAdmin())
                                                <span class="badge bg-danger-subtle text-danger">Super Admin</span>
                                            @elseif($user->isAdmin())
                                                <span class="badge bg-primary-subtle text-primary">Admin</span>
                                            @elseif($user->workflow_level)
                                                <div class="d-flex flex-column align-items-start gap-1">
                                                    <span class="badge bg-info-subtle text-info">
                                                        Level-{{ str_pad($user->workflow_level, 2, '0', STR_PAD_LEFT) }}
                                                    </span>
                                                    <span class="small">{{ $user->role?->name ?? 'Not assigned' }}</span>
                                                </div>
                                            @else
                                                <span class="badge bg-secondary-subtle text-secondary">{{ $user->role?->name ?? 'Not assigned' }}</span>
                                            @endif
                                        </td>

                                        <td>
                                            @if($user->isActive())
                                                <span class="badge bg-success-subtle text-success">
                                                    <i class="ri-checkbox-circle-line me-1"></i>
                                                    Active
                                                </span>
                                            @else
                                                <span class="badge bg-danger-subtle text-danger">
                                                    <i class="ri-close-circle-line me-1"></i>
                                                    Inactive
                                                </span>
                                            @endif
                                        </td>

                                        <td class="text-end">
                                            <div class="d-inline-flex gap-2">
                                                <button type="button"
                                                        class="btn btn-sm btn-soft-success edit-user-btn"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#editUserModal"
                                                        data-update-url="{{ route('users.update', $user) }}"
                                                        data-user-id="{{ $user->id }}"
                                                        data-first-name="{{ $user->first_name }}"
                                                        data-last-name="{{ $user->last_name }}"
                                                        data-username="{{ $user->username }}"
                                                        data-email="{{ $user->email }}"
                                                        data-organization-id="{{ $user->organization_id }}"
                                                        data-role-id="{{ $user->role_id }}"
                                                        data-status="{{ $user->status }}"
                                                        title="{{ $canManageTarget ? 'Edit user' : 'Only a Super Admin can edit this account' }}"
                                                        {{ $canManageTarget ? '' : 'disabled' }}>
                                                    <i class="ri-pencil-fill"></i>
                                                </button>

                                                <form action="{{ route('users.destroy', $user) }}"
                                                      method="POST"
                                                      class="delete-user-form"
                                                      data-username="{{ $user->username }}">
                                                    @csrf
                                                    @method('DELETE')

                                                    <button type="submit"
                                                            class="btn btn-sm btn-soft-danger"
                                                            title="{{ $currentUser->is($user) ? 'You cannot delete your own account' : 'Delete user' }}"
                                                            {{ ($currentUser->is($user) || ! $canManageTarget) ? 'disabled' : '' }}>
                                                        <i class="ri-delete-bin-line"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-5">
                                            <i class="ri-user-search-line fs-1 text-muted"></i>
                                            <h5 class="mt-2">No users found</h5>
                                            <p class="text-muted mb-0">
                                                Try changing the filters or add a new user.
                                            </p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                @if($users->hasPages())
                    <div class="card-footer">
                        <div class="d-flex flex-wrap align-items-center justify-content-between gap-2">
                            <span class="text-muted small">
                                Showing {{ $users->firstItem() }}–{{ $users->lastItem() }}
                                of {{ $users->total() }} users
                            </span>
                            {{ $users->links() }}
                        </div>
                    </div>
                @else
                    <div class="card-footer text-muted small">
                        {{ $users->total() }} {{ \Illuminate\Support\Str::plural('user', $users->total()) }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Add User --}}
    <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <form action="{{ route('users.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="form_context" value="add">

                    <div class="modal-header">
                        <h5 class="modal-title" id="addUserModalLabel">
                            <i class="ri-user-add-line me-1"></i>
                            Add User
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label" for="add_first_name">First Name <span class="text-danger">*</span></label>
                                <input type="text"
                                       id="add_first_name"
                                       name="first_name"
                                       value="{{ $formContext === 'add' ? old('first_name') : '' }}"
                                       class="form-control {{ $formContext === 'add' && $errors->has('first_name') ? 'is-invalid' : '' }}"
                                       required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label" for="add_last_name">Last Name <span class="text-danger">*</span></label>
                                <input type="text"
                                       id="add_last_name"
                                       name="last_name"
                                       value="{{ $formContext === 'add' ? old('last_name') : '' }}"
                                       class="form-control {{ $formContext === 'add' && $errors->has('last_name') ? 'is-invalid' : '' }}"
                                       required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label" for="add_username">Username <span class="text-danger">*</span></label>
                                <input type="text"
                                       id="add_username"
                                       name="username"
                                       value="{{ $formContext === 'add' ? old('username') : '' }}"
                                       class="form-control {{ $formContext === 'add' && $errors->has('username') ? 'is-invalid' : '' }}"
                                       autocomplete="off"
                                       required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label" for="add_email">Email <span class="text-danger">*</span></label>
                                <input type="email"
                                       id="add_email"
                                       name="email"
                                       value="{{ $formContext === 'add' ? old('email') : '' }}"
                                       class="form-control {{ $formContext === 'add' && $errors->has('email') ? 'is-invalid' : '' }}"
                                       required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label" for="add_organization_id">Organization <span class="text-danger">*</span></label>
                                <select id="add_organization_id"
                                        name="organization_id"
                                        class="form-select {{ $formContext === 'add' && $errors->has('organization_id') ? 'is-invalid' : '' }}"
                                        required>
                                    <option value="">Select organization</option>
                                    @foreach($organizations as $organization)
                                        <option value="{{ $organization->id }}"
                                            {{ $formContext === 'add' && (string) old('organization_id') === (string) $organization->id ? 'selected' : '' }}>
                                            {{ $organization->organization_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-3">
                                <label class="form-label" for="add_role_id">Role <span class="text-danger">*</span></label>
                                <select id="add_role_id"
                                        name="role_id"
                                        class="form-select {{ $formContext === 'add' && $errors->has('role_id') ? 'is-invalid' : '' }}"
                                        required>
                                    @foreach($assignableRoles as $role)
                                        <option value="{{ $role->id }}"
                                            {{ (string) ($formContext === 'add' ? old('role_id', \App\Models\Role::ACFP_ID) : \App\Models\Role::ACFP_ID) === (string) $role->id ? 'selected' : '' }}>
                                            {{ $role->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-3">
                                <label class="form-label" for="add_status">Status <span class="text-danger">*</span></label>
                                <select id="add_status"
                                        name="status"
                                        class="form-select {{ $formContext === 'add' && $errors->has('status') ? 'is-invalid' : '' }}"
                                        required>
                                    @foreach($statuses as $status)
                                        <option value="{{ $status }}"
                                            {{ ($formContext === 'add' ? old('status', 'Active') : 'Active') === $status ? 'selected' : '' }}>
                                            {{ $status }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-12">
                                <label class="form-label" for="add_password">Password <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="password"
                                           id="add_password"
                                           name="password"
                                           class="form-control {{ $formContext === 'add' && $errors->has('password') ? 'is-invalid' : '' }}"
                                           minlength="8"
                                           autocomplete="new-password"
                                           required>
                                    <button class="btn btn-outline-secondary password-toggle"
                                            type="button"
                                            data-target="add_password"
                                            aria-label="Show or hide password">
                                        <i class="ri-eye-line"></i>
                                    </button>
                                </div>
                                <small class="text-muted">Minimum 8 characters.</small>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success">
                            <i class="ri-save-line me-1"></i>
                            Create User
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Edit User --}}
    <div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <form id="editUserForm" method="POST" action="">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="form_context" value="edit">
                    <input type="hidden" id="editing_user_id" name="editing_user_id" value="{{ old('editing_user_id') }}">

                    <div class="modal-header">
                        <h5 class="modal-title" id="editUserModalLabel">
                            <i class="ri-user-settings-line me-1"></i>
                            Edit User
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label" for="edit_first_name">First Name <span class="text-danger">*</span></label>
                                <input type="text"
                                       id="edit_first_name"
                                       name="first_name"
                                       class="form-control {{ $formContext === 'edit' && $errors->has('first_name') ? 'is-invalid' : '' }}"
                                       required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label" for="edit_last_name">Last Name <span class="text-danger">*</span></label>
                                <input type="text"
                                       id="edit_last_name"
                                       name="last_name"
                                       class="form-control {{ $formContext === 'edit' && $errors->has('last_name') ? 'is-invalid' : '' }}"
                                       required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label" for="edit_username">Username <span class="text-danger">*</span></label>
                                <input type="text"
                                       id="edit_username"
                                       name="username"
                                       class="form-control {{ $formContext === 'edit' && $errors->has('username') ? 'is-invalid' : '' }}"
                                       required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label" for="edit_email">Email <span class="text-danger">*</span></label>
                                <input type="email"
                                       id="edit_email"
                                       name="email"
                                       class="form-control {{ $formContext === 'edit' && $errors->has('email') ? 'is-invalid' : '' }}"
                                       required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label" for="edit_organization_id">Organization <span class="text-danger">*</span></label>
                                <select id="edit_organization_id"
                                        name="organization_id"
                                        class="form-select {{ $formContext === 'edit' && $errors->has('organization_id') ? 'is-invalid' : '' }}"
                                        required>
                                    <option value="">Select organization</option>
                                    @foreach($organizations as $organization)
                                        <option value="{{ $organization->id }}">
                                            {{ $organization->organization_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-3">
                                <label class="form-label" for="edit_role_id">Role <span class="text-danger">*</span></label>
                                <select id="edit_role_id"
                                        name="role_id"
                                        class="form-select {{ $formContext === 'edit' && $errors->has('role_id') ? 'is-invalid' : '' }}"
                                        required>
                                    @foreach($assignableRoles as $role)
                                        <option value="{{ $role->id }}">
                                            {{ $role->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-3">
                                <label class="form-label" for="edit_status">Status <span class="text-danger">*</span></label>
                                <select id="edit_status"
                                        name="status"
                                        class="form-select {{ $formContext === 'edit' && $errors->has('status') ? 'is-invalid' : '' }}"
                                        required>
                                    @foreach($statuses as $status)
                                        <option value="{{ $status }}">{{ $status }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-12">
                                <label class="form-label" for="edit_password">New Password</label>
                                <div class="input-group">
                                    <input type="password"
                                           id="edit_password"
                                           name="password"
                                           class="form-control {{ $formContext === 'edit' && $errors->has('password') ? 'is-invalid' : '' }}"
                                           minlength="8"
                                           autocomplete="new-password"
                                           placeholder="Leave blank to keep the current password">
                                    <button class="btn btn-outline-secondary password-toggle"
                                            type="button"
                                            data-target="edit_password"
                                            aria-label="Show or hide password">
                                        <i class="ri-eye-line"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success">
                            <i class="ri-save-line me-1"></i>
                            Update User
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const editModalElement = document.getElementById('editUserModal');
            const editForm = document.getElementById('editUserForm');

            const setEditForm = function (data) {
                editForm.action = data.updateUrl || '';
                document.getElementById('editing_user_id').value = data.userId || '';
                document.getElementById('edit_first_name').value = data.firstName || '';
                document.getElementById('edit_last_name').value = data.lastName || '';
                document.getElementById('edit_username').value = data.username || '';
                document.getElementById('edit_email').value = data.email || '';
                document.getElementById('edit_organization_id').value = data.organizationId || '';
                document.getElementById('edit_role_id').value = data.roleId || @json(\App\Models\Role::ACFP_ID);
                document.getElementById('edit_status').value = data.status || 'Active';
                document.getElementById('edit_password').value = '';
            };

            editModalElement.addEventListener('show.bs.modal', function (event) {
                const button = event.relatedTarget;

                if (!button) {
                    return;
                }

                setEditForm({
                    updateUrl: button.dataset.updateUrl,
                    userId: button.dataset.userId,
                    firstName: button.dataset.firstName,
                    lastName: button.dataset.lastName,
                    username: button.dataset.username,
                    email: button.dataset.email,
                    organizationId: button.dataset.organizationId,
                    roleId: button.dataset.roleId,
                    status: button.dataset.status
                });
            });

            document.querySelectorAll('.delete-user-form').forEach(function (form) {
                form.addEventListener('submit', function (event) {
                    const username = form.dataset.username || 'this user';

                    if (!window.confirm('Delete ' + username + '? This action cannot be undone.')) {
                        event.preventDefault();
                    }
                });
            });

            document.querySelectorAll('.password-toggle').forEach(function (button) {
                button.addEventListener('click', function () {
                    const input = document.getElementById(button.dataset.target);
                    const icon = button.querySelector('i');

                    if (!input) {
                        return;
                    }

                    const show = input.type === 'password';
                    input.type = show ? 'text' : 'password';

                    if (icon) {
                        icon.className = show ? 'ri-eye-off-line' : 'ri-eye-line';
                    }
                });
            });

            const formContext = @json($formContext);

            if (formContext === 'add') {
                bootstrap.Modal.getOrCreateInstance(document.getElementById('addUserModal')).show();
            }

            if (formContext === 'edit') {
                setEditForm({
                    updateUrl: @json(old('editing_user_id') ? route('users.update', old('editing_user_id')) : ''),
                    userId: @json(old('editing_user_id')),
                    firstName: @json(old('first_name')),
                    lastName: @json(old('last_name')),
                    username: @json(old('username')),
                    email: @json(old('email')),
                    organizationId: @json(old('organization_id')),
                    roleId: @json(old('role_id', \App\Models\Role::ACFP_ID)),
                    status: @json(old('status', 'Active'))
                });

                bootstrap.Modal.getOrCreateInstance(editModalElement).show();
            }
        });
    </script>

    <script src="{{ URL::asset('build/js/app.js') }}"></script>
@endsection
