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
        Schema::create('phieu_nhap', function (Blueprint $table) {
    $table->id('id_phieu_nhap');
     $table->unsignedBigInteger('id_ncc')->nullable();
    $table->timestamp('ngay_nhap')->useCurrent();

    $table->unsignedBigInteger('id_ncc')->nullable();
    $table->decimal('tong_tien', 14, 0)->default(0);
    $table->text('ghi_chu')->nullable();

    $table->foreign('id_ncc')->references('id_ncc')->on('nha_cung_cap')->nullOnDelete();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('phieu_nhap');
    }
};
