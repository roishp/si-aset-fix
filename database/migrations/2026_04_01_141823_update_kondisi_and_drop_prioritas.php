<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Update laporan_kerusakans
        Schema::table('laporan_kerusakans', function (Blueprint $table) {
            // First change enum to string to allow more values
            $table->string('kondisi')->change();
        });

        // Map existing 'Rusak Sedang' to 'Cukup' (if any)
        DB::table('laporan_kerusakans')
            ->where('kondisi', 'Rusak Sedang')
            ->update(['kondisi' => 'Cukup']);

        // Update saran_aset
        Schema::table('saran_aset', function (Blueprint $table) {
            if (Schema::hasColumn('saran_aset', 'prioritas')) {
                $table->dropColumn('prioritas');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('laporan_kerusakans', function (Blueprint $table) {
            // Revert back to original enum (might fail if new values exist)
            $table->enum('kondisi', ['Rusak Ringan', 'Rusak Sedang', 'Rusak Berat'])->change();
        });

        Schema::table('saran_aset', function (Blueprint $table) {
            $table->enum('prioritas', ['Rendah', 'Sedang', 'Tinggi'])->nullable();
        });
    }
};
