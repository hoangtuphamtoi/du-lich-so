<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Tạo tài khoản Admin
        User::firstOrCreate(
            ['email' => 'admin@dulichso.com'],
            [
                'name' => 'Admin User',
                'password' => 'password123', // Truyền chuỗi thường, Laravel 11 sẽ tự băm mật khẩu
            ]
        );

        // Tạo tài khoản Khách hàng
        User::firstOrCreate(
            ['email' => 'customer@dulichso.com'],
            [
                'name' => 'Customer User',
                'password' => 'password123',
            ]
        );
    }
}