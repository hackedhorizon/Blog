<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->createDefaultUsers();
    }

    public function createDefaultUsers()
    {
        // Create a default guest user with fixed credentials (username: test, password: password)
        $defaultUser = User::factory(User::class)->create([
            'username' => 'test',
            'password' => bcrypt('password'),
        ]);

        $adminUser = User::factory(User::class)->create([
            'username' => 'admin',
            'password' => bcrypt('password'),
        ]);

        $defaultUser->assignRole('user');
        $adminUser->assignRole('admin');

        // Create 10 dummy users using the User factory
        User::factory(10)->create();
    }
}
