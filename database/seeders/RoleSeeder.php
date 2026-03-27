<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create roles (or get existing)
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $userRole = Role::firstOrCreate(['name' => 'user']);

        // Create permissions - HANYA ADMIN yang bisa manage
        $adminPermissions = [
            'view_admin_panel',
            'manage_products',
            'manage_categories',
            'manage_brands',
            'manage_orders',
            'manage_users',
            'view_reports',
        ];

        // Create user permissions - HANYA untuk shopping
        $userPermissions = [
            'view_products',
            'add_to_cart',
            'checkout',
            'view_own_orders',
        ];

        // Create all permissions (or get existing)
        foreach (array_merge($adminPermissions, $userPermissions) as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Admin gets ALL permissions
        $adminRole->givePermissionTo(array_merge($adminPermissions, $userPermissions));

        // User gets ONLY shopping permissions
        $userRole->givePermissionTo($userPermissions);
    }
}
