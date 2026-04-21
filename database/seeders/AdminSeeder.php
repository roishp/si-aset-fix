<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Admin::create([
            'nama' => 'Admin Utama',
            'email' => 'adminSi-Aset@gmail.com',
            'password' => 'admin+62',
            'role' => 'admin_utama',
            'gedung_id' => null,
        ]);
    }
}
