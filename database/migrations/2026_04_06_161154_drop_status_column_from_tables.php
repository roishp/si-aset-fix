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
        Schema::table('laporan_kerusakans', function (Blueprint $table) {
            if (Schema::hasColumn('laporan_kerusakans', 'status')) {
                $table->dropColumn('status');
            }
        });

        Schema::table('saran_aset', function (Blueprint $table) {
            if (Schema::hasColumn('saran_aset', 'status')) {
                $table->dropColumn('status');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('laporan_kerusakans', function (Blueprint $table) {
            $table->enum('status', ['Menunggu', 'Diproses', 'Selesai'])->default('Menunggu');
        });

        Schema::table('saran_aset', function (Blueprint $table) {
            $table->enum('status', ['Menunggu', 'Ditinjau', 'Disetujui', 'Ditolak'])->default('Menunggu');
        });
    }
};
