<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class TestUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create a test user with limited permissions (user role)
        $testUser = User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);

        // Assign user role (limited permissions)
        $userRole = Role::where('name', 'user')->first();
        if ($userRole) {
            $testUser->assignRole($userRole);
        }

        // Create a manager test user
        $managerUser = User::create([
            'name' => 'Manager Test',
            'email' => 'manager@example.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);

        // Assign manager role (moderate permissions)
        $managerRole = Role::where('name', 'manager')->first();
        if ($managerRole) {
            $managerUser->assignRole($managerRole);
        }

        $this->command->info('Test users created successfully!');
        $this->command->info('Test User: test@example.com / password (user role)');
        $this->command->info('Manager User: manager@example.com / password (manager role)');
    }
}
