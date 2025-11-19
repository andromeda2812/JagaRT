<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'nama_lengkap' => 'Admin RT',
            'username' => 'adminrt',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'email' => 'admin@rt.local',
            'status' => 'aktif',
        ]);
    }
}