<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        $this->call(UserSeeder::class);

        User::query()
            ->where('username', 'superadmin')
            ->update([
                'role_id' => Role::SUPER_ADMIN_ID,
                'status' => 'Active',
            ]);
    }
}
