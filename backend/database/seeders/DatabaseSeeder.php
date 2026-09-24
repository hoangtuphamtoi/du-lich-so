<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Tạo tài khoản Admin (Nếu chưa có thì tạo mới, có rồi thì bỏ qua)
        User::firstOrCreate(
            ['email' => 'admin@dulichso.com'],
            [
                'name' => 'Admin User',
                'password' => bcrypt('password123'),
            ]
        );

        // Tạo tài khoản Khách hàng
        User::firstOrCreate(
            ['email' => 'customer@dulichso.com'],
            [
                'name' => 'Customer User',
                'password' => bcrypt('password123'),
            ]
        );
    }
}