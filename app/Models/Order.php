<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'don_hang';
    protected $primaryKey = 'id_don_hang';
    public $timestamps = false;

    public function taiKhoan()
    {
        return $this->belongsTo(User::class, 'id_tai_khoan', 'id_tai_khoan');
    }

    public function chiTietDonHang()
    {
        return $this->hasMany(OrderDetail::class, 'id_don_hang', 'id_don_hang');
    }

public function details()
{
    return $this->hasMany(OrderDetail::class, 'id_don_hang', 'id_don_hang');
}

    protected $fillable = [
        'id_tai_khoan',
        'ngay_dat',
        'tong_tien',
        'phuong_thuc_tt',
        'trang_thai_tt',
        'trang_thai',
        'ho_ten_nhan',
        'sdt_nhan',
        'dia_chi_giao',
        'ghi_chu'
    ];

    protected $casts = [
        'ngay_dat' => 'datetime',
        'tong_tien' => 'decimal:0'
    ];

    protected $attributes = [
        'phuong_thuc_tt' => 'COD',
        'trang_thai_tt' => 'CHUA_THANH_TOAN',
        'trang_thai' => 'CHO_XAC_NHAN'
    ];

    const PAYMENT_METHOD_COD = 'COD';
    const PAYMENT_METHOD_ONLINE = 'ONLINE';

    const PAYMENT_STATUS_CHUA_THANH_TOAN = 'CHUA_THANH_TOAN';
    const PAYMENT_STATUS_DA_THANH_TOAN = 'DA_THANH_TOAN';
    const PAYMENT_STATUS_HOAN_TIEN = 'HOAN_TIEN';
    const PAYMENT_STATUS_DA_HOAN_TIEN = 'DA_HOAN_TIEN';

    const STATUS_CHO_XAC_NHAN = 'CHO_XAC_NHAN';
    const STATUS_DA_XAC_NHAN = 'DA_XAC_NHAN';
    const STATUS_DANG_GIAO = 'DANG_GIAO';
    const STATUS_HOAN_THANH = 'HOAN_THANH';
    const STATUS_TRA_HANG = 'TRA_HANG';
    const STATUS_HUY = 'HUY';

    public static function paymentStatusLabels()
    {
        return [
            self::PAYMENT_STATUS_CHUA_THANH_TOAN => 'Chưa thanh toán',
            self::PAYMENT_STATUS_DA_THANH_TOAN => 'Đã thanh toán',
            self::PAYMENT_STATUS_HOAN_TIEN => 'Hoàn tiền',
            self::PAYMENT_STATUS_DA_HOAN_TIEN => 'Đã hoàn tiền',
        ];
    }

    public static function statusLabels()
    {
        return [
            self::STATUS_CHO_XAC_NHAN => 'Chờ xác nhận',
            self::STATUS_DA_XAC_NHAN => 'Đã xác nhận',
            self::STATUS_DANG_GIAO => 'Đang giao',
            self::STATUS_HOAN_THANH => 'Hoàn thành',
            self::STATUS_TRA_HANG => 'Trả hàng',
            self::STATUS_HUY => 'Hủy',
        ];
    }
    
}
