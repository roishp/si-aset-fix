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
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE saran_aset 
            MODIFY COLUMN status ENUM(
                'Menunggu',
                'Ditinjau',
                'Disetujui',
                'Ditolak'
            ) NOT NULL DEFAULT 'Menunggu'");
    }

    public function down(): void
    {
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE saran_aset 
            MODIFY COLUMN status ENUM(
                'Menunggu',
                'Disetujui',
                'Ditolak'
            ) NOT NULL DEFAULT 'Menunggu'");
    }
};
