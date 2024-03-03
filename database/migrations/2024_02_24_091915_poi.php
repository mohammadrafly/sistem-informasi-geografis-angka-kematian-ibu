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
        Schema::create('poi', function (Blueprint $table) {
            $table->id();
            $table->string('nama_titik')->nullable();
            $table->foreignId('id_kasus')->nullable()->constraint('kasus');
            $table->text('geojson');
            $table->foreignId('id_category')->constraint('category_poi');
            $table->string('warna');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('poi');
    }
};
