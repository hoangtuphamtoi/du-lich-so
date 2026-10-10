<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminUserController extends Controller
{
    // Danh sách người dùng
    public function index()
    {
        $users = User::orderBy('id', 'desc')->get();
        return view('admin.users.index', compact('users'));
    }

    // Cập nhật mật khẩu mới cho người dùng
    public function updatePassword(Request $request, $id)
    {
        $request->validate([
            'password' => 'required|string|min:6|confirmed',
        ], [
            'password.required' => 'Vui lòng nhập mật khẩu mới.',
            'password.min' => 'Mật khẩu phải có ít nhất 6 ký tự.',
            'password.confirmed' => 'Mật khẩu xác nhận không khớp.',
        ]);

        $user = User::findOrFail($id);
        $user->password = Hash::make($request->password);
        $user->save();

        return back()->with('success', "Đã đổi mật khẩu cho tài khoản {$user->name} thành công!");
    }

    // Xóa người dùng
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        
        // Không cho phép tự xóa chính mình
        if (auth()->id() == $user->id) {
            return back()->with('error', 'Bạn không thể tự xóa tài khoản của chính mình!');
        }

        $user->delete();
        return back()->with('success', 'Đã xóa người dùng thành công!');
    }
}