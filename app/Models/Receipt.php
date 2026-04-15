<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Supplier;
use App\Models\ReceiptDetail;
class Receipt extends Model
{
    protected $table = 'phieu_nhap';
    protected $primaryKey = 'id_phieu_nhap';
    protected $fillable = ['id_ncc','ngay_nhap','tong_tien','ghi_chu'];
    public $timestamps = false;

    // Quan hệ tới chi tiết phiếu nhập
    public function ReceiptDetails() {
        return $this->hasMany(ReceiptDetail::class, 'id_phieu_nhap', 'id_phieu_nhap');
    }

    // Quan hệ tới nhà cung cấp
    public function supplier() {
        return $this->belongsTo(Supplier::class, 'id_ncc', 'id_ncc');
    }
}