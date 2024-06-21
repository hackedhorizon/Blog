<?php

namespace Database\Seeders;

use App\Enums\RoleName;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->createAdminUser();
        $this->createDefaultUsers();
    }

    public function createAdminUser()
    {
        User::create([
            'name' => 'Admin User',
            'username' => 'admin',
            'email' => 'admin@admin.com',
            'password' => bcrypt('password'),
        ])->roles()->sync(Role::where('name', RoleName::ADMIN->value)->first());
    }

    public function createDefaultUsers()
    {
        // Create a default guest user with fixed credentials (username: test, password: password)
        $user = User::factory(User::class)->create([
            'username' => 'test',
            'password' => bcrypt('password'),
        ]);

        // Create 10 dummy users using the User factory
        User::factory(10)->create();
    }
}
