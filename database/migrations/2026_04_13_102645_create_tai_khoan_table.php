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
        Schema::create('tai_khoan', function (Blueprint $table) {
    $table->id('id_tai_khoan');
    $table->string('email')->unique();
    $table->string('ten_hien_thi')->nullable();
    $table->string('sdt', 10)->nullable();
    $table->string('google_id')->nullable();
    $table->text('anh_dai_dien')->nullable();
    $table->string('mat_khau')->nullable();
    $table->enum('vai_tro', ['admin','nhanvien','khachhang'])->default('khachhang');
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tai_khoan');
    }
};
