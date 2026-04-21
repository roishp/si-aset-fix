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
        Schema::create('gedungs', function (Blueprint $table) {
            $table->id();
            $table->string('kode_aset')->unique();
            $table->string('nama');
            $table->string('kategori');
            $table->text('deskripsi');
            $table->string('lokasi')->nullable();
            $table->string('kondisi')->default('Kondisi Baik');
            $table->string('foto')->nullable();
            $table->integer('tahun_dibangun')->nullable();
            $table->string('luas_bangunan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gedungs');
    }
};
