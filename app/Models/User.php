<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Tên bảng trong database
     */
    protected $table = 'tai_khoan';

    /**
     * Khóa chính
     */
    protected $primaryKey = 'id_tai_khoan';

    public $timestamps = false;

    /**
     * Cho phép insert/update các cột này
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'email',
        'ten_hien_thi',
        'sdt',
        'google_id',
        'anh_dai_dien',
        'mat_khau',
        'vai_tro'
    ];

    /**
     * Ẩn khi trả dữ liệu
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'mat_khau'
    ];

    /**
     * Ép kiểu dữ liệu
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}