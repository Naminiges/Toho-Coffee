<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Create default admin user
        User::create([
            'name' => 'Admin TOHO',
            'email' => 'admintoho@gmail.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'email_verified_at' => now(),
            'user_status' => 'aktif'
        ]);

        // Create default staff user
        User::create([
            'name' => 'Staff TOHO',
            'email' => 'stafftoho@gmail.com',
            'password' => Hash::make('staff123'),
            'role' => 'staff',
            'email_verified_at' => now(),
            'user_status' => 'aktif'
        ]);
    }
}
