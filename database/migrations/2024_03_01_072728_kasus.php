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
        Schema::create('kasus', function (Blueprint $table) {
            $table->id();
            $table->string('alamat');
            $table->string('usia_ibu');
            $table->string('tanggal');
            $table->foreignId('id_category')->constraint('category_penyebab');
            $table->string('bukti_kematian');
            $table->string('tempat_kematian');
            $table->string('estafet_rujukan');
            $table->string('alur');
            $table->string('masa_kematian');
            $table->string('hari_kematian');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kasus');
    }
};
