<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create permissions
        $permissions = [
            // User Management
            'view-users',
            'create-users',
            'edit-users',
            'delete-users',
            
            // Role Management
            'view-roles',
            'create-roles',
            'edit-roles',
            'delete-roles',
            
            // Permission Management
            'view-permissions',
            'create-permissions',
            'edit-permissions',
            'delete-permissions',
            
            // Application Management
            'view-applications',
            'create-applications',
            'edit-applications',
            'delete-applications',
            
            // Change Management
            'view-changes',
            'create-changes',
            'edit-changes',
            'delete-changes',
            'approve-changes',
            'reject-changes',
            
            // Dashboard & Reports
            'view-dashboard',
            'view-reports',
            'export-reports',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Create roles and assign permissions
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $adminRole->givePermissionTo(Permission::all());

        $managerRole = Role::firstOrCreate(['name' => 'manager']);
        $managerRole->givePermissionTo([
            'view-users',
            'view-applications',
            'create-applications',
            'edit-applications',
            'view-changes',
            'create-changes',
            'edit-changes',
            'approve-changes',
            'reject-changes',
            'view-dashboard',
            'view-reports',
            'export-reports',
        ]);

        $userRole = Role::firstOrCreate(['name' => 'user']);
        $userRole->givePermissionTo([
            'view-applications',
            'view-changes',
            'create-changes',
            'edit-changes',
            'view-dashboard',
        ]);

        // Assign admin role to existing users (if any)
        $existingUsers = User::all();
        foreach ($existingUsers as $user) {
            if (!$user->hasAnyRole(['admin', 'manager', 'user'])) {
                $user->assignRole('admin');
            }
        }

        $this->command->info('Roles and permissions seeded successfully!');
    }
}
