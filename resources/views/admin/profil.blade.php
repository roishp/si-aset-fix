@extends('layouts.admin')

@section('content')
<div class="max-w-3xl mx-auto space-y-10 animate-reveal">
    {{-- BREADCRUMB --}}
    <nav aria-label="breadcrumb">
        <ol class="flex items-center space-x-3 text-[10px] font-black text-white/20 uppercase tracking-[0.4em]">
            <li><a href="{{ route('admin.dashboard') }}" class="hover:text-[#D4AF37] transition-colors">Dashboard Admin</a></li>
            <li>/</li>
            <li class="text-[#D4AF37]">Profil Admin</li>
        </ol>
    </nav>

    {{-- HEADER --}}
    <div class="space-y-2 mb-12">
        <h1 class="text-4xl font-syne font-black text-white tracking-tighter">Pengaturan Akun</h1>
        <div class="flex items-center gap-3">
            <span class="w-1.5 h-1.5 rounded-full bg-blue-500 animate-pulse"></span>
            <p class="text-[9px] font-black text-white/40 uppercase tracking-[0.3em]">Manajemen Identitas Admin</p>
        </div>
    </div>

    {{-- INFO AKUN (ELITE DISPLAY) --}}
    <div class="glass-card p-10 rounded-[3rem] border border-white/5 bg-white/[0.02]">
        <h2 class="text-xs font-syne font-black text-white mb-10 uppercase tracking-[0.2em] flex items-center gap-4">
            <span class="w-8 h-px bg-[#D4AF37]"></span>
            Profil Admin
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="space-y-4">
                <label class="block text-[9px] font-black text-white/20 uppercase tracking-[0.4em] ml-1">Alamat Email</label>
                <div class="bg-white/5 border border-white/5 p-5 rounded-2xl text-white/60 font-bold text-sm tracking-tight">{{ $admin->email }}</div>
            </div>
            <div class="space-y-4">
                <label class="block text-[9px] font-black text-white/20 uppercase tracking-[0.4em] ml-1">Level Akses</label>
                <div class="bg-white/5 border border-white/5 p-5 rounded-2xl flex items-center">
                    @if($admin->role === 'admin_utama')
                        <span class="px-3 py-1 rounded-lg text-[8px] font-black uppercase tracking-widest bg-blue-500/10 text-blue-400 border border-blue-500/20 glow-blue-sm">Admin Utama</span>
                    @else
                        <span class="px-3 py-1 rounded-lg text-[8px] font-black uppercase tracking-widest bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">Admin Aktif</span>
                    @endif
                </div>
            </div>
        </div>
        <p class="text-[9px] text-white/10 mt-8 italic font-black uppercase tracking-widest">Read-only system manifest</p>
    </div>

    {{-- FORM GANTI NAMA --}}
    <div class="glass-card p-10 rounded-[3rem] border border-white/5 bg-white/[0.02]">
        <h2 class="text-xs font-syne font-black text-white mb-10 uppercase tracking-[0.2em] flex items-center gap-4">
            <span class="w-8 h-px bg-[#D4AF37]"></span>
            Modifikasi Nama
        </h2>

        @if(session('success_nama'))
        <div class="bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 p-5 rounded-2xl mb-8 flex items-center gap-4 text-[10px] font-black uppercase tracking-widest animate-reveal">
            <span>✅</span> {{ session('success_nama') }}
        </div>
        @endif

        <form action="{{ route('admin.profil.nama') }}" method="POST">
            @csrf
            @method('PATCH')
            <div class="mb-10">
                <label class="block text-[9px] font-black text-white/20 uppercase tracking-[0.4em] mb-3 ml-1">Nama Lengkap</label>
                <input type="text" name="nama" value="{{ old('nama', $admin->nama) }}" class="w-full bg-white/5 border border-white/5 p-5 rounded-2xl focus:ring-1 focus:ring-[#D4AF37] outline-none transition-all text-sm font-bold text-white tracking-tight @error('nama') border-red-500/50 @enderror" required minlength="3">
                @error('nama')
                    <p class="text-red-500 text-[10px] font-bold mt-3 uppercase tracking-widest">{{ $message }}</p>
                @enderror
            </div>
            <button type="submit" class="btn-premium px-10">
                Simpan Perubahan
            </button>
        </form>
    </div>

    {{-- FORM GANTI PASSWORD --}}
    <div class="glass-card p-10 rounded-[3rem] border border-white/5 bg-white/[0.02]">
        <h2 class="text-xs font-syne font-black text-white mb-2 uppercase tracking-[0.2em] flex items-center gap-4">
            <span class="w-8 h-px bg-red-500"></span>
            Keamanan Akun
        </h2>
        <p class="text-[9px] font-black text-white/20 uppercase tracking-[0.3em] mb-10 ml-12">Rotation will terminate active session</p>

        @if($errors->has('password_lama'))
        <div class="bg-red-500/10 border border-red-500/20 text-red-500 p-5 rounded-2xl mb-8 flex items-center gap-4 text-[10px] font-black uppercase tracking-widest animate-reveal">
            <span>⚠️</span> {{ $errors->first('password_lama') }}
        </div>
        @endif

        <form action="{{ route('admin.profil.password') }}" method="POST">
            @csrf
            @method('PATCH')
            <div class="space-y-8">
                <div class="space-y-3">
                    <label class="block text-[9px] font-black text-white/20 uppercase tracking-[0.4em] ml-1">Password Saat Ini</label>
                    <input type="password" name="password_lama" class="w-full bg-white/5 border border-white/5 p-5 rounded-2xl focus:ring-1 focus:ring-red-500/50 outline-none transition-all text-sm font-bold text-white tracking-tight" required placeholder="Sandi lama">
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="space-y-3">
                        <label class="block text-[9px] font-black text-white/20 uppercase tracking-[0.4em] ml-1">Password Baru</label>
                        <input type="password" name="password_baru" class="w-full bg-white/5 border border-white/5 p-5 rounded-2xl focus:ring-1 focus:ring-red-500/50 outline-none transition-all text-sm font-bold text-white tracking-tight" required minlength="8" placeholder="Min. 8 karakter">
                        @error('password_baru')
                            <p class="text-red-500 text-[10px] font-bold mt-3 uppercase tracking-widest">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="space-y-3">
                        <label class="block text-[9px] font-black text-white/20 uppercase tracking-[0.4em] ml-1">Konfirmasi Password</label>
                        <input type="password" name="password_baru_confirmation" class="w-full bg-white/5 border border-white/5 p-5 rounded-2xl focus:ring-1 focus:ring-red-500/50 outline-none transition-all text-sm font-bold text-white tracking-tight" required placeholder="Ulangi sandi">
                    </div>
                </div>
            </div>
            <button type="submit" class="mt-12 w-full md:w-auto bg-red-500/10 hover:bg-red-500 text-red-500 hover:text-white border border-red-500/20 px-10 py-4 rounded-2xl font-black text-[10px] uppercase tracking-[0.2em] transition-all duration-500 shadow-xl shadow-red-500/5 glow-red-sm">
                Perbarui Keamanan Akun
            </button>
        </form>
    </div>

</div>
@endsection

