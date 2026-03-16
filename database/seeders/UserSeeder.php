<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // First user (already in DB — fine)
        User::firstOrCreate(
            ['email' => 'rizwanoo@gmail.com'], // Check by email only
            [
                'username' => 'superadmin',
                'first_name' => 'Super',
                'last_name' => 'Admin',
                'password' => Hash::make('123456'),
            ]
        );

        // Second user (new one)
        User::firstOrCreate(
            ['email' => 'test@example.com'], // Only use unique fields here
            [
                'username' => 'test1',
                'first_name' => 'Test',
                'last_name' => 'Test',
                'password' => Hash::make('123456'),
            ]
        );
    }
}
