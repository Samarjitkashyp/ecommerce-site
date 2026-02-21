<?php
// database/seeders/AdminUserSeeder.php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        // Create admin user
        User::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin User',
                'email' => 'admin@example.com',
                'phone' => '9876543210',
                'password' => Hash::make('admin123'),
                'is_active' => true,
                'is_admin' => true,
                'is_super_admin' => false,
                'role' => 'admin',
                'email_verified_at' => now(),
            ]
        );

        // Create super admin
        User::updateOrCreate(
            ['email' => 'superadmin@example.com'],
            [
                'name' => 'Super Admin',
                'email' => 'superadmin@example.com',
                'phone' => '9876543211',
                'password' => Hash::make('superadmin123'),
                'is_active' => true,
                'is_admin' => true,
                'is_super_admin' => true,
                'role' => 'super_admin',
                'email_verified_at' => now(),
            ]
        );

        // Create regular user for testing
        User::updateOrCreate(
            ['email' => 'user@example.com'],
            [
                'name' => 'Test User',
                'email' => 'user@example.com',
                'phone' => '9876543212',
                'password' => Hash::make('password'),
                'is_active' => true,
                'is_admin' => false,
                'role' => 'customer',
                'email_verified_at' => now(),
            ]
        );

        $this->command->info('✅ Users created successfully!');
    }
}