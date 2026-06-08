<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        // 1. Akun Admin
        User::create([
            'name'     => 'Admin',
            'email'    => 'admin@gmail.com',
            'password' => Hash::make('admin123'),
            'role'     => 'admin', 
        ]);

        // 2. Akun Owner
        User::create([
            'name'     => 'Owner',
            'email'    => 'owner@gmail.com',
            'password' => Hash::make('owner123'),
            'role'     => 'owner',
        ]);

        // 3. Akun Kurir
        User::create([
            'name'     => 'Bang Kurir',
            'email'    => 'kurir@gmail.com',
            'password' => Hash::make('kurir123'),
            'role'     => 'kurir',
        ]);

        // 4. Akun Customer (Pelanggan Pertama buat Bahan Tes)
        // User::create([
        //     'name'     => 'Customer',
        //     'email'    => 'customer@gmail.com',
        //     'password' => Hash::make('customer123'),
        //     'role'     => 'user', 
        // ]);
    }
}