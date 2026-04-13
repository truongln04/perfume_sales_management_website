<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'san_pham';
    protected $primaryKey = 'id_san_pham';

    protected $fillable = [
        'ten_san_pham',
        'mo_ta',
        'hinh_anh',
        'id_danh_muc',
        'id_thuong_hieu',
        'gia_nhap',
        'gia_ban',
        'km_phan_tram',
        'so_luong_ton',
        'trang_thai'
    ];

    public function danhMuc() {
        return $this->belongsTo(DanhMuc::class, 'id_danh_muc');
    }

    public function thuongHieu() {
        return $this->belongsTo(ThuongHieu::class, 'id_thuong_hieu');
    }
}