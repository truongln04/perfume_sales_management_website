<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WarehouseItem extends Model
{
    protected $table = 'kho';
    protected $primaryKey = 'id_san_pham';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = ['id_san_pham','so_luong_nhap','so_luong_ban'];

    public function product() {
        return $this->belongsTo(Product::class, 'id_san_pham', 'id_san_pham');
    }

    public function getTonKhoHienTaiAttribute() {
        return ($this->so_luong_nhap ?? 0) - ($this->so_luong_ban ?? 0);
    }
}
