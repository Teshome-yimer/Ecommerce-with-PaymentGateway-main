<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UpdateAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Update existing admin user
        User::where('email', 'admin@admin.com')->update(['is_admin' => true]);

        // Update existing regular user
        User::where('email', 'user@test.com')->update(['is_admin' => false]);

        echo "Admin users updated successfully!\n";
    }
}
