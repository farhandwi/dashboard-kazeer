<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Admin Utama',
            'email' => 'admin@kazeer.com',
            'password' => Hash::make('password_rahasia'),
            'role' => 'admin'
        ]);
    }
}