@extends('layout')

@section('content')
<div class="relative min-h-screen pt-24 pb-20 px-6">
    <div class="container mx-auto relative z-10">
        
        <div class="max-w-4xl mx-auto">
            {{-- PAGE HEADER & BACK BUTTON --}}
            <div class="flex flex-col md:flex-row justify-between items-end gap-8 mb-16 animate-reveal">
                <div class="space-y-4">
                    <div class="inline-flex items-center gap-3 px-3 py-1 rounded-full bg-blue-500/10 border border-blue-500/20">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-500 animate-pulse"></span>
                        <span class="text-[9px] font-black uppercase tracking-[0.4em] text-blue-400">Pengajuan Usulan Fasilitas</span>
                    </div>
                    <h2 class="text-5xl md:text-7xl font-syne font-black text-white tracking-tighter leading-none">USULKAN <br><span class="text-white/20 italic font-light tracking-normal">FASILITAS.</span></h2>
                </div>
                <a href="javascript:history.back()" class="px-8 py-4 rounded-2xl glass-card border-white/5 text-[10px] font-black uppercase tracking-widest text-white/40 hover:text-white transition-all group/back">
                     <span class="group-hover:-translate-x-2 transition-transform inline-block mr-2">←</span> Kembali
                </a>
            </div>

            @if(session('success'))
            <div class="glass-card p-8 rounded-[2.5rem] border-emerald-500/20 bg-emerald-500/5 mb-12 flex items-center gap-6 animate-reveal">
                <div class="w-14 h-14 bg-emerald-500/20 rounded-2xl flex items-center justify-center text-3xl">✅</div>
                <p class="font-syne font-black text-emerald-400 text-xl tracking-tight">{{ session('success') }}</p>
            </div>
            @endif

            @if($errors->any())
            <div class="glass-card p-8 rounded-[2.5rem] border-red-500/20 bg-red-500/5 mb-12 animate-reveal">
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-10 h-10 bg-red-500/20 rounded-xl flex items-center justify-center text-xl">⚠️</div>
                    <p class="font-syne font-black text-red-400 uppercase tracking-widest text-xs">Ada Kesalahan pada Form</p>
                </div>
                <ul class="space-y-2 ml-14">
                    @foreach($errors->all() as $error)
                        <li class="text-xs font-bold text-red-400/60 uppercase tracking-widest">• {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form action="{{ route('saran-aset.store') }}" method="POST" enctype="multipart/form-data" class="glass-card rounded-[4rem] border-white/5 overflow-hidden animate-reveal shadow-2xl" style="animation-delay: 200ms;">
                @csrf

                {{-- STEP 1: LOKASI --}}
                <div class="p-12 md:p-16 border-b border-white/5 relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-64 h-64 bg-blue-500 opacity-5 -mr-32 -mt-32 rounded-full blur-3xl"></div>
                    
                    <div class="flex items-center gap-6 mb-12">
                        <div class="w-12 h-12 bg-white/5 border border-white/10 rounded-2xl flex items-center justify-center font-black text-white/50 text-xl glow-white-sm">01</div>
                        <h3 class="text-xs font-syne font-black text-white uppercase tracking-[0.4em]">Pilih Lokasi Gedung</h3>
                    </div>

                    <div class="glass-card p-8 rounded-3xl border border-white/5 bg-white/[0.02] flex flex-col md:flex-row items-center justify-between gap-8 mb-10">
                        <div class="space-y-3">
                            <p class="text-[9px] font-black text-blue-400 uppercase tracking-[0.4em]">Detail Lokasi Target</p>
                            <h4 class="text-3xl font-syne font-black text-white tracking-tighter leading-none">{{ $gedung->nama }}</h4>
                            @if($gedung->parent)
                                <p class="text-[10px] font-black text-white/20 uppercase tracking-[0.2em] italic">Bagian dari: {{ $gedung->parent->nama }}</p>
                            @endif
                        </div>
                        <div class="text-6xl opacity-10">🏛️</div>
                    </div>
                    
                    <input type="hidden" name="gedung_id" value="{{ $gedung->id }}">

                    <div class="space-y-3">
                        <label class="block text-[9px] font-black text-white/20 uppercase tracking-[0.4em] ml-1">Ruangan / Zona</label>
                        <input type="text" name="ruangan" placeholder="Contoh: Lab 2.1, Koridor Utama, Sayap B" value="{{ old('ruangan') }}" class="w-full bg-white/5 border border-white/5 p-6 rounded-2xl focus:ring-1 focus:ring-blue-500 outline-none transition-all text-white font-bold text-sm" required>
                    </div>
                </div>

                {{-- STEP 2: DETAIL ASET --}}
                <div class="p-12 md:p-16 border-b border-white/5 bg-white/[0.01]">
                    <div class="flex items-center gap-6 mb-12">
                        <div class="w-12 h-12 bg-white/5 border border-white/10 rounded-2xl flex items-center justify-center font-black text-white/50 text-xl">02</div>
                        <h3 class="text-xs font-syne font-black text-white uppercase tracking-[0.4em]">Detail Aset Usulan</h3>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-10 mb-10">
                        <div class="md:col-span-2 space-y-3">
                            <label class="block text-[9px] font-black text-white/20 uppercase tracking-[0.4em] ml-1">Nama Aset yang Diusulkan</label>
                            <input type="text" name="nama_aset" placeholder="Contoh: Proyektor, Kursi Ergonomis" value="{{ old('nama_aset') }}" class="w-full bg-white/5 border border-white/5 p-6 rounded-2xl focus:ring-1 focus:ring-blue-500 outline-none transition-all text-white font-bold text-sm" required>
                        </div>
                        <div class="space-y-3">
                            <label class="block text-[9px] font-black text-white/20 uppercase tracking-[0.4em] ml-1">Jumlah</label>
                            <input type="number" name="jumlah" min="1" value="{{ old('jumlah', 1) }}" class="w-full bg-white/5 border border-white/5 p-6 rounded-2xl focus:ring-1 focus:ring-blue-500 outline-none transition-all text-white font-bold text-sm" required>
                        </div>
                    </div>

                    <div class="space-y-4 mb-10">
                        <label class="block text-[9px] font-black text-white/20 uppercase tracking-[0.4em] ml-1">Alasan Pengajuan</label>
                        <textarea name="alasan" rows="3" placeholder="Jelaskan mengapa aset ini dibutuhkan..." class="w-full bg-white/5 border border-white/5 p-6 rounded-2xl focus:ring-1 focus:ring-blue-500 outline-none transition-all text-white font-bold text-sm" required>{{ old('alasan') }}</textarea>
                    </div>

                    <div class="space-y-4">
                        <label class="block text-[9px] font-black text-white/20 uppercase tracking-[0.4em] ml-1">Bukti Foto Pendukung (Opsional)</label>
                        <div class="relative group">
                            <input type="file" name="foto" accept="image/*" class="w-full bg-white/5 border border-white/5 p-5 rounded-2xl text-[10px] text-white/40 font-black uppercase tracking-widest file:mr-6 file:py-2 file:px-6 file:rounded-xl file:border-0 file:text-[9px] file:font-black file:uppercase file:tracking-widest file:bg-white/10 file:text-white hover:file:bg-blue-500 hover:file:text-white transition-all">
                        </div>
                        <p class="text-[8px] font-black text-white/10 uppercase tracking-[0.3em] ml-1">FORMAT: JPG, PNG, WEBP • MAKS 10MB</p>
                    </div>
                </div>

                {{-- STEP 3: PELAPOR --}}
                <div class="p-12 md:p-16 relative overflow-hidden">
                    <div class="absolute bottom-0 left-0 w-64 h-64 bg-blue-500 opacity-5 -ml-32 -mb-32 rounded-full blur-3xl"></div>

                    <div class="flex items-center gap-6 mb-12">
                        <div class="w-12 h-12 bg-white/5 border border-white/10 rounded-2xl flex items-center justify-center font-black text-white/50 text-xl">03</div>
                        <h3 class="text-xs font-syne font-black text-white uppercase tracking-[0.4em]">Data Pengusul</h3>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-16">
                        <div class="space-y-3">
                            <label class="block text-[9px] font-black text-white/20 uppercase tracking-[0.4em] ml-1">Nama Lengkap</label>
                            <input type="text" name="nama_pengusul" value="{{ old('nama_pengusul') }}" placeholder="Nama Lengkap" class="w-full bg-white/5 border border-white/5 p-5 rounded-2xl focus:ring-1 focus:ring-blue-500 outline-none transition-all text-white font-bold text-sm" required>
                        </div>
                        <div class="space-y-3">
                            <label class="block text-[9px] font-black text-white/20 uppercase tracking-[0.4em] ml-1">NIP / NIM</label>
                            <input type="text" name="nim_nip" value="{{ old('nim_nip') }}" placeholder="Nomor Identitas (NIP/NIM)" class="w-full bg-white/5 border border-white/5 p-5 rounded-2xl focus:ring-1 focus:ring-blue-500 outline-none transition-all text-white font-bold text-sm" required>
                        </div>
                        <div class="space-y-3">
                            <label class="block text-[9px] font-black text-white/20 uppercase tracking-[0.4em] ml-1">Fakultas / Unit</label>
                            <select name="fakultas" class="w-full bg-white/5 border border-white/5 p-5 rounded-2xl focus:ring-1 focus:ring-blue-500 outline-none transition-all text-white font-bold text-sm appearance-none cursor-pointer" required>
                                <option value="" disabled {{ old('fakultas') ? '' : 'selected' }} class="bg-[#020617]">-- PILIH FAKULTAS --</option>
                                @foreach([
                                    'Fakultas Biologi', 'Fakultas Ekonomika dan Bisnis', 'Fakultas Filsafat',
                                    'Fakultas Geografi', 'Fakultas Hukum', 'Fakultas Ilmu Budaya',
                                    'Fakultas Ilmu Sosial dan Ilmu Politik', 'Fakultas Kedokteran',
                                    'Fakultas Kedokteran Gigi', 'Fakultas Kedokteran Hewan',
                                    'Fakultas Kehutanan', 'Fakultas MIPA', 'Fakultas Pertanian',
                                    'Fakultas Peternakan', 'Fakultas Psikologi', 'Fakultas Teknik',
                                    'Fakultas Teknologi Pertanian', 'Sekolah Vokasi', 'Sekolah Pascasarjana'
                                ] as $fak)
                                    <option value="{{ $fak }}" {{ old('fakultas') == $fak ? 'selected' : '' }} class="bg-[#020617]">{{ $fak }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <button type="submit" class="btn-premium w-full py-6 rounded-3xl text-lg flex items-center justify-center gap-6 group">
                        KIRIM USULAN ➕
                    </button>
                    <p class="text-center text-[9px] font-black text-white/10 uppercase tracking-[0.4em] mt-8">Usulan akan ditinjau oleh bagian terkait dalam siklus evaluasi standar.</p>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

