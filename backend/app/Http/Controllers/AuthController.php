<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash; // Import Facade Hash theo yêu cầu[cite: 3]

class AuthController extends Controller
{
    /**
     * 1. Khi tạo tài khoản (Đăng ký)
     */
    public function register(Request $request)
    {
        // Validate dữ liệu đầu vào
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
        ]);

        // Khi tạo tài khoản: Băm mật khẩu bằng Hash::make()[cite: 3]
        $user = User::create([
            'name'          => $request->name,
            'email'         => $request->email,
            'password_hash' => Hash::make($request->password), // Chuyển mật khẩu thô thành chuỗi băm có muối[cite: 3]
        ]);

        return response()->json([
            'message' => 'Tạo tài khoản thành công!',
            'user'    => $user
        ], 201);
    }

    /**
     * 2. Khi đăng nhập & Nâng cấp tham số băm
     */
    public function login(Request $request)
    {
        // Validate dữ liệu đầu vào
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        // Tìm người dùng theo email
        $user = User::where('email', $request->email)->first();

        // Khi đăng nhập: Kiểm tra mật khẩu bằng Hash::check()[cite: 3]
        if (!$user || !Hash::check($request->password, $user->password_hash)) { //[cite: 3]
            // Thông báo lỗi chung, không tiết lộ tài khoản có tồn tại hay không[cite: 3]
            return response()->json([
                'message' => 'Thông tin đăng nhập không đúng.' //[cite: 3]
            ], 401);
        }

        // Nâng cấp tham số băm khi đổi cấu hình trong config/hashing.php[cite: 3]
        if (Hash::needsRehash($user->password_hash)) { //[cite: 3]
            $user->update([
                'password_hash' => Hash::make($request->password) //[cite: 3]
            ]);
        }

        return response()->json([
            'message' => 'Đăng nhập thành công!',
            'user'    => $user
        ], 200);
    }
}