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
        Schema::create('chi_tiet_phieu_nhap', function (Blueprint $table) {
    $table->id('id_ctpn');

    $table->unsignedBigInteger('id_phieu_nhap');
    $table->unsignedBigInteger('id_san_pham')->nullable();

    $table->integer('so_luong');
    $table->decimal('don_gia', 12, 0);

    $table->foreign('id_phieu_nhap')->references('id_phieu_nhap')->on('phieu_nhap')->cascadeOnDelete();
    $table->foreign('id_san_pham')->references('id_san_pham')->on('san_pham')->nullOnDelete();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chi_tiet_phieu_nhap');
    }
};
