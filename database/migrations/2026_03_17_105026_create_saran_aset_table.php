<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('saran_aset', function (Blueprint $table) {
            $table->id();
            $table->foreignId('gedung_id')->constrained('gedungs')->onDelete('cascade');
            $table->string('ruangan');
            $table->string('nama_aset');
            $table->integer('jumlah')->default(1);
            $table->text('alasan');
            $table->enum('prioritas', ['Rendah', 'Sedang', 'Tinggi']);
            $table->string('foto')->nullable();
            $table->string('nama_pengusul');
            $table->string('kontak')->nullable();
            $table->enum('status', ['Menunggu', 'Ditinjau', 'Disetujui', 'Ditolak'])->default('Menunggu');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('saran_aset');
    }
};
