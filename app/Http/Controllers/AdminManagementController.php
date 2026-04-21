<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Gedung;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AdminManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $admins = Admin::with('gedung')->get();
        $gedungs = Gedung::all();
        
        return view('admin.management', compact('admins', 'gedungs'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:admins,email',
            'password' => 'required|min:6',
            'role' => 'required|in:admin_utama,operator',
            'gedung_id' => 'required_if:role,operator|nullable|exists:gedungs,id',
        ]);

        $data['password'] = Hash::make($data['password']);

        Admin::create($data);

        return redirect()->route('admin.management.index')->with('success', 'Admin/Operator berhasil ditambahkan.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $admin = Admin::findOrFail($id);

        if ($admin->id === session('admin_id')) {
            return back()->with('error', 'Anda tidak bisa menghapus akun sendiri!');
        }

        $admin->delete();

        return redirect()->route('admin.management.index')->with('success', 'Akun admin berhasil dihapus.');
    }
}
