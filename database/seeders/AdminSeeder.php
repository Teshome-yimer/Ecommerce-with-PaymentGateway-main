<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user (idempotent — safe to re-run on existing data)
        $admin = User::firstOrCreate(
            ['email' => 'admin@admin.com'],
            [
                'name'     => 'Admin',
                'password' => Hash::make('password'),
            ]
        );

        // Assign admin role (no-op if already assigned)
        if (!$admin->hasRole('admin')) {
            $admin->assignRole('admin');
        }

        // Create a regular user for testing (idempotent)
        $user = User::firstOrCreate(
            ['email' => 'user@test.com'],
            [
                'name'     => 'User Test',
                'password' => Hash::make('password'),
            ]
        );

        // Assign user role (no-op if already assigned)
        if (!$user->hasRole('user')) {
            $user->assignRole('user');
        }
    }
}
