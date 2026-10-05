<?php

namespace App\Console\Commands;

use App\Models\Role;
use App\Models\User;
use Illuminate\Console\Command;

class MakeUserAdmin extends Command
{
    protected $signature = 'users:make-admin
                            {email : Email address of an existing user}
                            {--super : Assign the Super Admin role instead of Admin}';

    protected $description = 'Promote an existing PGAP user to Admin or Super Admin';

    public function handle(): int
    {
        $email = strtolower(trim((string) $this->argument('email')));

        $user = User::query()
            ->whereRaw('LOWER(email) = ?', [$email])
            ->first();

        if (! $user) {
            $this->error("No user was found with email {$email}.");

            return self::FAILURE;
        }

        $roleId = $this->option('super')
            ? Role::SUPER_ADMIN_ID
            : Role::ADMIN_ID;

        $role = Role::findOrFail($roleId);

        $user->update([
            'role_id' => $role->id,
            'status' => 'Active',
        ]);

        $this->info("{$user->full_name} ({$user->email}) is now {$role->name}.");

        return self::SUCCESS;
    }
}
