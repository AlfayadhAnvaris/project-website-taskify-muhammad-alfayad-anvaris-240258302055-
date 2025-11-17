<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('admin'), // ganti password sesuai kebutuhan
                'role' => 'admin',
            ]
        );

        // User biasa
        User::updateOrCreate(
            ['email' => 'user1@example.com'],
            [
                'name' => 'User 1',
                'password' => Hash::make('password'),
                'role' => 'user',
            ]
        );

        User::updateOrCreate(
            ['email' => 'user2@example.com'],
            [
                'name' => 'User 2',
                'password' => Hash::make('password'),
                'role' => 'user',
            ]
        );
    }
}
