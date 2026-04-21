<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasFactory;

    protected $table = 'chi_tiet_don_hang';
    protected $primaryKey = 'id_ctdh';
    public $timestamps = false;

    protected $fillable = [
        'id_don_hang',
        'id_san_pham',
        'so_luong',
        'don_gia'
    ];

    protected $casts = [
        'so_luong' => 'integer',
        'don_gia' => 'decimal:0'
    ];

    public function donHang()
    {
        return $this->belongsTo(Order::class, 'id_don_hang', 'id_don_hang');
    }

    public function sanPham()
    {
        return $this->belongsTo(Product::class, 'id_san_pham', 'id_san_pham');
    }
    
    public function product()
    {
        return $this->belongsTo(Product::class, 'id_san_pham', 'id_san_pham');
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'id_don_hang', 'id_don_hang');
    }
    public function getThanhTienAttribute()
    {
        return $this->so_luong * $this->don_gia;
    }
}
