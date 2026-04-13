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
        Schema::create('nha_cung_cap', function (Blueprint $table) {
    $table->id('id_ncc');
    $table->string('ten_ncc');
    $table->string('dia_chi')->nullable();
    $table->string('sdt', 30)->nullable();
    $table->string('email')->nullable();
    $table->text('ghi_chu')->nullable();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nha_cung_cap');
    }
};
