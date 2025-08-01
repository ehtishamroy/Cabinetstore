<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Admin User
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@bhcabinetry.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Create Customer User
        User::create([
            'name' => 'John Customer',
            'email' => 'customer@example.com',
            'password' => Hash::make('password'),
            'role' => 'customer',
        ]);

        // Create a few more sample users
        User::create([
            'name' => 'Sarah Johnson',
            'email' => 'sarah@example.com',
            'password' => Hash::make('password'),
            'role' => 'customer',
        ]);

        User::create([
            'name' => 'Mike Wilson',
            'email' => 'mike@example.com',
            'password' => Hash::make('password'),
            'role' => 'customer',
        ]);
    }
}
