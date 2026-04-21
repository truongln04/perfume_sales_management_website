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
        Schema::create('san_pham', function (Blueprint $table) {
    $table->id('id_san_pham');
    $table->unsignedBigInteger('id_danh_muc');
    $table->unsignedBigInteger('id_thuong_hieu');
    $table->unsignedBigInteger('id_nha_cung_cap');
    $table->string('ten_san_pham');
    $table->text('mo_ta')->nullable();
    $table->text('hinh_anh')->nullable();
    // $table->decimal('gia_nhap', 12, 0)->default(0);
    $table->decimal('gia_ban', 12, 0)->default(0);
    $table->decimal('km_phan_tram', 5, 2)->default(0);
    // $table->integer('so_luong_ton')->default(0);
    // $table->boolean('trang_thai')->default(1);
    $table->tinyInteger('trang_thai')->unsigned()->default(1);
    $table->timestamp('ngay_tao')->useCurrent();

    $table->foreign('id_danh_muc')->references('id_danh_muc')->on('danh_muc')->nullOnDelete();
    $table->foreign('id_thuong_hieu')->references('id_thuong_hieu')->on('thuong_hieu')->nullOnDelete();
    $table->foreign('id_nha_cung_cap')->references('id_ncc')->on('nha_cung_cap')->nullOnDelete();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('san_pham');
    }
};
