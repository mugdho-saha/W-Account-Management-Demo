<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\PermissionRegistrar;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // 2. Create the Admin role if it doesn't exist
        $adminRole = Role::firstOrCreate(['name' => 'admin']);

        // 3. Create the Super Admin User
        $admin = User::firstOrCreate(
            ['email' => 'admin@test.com'], // Check if email exists
            [
                'name' => 'Super Admin',
                'password' => Hash::make('password123'), // Change this immediately
                'status' => 1, // Active status we added earlier
            ]
        );

        // 4. Assign the role to the user
        $admin->assignRole($adminRole);
    }
}
