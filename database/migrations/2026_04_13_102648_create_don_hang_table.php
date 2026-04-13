<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('don_hang', function (Blueprint $table) {
    $table->id('id_don_hang');

    $table->unsignedBigInteger('id_tai_khoan');
    $table->timestamp('ngay_dat')->useCurrent();

    $table->decimal('tong_tien', 14, 0);

    $table->enum('phuong_thuc_tt', ['COD','ONLINE'])->default('COD');
    $table->enum('trang_thai_tt', ['Chưa thanh toán','Đã thanh toán','Hoàn tiền'])->default('Chưa thanh toán');

    $table->string('trang_thai')->default('Chờ xác nhận');

    $table->string('ho_ten_nhan')->nullable();
    $table->string('sdt_nhan')->nullable();
    $table->string('dia_chi_giao')->nullable();

    $table->text('ghi_chu')->nullable();

    $table->foreign('id_tai_khoan')->references('id_tai_khoan')->on('tai_khoan')->cascadeOnDelete();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('don_hang');
    }
};
