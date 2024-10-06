<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Define an array of permissions
        $permissions = [
            'view unpublished posts',
            'create posts',
            'edit posts',
            'delete posts',
        ];

        // Create or update the permissions
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Get or create the admin role
        $adminRole = Role::firstOrCreate(['name' => 'admin']);

        // Assign all permissions to the admin role
        $adminRole->syncPermissions($permissions);
    }
}
