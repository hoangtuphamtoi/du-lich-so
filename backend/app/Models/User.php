<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Chỉ định tên cột mật khẩu tùy chỉnh cho Laravel Auth
     */
    public function getAuthPasswordName()
    {
        return 'password_hash';
    }

    /**
     * Trả về giá trị mật khẩu đã băm của User
     */
    public function getAuthPassword()
    {
        return $this->password_hash;
    }

    /**
     * Các trường được phép gán dữ liệu hàng loạt (Mass Assignment)
     */
    protected $fillable = [
        'name',
        'email',
        'password_hash',
        'role',
    ];

    /**
     * Các trường sẽ ẩn đi khi xuất dữ liệu ra JSON/API
     */
    protected $hidden = [
        'password_hash',
        'remember_token',
    ];

    /**
     * Ép kiểu dữ liệu
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
        ];
    }
}