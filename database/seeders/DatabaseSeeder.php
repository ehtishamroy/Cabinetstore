<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create admin user
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@bhcabinetry.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Create a test customer
        User::create([
            'name' => 'Test Customer',
            'email' => 'customer@bhcabinetry.com',
            'password' => Hash::make('password'),
            'role' => 'customer',
        ]);
    }
}
