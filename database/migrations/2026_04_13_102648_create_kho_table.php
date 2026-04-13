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
        Schema::create('kho', function (Blueprint $table) {
    $table->unsignedBigInteger('id_san_pham')->primary();
    $table->integer('so_luong_nhap')->default(0);
    $table->integer('so_luong_ban')->default(0);

    $table->foreign('id_san_pham')->references('id_san_pham')->on('san_pham')->cascadeOnDelete();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kho');
    }
};
