<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminProfilController extends Controller
{
    /**
     * Tampilkan halaman profil admin.
     */
    public function index()
    {
        $admin = \App\Models\Admin::find(session('admin_id'));
        return view('admin.profil', compact('admin'));
    }

    /**
     * Update nama admin.
     */
    public function updateNama(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|min:3|max:255',
        ], [
            'nama.required' => 'Nama tidak boleh kosong.',
            'nama.min' => 'Nama minimal 3 karakter.',
        ]);

        $admin = \App\Models\Admin::find(session('admin_id'));
        $admin->update(['nama' => $request->nama]);

        // Update session nama agar langsung berubah di navbar
        session(['admin_nama' => $admin->nama]);

        return back()->with('success_nama', 'Nama berhasil diubah.');
    }

    /**
     * Update password admin + logout paksa.
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'password_lama' => 'required',
            'password_baru' => 'required|string|min:8',
            'password_baru_confirmation' => 'required|same:password_baru',
        ], [
            'password_lama.required' => 'Password lama wajib diisi.',
            'password_baru.required' => 'Password baru wajib diisi.',
            'password_baru.min' => 'Password baru minimal 8 karakter.',
            'password_baru_confirmation.required' => 'Konfirmasi password wajib diisi.',
            'password_baru_confirmation.same' => 'Konfirmasi password tidak cocok.',
        ]);

        $admin = \App\Models\Admin::find(session('admin_id'));

        // Verifikasi password lama
        if (!Hash::check($request->password_lama, $admin->password)) {
            return back()->withErrors(['password_lama' => 'Password lama tidak sesuai.']);
        }

        $admin->update(['password' => Hash::make($request->password_baru)]);

        // Logout paksa (hapus session)
        session()->forget([
            'admin_logged_in',
            'admin_id', 
            'admin_nama',
            'admin_role',
            'admin_gedung_id'
        ]);

        return redirect()->route('admin.login')
            ->with('success', 'Password berhasil diubah. Silakan login kembali dengan password baru.');
    }
}
