@extends('layouts.admin')

@section('content')
    <!-- MODAL TAMBAH (CLEAN UI) -->
    <div id="modal-tambah" class="fixed inset-0 bg-[#020617]/95 backdrop-blur-2xl z-[99999] flex items-center justify-center p-4 md:p-6 hidden">
        <div class="glass-card w-full max-w-lg rounded-[3rem] shadow-2xl overflow-hidden animate-reveal border border-white/10 relative max-h-[90vh] overflow-y-auto">
            <div class="p-10 border-b border-white/5 flex justify-between items-center bg-white/5">
                <div class="space-y-1">
                    <h3 class="text-xl font-syne font-black text-white uppercase tracking-tight">Tambah Admin Baru</h3>
                    <p class="text-[9px] font-black text-white/30 uppercase tracking-[0.3em]">Pengaturan Hak Akses Sistem</p>
                </div>
                <button onclick="document.getElementById('modal-tambah').classList.add('hidden')" class="w-10 h-10 rounded-xl bg-white/5 flex items-center justify-center text-white/30 hover:text-white hover:bg-white/10 transition-all">✕</button>
            </div>
            
            <form action="{{ route('admin.management.store') }}" method="POST" class="p-10 space-y-8 bg-black/20">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-3">
                        <label class="text-[9px] font-black uppercase tracking-[0.4em] text-white/20 ml-1">Nama Lengkap</label>
                        <input type="text" name="nama" required class="w-full px-5 py-4 bg-white/5 border border-white/5 rounded-2xl text-sm font-bold text-white focus:ring-1 focus:ring-[#D4AF37] outline-none transition-all placeholder-white/5" placeholder="Contoh: Budi Santoso">
                    </div>
                    <div class="space-y-3">
                        <label class="text-[9px] font-black uppercase tracking-[0.4em] text-white/20 ml-1">Alamat Email</label>
                        <input type="email" name="email" required class="w-full px-5 py-4 bg-white/5 border border-white/5 rounded-2xl text-sm font-bold text-white focus:ring-1 focus:ring-[#D4AF37] outline-none transition-all placeholder-white/5" placeholder="email@ugm.ac.id">
                    </div>
                </div>

                <div class="space-y-3">
                    <label class="text-[9px] font-black uppercase tracking-[0.4em] text-white/20 ml-1">Kata Sandi</label>
                    <input type="password" name="password" required minlength="6" class="w-full px-5 py-4 bg-white/5 border border-white/5 rounded-2xl text-sm font-bold text-white focus:ring-1 focus:ring-[#D4AF37] outline-none transition-all" placeholder="Minimum 6 karakter">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-3">
                        <label class="text-[9px] font-black uppercase tracking-[0.4em] text-white/20 ml-1">Level Akses</label>
                        <select name="role" id="role-select" required onchange="toggleGedung(this.value)" class="w-full px-5 py-4 bg-white/5 border border-white/5 rounded-2xl text-sm font-bold text-white focus:ring-1 focus:ring-[#D4AF37] outline-none transition-all appearance-none cursor-pointer">
                            <option value="operator" class="bg-[#020617]">Admin Aktif</option>
                            <option value="admin_utama" class="bg-[#020617]">Administrator Utama</option>
                        </select>
                    </div>
                    <div class="space-y-3" id="gedung-wrapper">
                        <label class="text-[9px] font-black uppercase tracking-[0.4em] text-white/20 ml-1">Penempatan Unit</label>
                        <select name="gedung_id" class="w-full px-5 py-4 bg-white/5 border border-white/5 rounded-2xl text-sm font-bold text-white focus:ring-1 focus:ring-[#D4AF37] outline-none transition-all appearance-none cursor-pointer">
                            @foreach($gedungs as $gd)
                            <option value="{{ $gd->id }}" class="bg-[#020617]">{{ $gd->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="pt-6 flex flex-col md:flex-row gap-4">
                    <button type="button" onclick="document.getElementById('modal-tambah').classList.add('hidden')" class="w-full md:w-auto px-10 py-4 rounded-2xl text-[10px] font-black uppercase tracking-widest text-white/20 hover:text-white hover:bg-white/5 transition-all order-2 md:order-1">Batal</button>
                    <button type="submit" class="btn-premium w-full flex-grow order-1 md:order-2">Simpan Data Admin</button>
                </div>
            </form>
        </div>
    </div>

<div class="space-y-10 animate-reveal">
    {{-- BREADCRUMB --}}
    <nav aria-label="breadcrumb">
        <ol class="flex items-center space-x-3 text-[10px] font-black text-white/20 uppercase tracking-[0.4em]">
            <li><a href="{{ route('admin.dashboard') }}" class="hover:text-[#D4AF37] transition-colors">Dashboard Admin</a></li>
            <li>/</li>
            <li class="text-[#D4AF37]">Kelola Akun Admin</li>
        </ol>
    </nav>

    <!-- HEADER & ACTION -->
    <div class="flex flex-col md:flex-row justify-between items-end gap-6 mb-12">
        <div class="space-y-2">
            <h1 class="text-4xl md:text-5xl font-syne font-black text-white tracking-tighter">Kelola Akun Admin</h1>
            <div class="flex items-center gap-3">
                <span class="w-1.5 h-1.5 rounded-full bg-[#D4AF37] animate-ping"></span>
                <p class="text-[9px] font-black text-[#D4AF37] uppercase tracking-[0.3em]">Manajemen Identitas Administrator</p>
            </div>
        </div>
        <button onclick="document.getElementById('modal-tambah').classList.remove('hidden')" class="btn-premium flex items-center justify-center gap-3">
            <span>➕</span> Tambah Admin Baru
        </button>
    </div>

    <!-- TABLE LIST -->
    <div class="glass-card rounded-[2.5rem] border border-white/5 overflow-hidden shadow-none">
        <div class="p-8 border-b border-white/5 bg-white/5 flex items-center justify-between">
            <div class="flex items-center gap-4">
                <div class="w-10 h-10 bg-white/5 rounded-xl flex items-center justify-center text-xl">👤</div>
                <h2 class="text-lg font-syne font-black text-white tracking-tight">Daftar Admin Aktif</h2>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-separate border-spacing-y-0">
                <thead>
                    <tr class="text-[10px] font-black text-white/20 uppercase tracking-[0.4em] border-b border-white/5">
                        <th class="px-8 py-6">Identitas Admin</th>
                        <th class="px-8 py-6">Level Akses</th>
                        <th class="px-8 py-6">Unit Kerja / Gedung</th>
                        <th class="px-8 py-6">Sesi Terakhir</th>
                        <th class="px-8 py-6 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @foreach($admins as $adm)
                    <tr class="group hover:bg-white/[0.02] transition-colors">
                        <td class="px-8 py-6">
                            <div class="text-xs font-black text-white uppercase tracking-tight group-hover:text-blue-400 transition-colors">{{ $adm->nama }}</div>
                            <div class="text-[9px] font-bold text-white/20 uppercase tracking-widest mt-1">{{ $adm->email }}</div>
                        </td>
                        <td class="px-8 py-6">
                            @if($adm->role === 'admin_utama')
                                <span class="px-3 py-1 rounded-lg text-[8px] font-black uppercase tracking-widest bg-blue-500/10 text-blue-400 border border-blue-500/20 glow-blue-sm">Admin Utama</span>
                            @else
                                <span class="px-3 py-1 rounded-lg text-[8px] font-black uppercase tracking-widest bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">Admin Aktif</span>
                            @endif
                        </td>
                        <td class="px-8 py-6">
                            <div class="text-[10px] font-bold text-white/40 uppercase tracking-tight border-l border-white/10 pl-3">
                                {{ $adm->gedung ? $adm->gedung->nama : 'Pusat (Semua Unit)' }}
                            </div>
                        </td>
                        <td class="px-8 py-6">
                            <div class="text-[9px] font-black text-white/20 uppercase tracking-widest">
                                {{ $adm->last_login ? $adm->last_login->diffForHumans() : 'Belum Pernah Login' }}
                            </div>
                        </td>
                        <td class="px-8 py-6 text-right">
                            @if($adm->id !== session('admin_id'))
                            <form action="{{ route('admin.management.destroy', $adm->id) }}" method="POST" onsubmit="return confirm('Hapus admin ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-10 h-10 flex items-center justify-center rounded-xl bg-red-500/5 text-red-500/50 hover:bg-red-500 hover:text-white transition-all ml-auto">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </form>
                            @else
                            <span class="text-[9px] font-black text-[#D4AF37] uppercase tracking-widest italic opacity-50">Sesi Anda</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>


</div>

<script>
    function toggleGedung(role) {
        const wrapper = document.getElementById('gedung-wrapper');
        if (role === 'admin_utama') {
            wrapper.classList.add('opacity-30', 'pointer-events-none');
        } else {
            wrapper.classList.remove('opacity-30', 'pointer-events-none');
        }
    }
</script>
@endsection

