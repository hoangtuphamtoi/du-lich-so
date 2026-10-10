<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class EnsureRole
{
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = $request->user();

        // 1. Chưa đăng nhập -> Chuyển về trang Login
        if (!$user) {
            return redirect()->route('login')->with('error', 'Vui lòng đăng nhập tài khoản Quản trị.');
        }

        $userRole = strtolower(trim((string) ($user->role ?? '')));
        $allowedRoles = array_map(fn($role) => strtolower(trim($role)), $roles);

        // 2. Nếu route không yêu cầu role cụ thể thì cho qua
        if (empty($roles)) {
            return $next($request);
        }

        // 3. Nếu role không hợp lệ (ví dụ: customer cố vào trang admin)
        if (!in_array($userRole, $allowedRoles, true)) {
            Log::warning('Truy cap trai phep', [
                'user_id' => $user->id,
                'role'    => $user->role,
                'path'    => $request->path(),
            ]);

            // Nếu là tài khoản thường truy cập trang Admin -> Đẩy về trang chủ kèm thông báo
            if ($userRole !== 'admin' && in_array('admin', $allowedRoles, true)) {
                return redirect('/')->with('error', 'Tài khoản của bạn không có quyền truy cập trang Quản trị.');
            }

            abort(403, 'Khong du quyen truy cap.');
        }

        return $next($request);
    }
}