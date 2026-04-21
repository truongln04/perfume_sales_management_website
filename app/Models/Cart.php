<?php

namespace App\Models;
use App\Models\Account;
use App\Models\Product;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $table = 'gio_hang';
    protected $primaryKey = 'id_gh';
    public $timestamps = false; // nếu bảng không có created_at, updated_at

    protected $fillable = [
        'id_tai_khoan',
        'id_san_pham',
        'so_luong',
        'don_gia',
    ];

    // Quan hệ tới tài khoản
    public function account()
    {
        return $this->belongsTo(Account::class, 'id_tai_khoan', 'id_tai_khoan');
    }

    // Quan hệ tới sản phẩm
    public function product()
    {
        return $this->belongsTo(Product::class, 'id_san_pham', 'id_san_pham');
    }
}
