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
        Schema::create('gio_hang', function (Blueprint $table) {
    $table->id('id_gh');

    $table->unsignedBigInteger('id_tai_khoan');
    $table->unsignedBigInteger('id_san_pham');

    $table->integer('so_luong')->default(1);
    $table->decimal('don_gia', 12, 0);

    $table->unique(['id_tai_khoan', 'id_san_pham']);

    $table->foreign('id_tai_khoan')->references('id_tai_khoan')->on('tai_khoan')->cascadeOnDelete();
    $table->foreign('id_san_pham')->references('id_san_pham')->on('san_pham')->cascadeOnDelete();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gio_hang');
    }
};
