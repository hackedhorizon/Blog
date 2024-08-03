<?php

namespace Database\Seeders;

use App\Enums\RoleName;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;

class PermissionRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->createPermissions();
        $this->createAdminRole();
        $this->createUserRole();
    }

    protected function createPermissions(): void
    {
        $permissions = [
            'viewAny',
            'view',
            'create',
            'update',
            'delete',
            'restore',
            'forceDelete',
        ];

        $roles = [
            'admin',
            'user',
        ];

        collect($roles)
            ->crossJoin($permissions)
            ->map(function ($set) {
                return implode('.', $set);
            })->each(function ($permission) {
                Permission::create(['name' => $permission]);
            });
    }

    protected function createAdminRole(): void
    {
        // Query permissions from the database
        $permissions = Permission::query()
            ->where('name', 'like', 'admin.%')
            ->pluck('id');

        // Create the admin role with the permissions
        $this->createRole(RoleName::ADMIN, $permissions);
    }

    protected function createUserRole(): void
    {
        // Query permissions from the database
        $permissions = Permission::query()
            ->where('name', 'like', 'user.%')
            ->pluck('id');

        // Create the user role with the permissions
        $this->createRole(RoleName::USER, $permissions);
    }

    protected function createRole(RoleName $role, Collection $permissions): void
    {
        // Create a new role with the given role name
        $newRole = Role::create(['name' => $role->value]);

        // Assign the permissions to the role
        $newRole->permissions()->sync($permissions);
    }
}
