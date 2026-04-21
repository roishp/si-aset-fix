<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // === LAPORAN KERUSAKANS ===
        Schema::table('laporan_kerusakans', function (Blueprint $table) {
            $table->string('nim_nip', 50)->after('nama_pelapor')->nullable();
            $table->string('fakultas')->after('nim_nip')->nullable();
        });

        // Migrate old data: copy kontak_pelapor to nim_nip (if any)
        // Then drop old column
        Schema::table('laporan_kerusakans', function (Blueprint $table) {
            $table->dropColumn('kontak_pelapor');
        });

        // === SARAN ASET ===
        Schema::table('saran_aset', function (Blueprint $table) {
            $table->string('nim_nip', 50)->after('nama_pengusul')->nullable();
            $table->string('fakultas')->after('nim_nip')->nullable();
        });

        Schema::table('saran_aset', function (Blueprint $table) {
            $table->dropColumn('kontak');
        });
    }

    public function down(): void
    {
        Schema::table('laporan_kerusakans', function (Blueprint $table) {
            $table->string('kontak_pelapor')->nullable()->after('nama_pelapor');
            $table->dropColumn(['nim_nip', 'fakultas']);
        });

        Schema::table('saran_aset', function (Blueprint $table) {
            $table->string('kontak')->nullable()->after('nama_pengusul');
            $table->dropColumn(['nim_nip', 'fakultas']);
        });
    }
};
