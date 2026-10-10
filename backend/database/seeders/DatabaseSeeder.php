<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Tạo tài khoản Admin
        User::firstOrCreate(
            ['email' => '24108702@st.phenikaa-uni.edu.vn'],
            [
                'name'          => 'Admin User',
                'password_hash' => Hash::make('12345678'),
                'role'          => 'admin',
            ]
        );

        // Tạo tài khoản Khách hàng
        User::firstOrCreate(
            ['email' => 'customer@dulichso.com'],
            [
                'name'          => 'Customer User',
                'password_hash' => Hash::make('12345678'),
                'role'          => 'user',
            ]
        );
    }
}