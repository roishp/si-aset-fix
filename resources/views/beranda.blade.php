@extends('layout')

@section('content')

    {{-- HERO SECTION: ARCHITECTURAL FUTURISM --}}
    <section class="relative min-h-screen flex items-center px-6 overflow-hidden pt-20">
        <div class="container mx-auto relative z-20">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
                <div class="lg:col-span-8 space-y-8">
                    <div class="inline-flex items-center gap-4 px-4 py-2 rounded-full glass-card border-white/5 animate-reveal">
                        <span class="w-2 h-2 rounded-full bg-[#D4AF37] animate-ping"></span>
                        <span class="text-[9px] font-black uppercase tracking-[0.4em] text-white/60">SI-ASET UGM v2.0</span>
                    </div>

                    <h1 class="text-6xl md:text-9xl font-syne font-black text-white leading-[0.85] tracking-tighter animate-reveal" style="animation-delay: 200ms;">
                        CORE <br>
                        <span class="text-[#D4AF37] opacity-90 italic tracking-normal">ASSET</span> <br>
                        PLANNER.
                    </h1>

                    <div class="max-w-md space-y-6 animate-reveal" style="animation-delay: 400ms;">
                        <p class="text-base md:text-lg text-white/40 leading-relaxed font-light border-l border-white/10 pl-6">
                            Punya keluhan kerusakan aset atau saran aset baru?<br>
                            Silakan klik tombol di bawah ini.
                        </p>
                        <div class="flex flex-wrap gap-4 pt-4">
                            <a href="{{ url('/katalog') }}" class="btn-premium">Lihat Katalog</a>
                        </div>
                    </div>
                </div>

                {{-- DECORATIVE ELEMENT (FUTURISTIC GRID) --}}
                <div class="hidden lg:block lg:col-span-4 relative h-[600px] animate-reveal" style="animation-delay: 600ms;">
                    <div class="absolute inset-0 glass-card rounded-[3rem] rotate-6 border-white/5 opacity-50"></div>
                    <div class="absolute inset-0 glass-card rounded-[3rem] -rotate-3 border-white/10 shadow-2xl flex items-center justify-center overflow-hidden">
                         <div class="absolute w-full h-1 bg-gradient-to-r from-transparent via-[#D4AF37]/50 to-transparent top-1/4 animate-pulse"></div>
                         <div class="absolute w-full h-1 bg-gradient-to-r from-transparent via-blue-500/30 to-transparent bottom-1/3 animate-pulse" style="animation-delay: 1s;"></div>
                         <div class="p-12 text-center">
                             <div class="text-8xl mb-4">🏛️</div>
                             <p class="text-[9px] font-black text-white/20 uppercase tracking-[1em]">Infrastruktur Kampus</p>
                         </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- STATS SECTION: DYNAMIC RELOADED --}}
    <div id="services" class="py-32 relative z-20">
        <div class="container mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-1px bg-white/5 rounded-[3rem] overflow-hidden border border-white/5 shadow-2xl">
                
                {{-- Box 1: Total Semua Laporan --}}
                <div class="p-16 bg-[#020617] group hover:bg-white/[0.02] transition-all duration-700">
                    <span class="text-[9px] font-black uppercase tracking-[0.4em] text-white/20 block mb-12 group-hover:text-[#D4AF37] transition-colors">Data Keseluruhan</span>
                    <div class="flex items-baseline gap-2 mb-4">
                        <h3 class="text-7xl font-outfit font-black text-white tracking-tighter">{{ $totalSemua }}</h3>
                        <span class="text-xl font-outfit font-black text-[#D4AF37]">+</span>
                    </div>
                    <p class="text-[10px] font-bold text-white/30 uppercase tracking-widest">Total Semua Laporan</p>
                    <div class="w-8 h-1 bg-white/5 mt-8 rounded-full group-hover:w-16 transition-all duration-500"></div>
                </div>

                {{-- Box 2: Total Laporan Kerusakan --}}
                <div class="p-16 bg-[#020617] group hover:bg-white/[0.02] transition-all duration-700 border-x border-white/5">
                    <span class="text-[9px] font-black uppercase tracking-[0.4em] text-white/20 block mb-12 group-hover:text-blue-400 transition-colors">Laporan Kerusakan</span>
                    <div class="flex items-baseline gap-2 mb-4">
                        <h3 class="text-7xl font-outfit font-black text-white tracking-tighter">{{ $totalLaporan }}</h3>
                        <span class="text-xl font-outfit font-black text-blue-400">🔧</span>
                    </div>
                    <p class="text-[10px] font-bold text-white/30 uppercase tracking-widest">Total Laporan Kerusakan</p>
                    <div class="w-8 h-1 bg-white/5 mt-8 rounded-full group-hover:w-16 transition-all duration-500"></div>
                </div>

                {{-- Box 3: Total Saran Aset --}}
                <div class="p-16 bg-[#020617] group hover:bg-white/[0.02] transition-all duration-700">
                    <span class="text-[9px] font-black uppercase tracking-[0.4em] text-white/20 block mb-12 group-hover:text-emerald-400 transition-colors">Saran Aset</span>
                    <div class="flex items-baseline gap-2 mb-4">
                        <h3 class="text-7xl font-outfit font-black text-white tracking-tighter">{{ $totalSaran }}</h3>
                        <span class="text-xl font-outfit font-black text-emerald-400">📦</span>
                    </div>
                    <p class="text-[10px] font-bold text-white/30 uppercase tracking-widest">Total Saran Aset</p>
                    <div class="w-8 h-1 bg-white/5 mt-8 rounded-full group-hover:w-16 transition-all duration-500"></div>
                </div>

            </div>
        </div>
    </div>

@endsection