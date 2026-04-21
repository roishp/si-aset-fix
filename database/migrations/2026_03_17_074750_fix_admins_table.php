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
        Schema::table('admins', function (Blueprint $table) {
            if (!Schema::hasColumn('admins', 'nama')) {
                $table->string('nama')->after('id');
            }
            if (!Schema::hasColumn('admins', 'email')) {
                $table->string('email')->unique()->after('nama');
            }
            if (!Schema::hasColumn('admins', 'password')) {
                $table->string('password')->after('email');
            }
            if (!Schema::hasColumn('admins', 'role')) {
                $table->enum('role', ['admin_utama', 'operator'])->after('password');
            }
            if (!Schema::hasColumn('admins', 'gedung_id')) {
                $table->unsignedBigInteger('gedung_id')->nullable()->after('role');
            }
            if (!Schema::hasColumn('admins', 'last_login')) {
                $table->timestamp('last_login')->nullable()->after('gedung_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('admins', function (Blueprint $table) {
            // No easy way to rollback a fix migration without risks
        });
    }
};
