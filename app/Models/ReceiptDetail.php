<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
class ReceiptDetail extends Model
{
    protected $table = 'chi_tiet_phieu_nhap';
    protected $primaryKey = 'id_ctpn';
    public $timestamps = false;

    protected $fillable = [
        'id_phieu_nhap',
        'id_san_pham',
        'so_luong',
        'don_gia'
    ];

    public function product() {
        return $this->belongsTo(Product::class, 'id_san_pham', 'id_san_pham');
    }

    public function receipt() {
        return $this->belongsTo(Receipt::class, 'id_phieu_nhap', 'id_phieu_nhap');
    }
}
