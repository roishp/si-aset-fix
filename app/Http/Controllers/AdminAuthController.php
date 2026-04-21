<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class AdminAuthController extends Controller
{
    /**
     * Show the admin login form.
     */
    public function showLogin()
    {
        if (session('admin_logged_in')) {
            return redirect()->route('admin.dashboard');
        }
        return view('admin.login');
    }

    /**
     * Handle the admin login request.
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $admin = Admin::where('email', $request->email)->first();

        if ($admin && Hash::check($request->password, $admin->password)) {
            $admin->load('gedung');
            
            session([
                'admin_logged_in' => true,
                'admin_id' => $admin->id,
                'admin_nama' => $admin->nama,
                'admin_role' => $admin->role,
                'admin_gedung_id' => $admin->gedung_id,
                'admin_gedung_nama' => $admin->gedung ? $admin->gedung->nama : null,
                'admin_last_login' => $admin->last_login ? $admin->last_login->format('d M — H:i') : '-',
            ]);
            
            $admin->update(['last_login' => now()]);
            
            return redirect()->route('admin.dashboard');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah!'
        ])->withInput($request->only('email'));
    }

    /**
     * Log the admin out of the application.
     */
    public function logout()
    {
        session()->forget([
            'admin_logged_in',
            'admin_id', 
            'admin_nama',
            'admin_role',
            'admin_gedung_id'
        ]);
        
        return redirect()->route('admin.login');
    }
}
