<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\Category;
use App\Models\Brand;
use App\Models\Supplier;
use App\Models\WarehouseItem;

class Product extends Model
{
    protected $table = 'san_pham';
    protected $primaryKey = 'id_san_pham';
    public $timestamps = false; // tắt timestamps
    protected $fillable = [
        'ten_san_pham',
        'mo_ta',
        'hinh_anh',
        'id_danh_muc',
        'id_thuong_hieu',
        'id_ncc',
        'gia_nhap',
        'gia_ban',
        'km_phan_tram',
        'so_luong_ton',
        'trang_thai'
    ];
    
    public static function boot() {
        parent::boot();

        static::created(function ($product) {
            WarehouseItem::create([
                'id_san_pham' => $product->id_san_pham,
                'so_luong_nhap' => 0,
                'so_luong_ban' => 0
            ]);
        });
    }



    public function category() {
        return $this->belongsTo(Category::class, 'id_danh_muc');
    }

    public function brand() {
        return $this->belongsTo(Brand::class, 'id_thuong_hieu');
    }

    // public function receipt() {
    //     return $this->belongsTo(Receipt::class, 'id_phieu_nhap');
    // }

    public function supplier() {
        return $this->belongsTo(Supplier::class, 'id_ncc', 'id_ncc');
    }


    // Quan hệ tới chi tiết phiếu nhập
    public function receiptDetails() {
        return $this->hasMany(ReceiptDetail::class, 'id_san_pham', 'id_san_pham');
    }

    // Quan hệ tới kho
    public function warehouse() {
        return $this->hasOne(WarehouseItem::class, 'id_san_pham', 'id_san_pham');
    }

    // Giá nhập: lấy từ phiếu nhập gần nhất
    public function getGiaNhapAttribute() {
        $detail = $this->receiptDetails()->latest('id_ctpn')->first();
        return $detail ? $detail->don_gia : null;
    }

    // Số lượng tồn: lấy từ kho
    public function getSoLuongTonAttribute() {
        return $this->warehouse ? $this->warehouse->ton_kho_hien_tai : 0;
    }
}