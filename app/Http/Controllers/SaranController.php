<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Saran;

class SaranController extends Controller
{
    // Ini untuk menyimpan data dari form kontak
    public function simpan(Request $request) {
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email',
            'pesan' => 'required|string',
        ]);

        Saran::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'pesan' => $request->pesan,
        ]);
        return back()->with('success', 'Pesan berhasil dikirim!');
    }

    // Ini untuk menampilkan data di halaman Admin
    public function index() {
        $semuaSaran = Saran::all();
        return view('admin-saran', ['daftarSaran' => $semuaSaran]);
    }
}