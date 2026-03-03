<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        // The order matters!
        $this->call([
            RolePermissionSeeder::class, // 1. Roles
            AdminUserSeeder::class,      // 2. User (Admin)
            CategorySeeder::class,       // 3. Categories
            TransactionSeeder::class,    // 4. Transactions (Needs User & Categories)
        ]);
    }
}
