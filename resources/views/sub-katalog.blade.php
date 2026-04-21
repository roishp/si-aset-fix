@extends('layout')

@section('content')
<div class="relative min-h-screen pt-24 pb-20 px-6">
    <div class="container mx-auto relative z-10">
        
        {{-- TOP NAVIGATION & BREADCRUMBS --}}
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 mb-12 animate-reveal">
            <nav aria-label="breadcrumb">
                <ol class="flex items-center space-x-3 text-[9px] font-black text-white/20 uppercase tracking-[0.4em]">
                    <li><a href="{{ route('katalog.index') }}" class="hover:text-[#D4AF37] transition-colors">Katalog</a></li>
                    <li class="text-white/10">/</li>
                    @if ($gedung->parent)
                    <li><a href="{{ route('gedung.show', $gedung->parent->id) }}" class="hover:text-[#D4AF37] transition-colors">{{ $gedung->parent->nama }}</a></li>
                    <li class="text-white/10">/</li>
                    @endif
                    <li class="text-[#D4AF37]">{{ $gedung->nama }}</li>
                </ol>
            </nav>
            <a href="javascript:history.back()" class="px-6 py-3 rounded-xl glass-card border-white/5 text-[9px] font-black uppercase tracking-widest text-white/40 hover:text-white transition-all group/back">
                 <span class="group-hover:-translate-x-2 transition-transform inline-block mr-2">←</span> Kembali ke Katalog
            </a>
        </div>

        {{-- ARCHITECTURAL HEADER --}}
        <div class="mb-20 animate-reveal" style="animation-delay: 100ms;">
            <div class="flex flex-col lg:flex-row gap-16 items-start">
                {{-- Cinematic Hero Image --}}
                <div class="w-full lg:w-5/12 flex-shrink-0">
                    <div class="relative aspect-[4/5] rounded-[4rem] overflow-hidden shadow-[0_50px_100px_rgba(0,0,0,0.6)] border border-white/5 group">
                        @if($gedung->foto)
                            <img src="{{ asset(basename($gedung->foto)) }}" 
                                 class="w-full h-full object-cover grayscale-[0.3] group-hover:grayscale-0 transition-all duration-1000 group-hover:scale-105" 
                                 alt="{{ $gedung->nama }}"
                                 onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                            <div class="hidden w-full h-full bg-[#020617] items-center justify-center text-9xl opacity-20">🏛️</div>
                        @else
                            <div class="flex w-full h-full bg-[#020617] items-center justify-center text-9xl opacity-20">🏛️</div>
                        @endif
                        
                        <div class="absolute inset-0 bg-gradient-to-t from-[#020617] via-transparent to-transparent opacity-80"></div>
                        
                    </div>
                </div>

                <div class="flex-grow space-y-12">
                    <div class="space-y-6">
                        <span class="text-[#D4AF37] font-black text-[10px] uppercase tracking-[0.5em] block">{{ $gedung->kategori }}</span>
                        <h2 class="text-4xl lg:text-6xl font-syne font-black text-white tracking-tighter leading-none uppercase break-words">{{ $gedung->nama }}</h2>
                        <div class="w-24 h-px bg-white/10"></div>
                        <p class="text-white/40 font-light text-lg leading-relaxed max-w-2xl italic">"{{ $gedung->deskripsi }}"</p>
                    </div>

                    {{-- Dynamic Meta Info --}}
                    <div class="flex flex-wrap gap-10">
                        @foreach([
                            ['📍', 'Lokasi', $gedung->lokasi],
                            ['📅', 'Tahun Dibangun', $gedung->tahun_dibangun],
                            ['📐', 'Luas Bangunan', $gedung->luas_bangunan]
                        ] as $meta)
                            @if($meta[2])
                            <div class="space-y-2">
                                <p class="text-[8px] font-black text-white/20 uppercase tracking-[0.3em]">{{ $meta[1] }}</p>
                                <p class="text-white/60 text-xs font-bold flex items-center gap-2">
                                    <span class="opacity-30">{{ $meta[0] }}</span> {{ $meta[2] }}
                                </p>
                            </div>
                            @endif
                        @endforeach
                    </div>

                    {{-- AUTHORIZATION BOX (IF LEAF NODE) --}}
                    @if(!$gedung->children->count() > 0)
                    <div class="glass-card p-8 lg:p-10 rounded-[3rem] border-white/5 bg-white/[0.02] flex flex-col xl:flex-row items-center gap-6 shadow-2xl">
                         <div class="flex-grow space-y-2 text-center xl:text-left">
                             <h4 class="text-sm font-syne font-black text-white uppercase tracking-widest">Laporkan atau Usulkan Fasilitas</h4>
                             <p class="text-[10px] font-black text-white/40 uppercase tracking-widest leading-relaxed">Sampaikan kerusakan atau usulkan pengembangan fasilitas gedung ini</p>
                         </div>
                         <div class="flex flex-col sm:flex-row gap-4 justify-center w-full xl:w-auto">
                            <a href="{{ route('laporan.create', ['gedung_id' => $gedung->id]) }}" class="btn-premium px-8 py-4 text-[10px] whitespace-nowrap text-center">
                                Laporan Kerusakan →
                            </a>
                            <a href="{{ route('saran-aset.create', ['gedung_id' => $gedung->id]) }}" class="px-8 py-4 rounded-2xl glass-card border-white/10 text-[10px] font-black uppercase text-white/60 hover:text-white transition-all whitespace-nowrap text-center">
                                Usulkan Fasilitas
                            </a>
                         </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- BENTO STATISTICS GRID --}}
        @if(isset($stats) && !$punya_departemen)
        <div class="mb-20 animate-reveal" style="animation-delay: 200ms;">
            <div class="flex items-center gap-6 mb-10">
                <h3 class="text-[10px] font-syne font-black text-white uppercase tracking-[0.4em]">Ringkasan Fasilitas</h3>
                <div class="flex-grow h-px bg-white/5"></div>
            </div>
            
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-6">
                @foreach([
                    ['🚪', 'Ruang Kelas', $stats['ruang_kelas'], 'blue'],
                    ['🔬', 'Laboratorium', $stats['laboratorium'], 'emerald'],
                    ['🪑', 'Kursi', $stats['kursi'], 'amber'],
                    ['🖥️', 'Proyektor', $stats['proyektor'], 'purple'],
                    ['❄️', 'AC', $stats['ac'], 'cyan'],
                ] as $stat)
                <div class="glass-card p-8 rounded-[2.5rem] border-white/5 hover:border-{{ $stat[3] }}-500/30 transition-all group">
                    <div class="text-3xl mb-6 grayscale group-hover:grayscale-0 transition-all duration-500">{{ $stat[0] }}</div>
                    <div class="text-white font-outfit font-black text-4xl mb-1 tracking-tighter">{{ $stat[2] }}</div>
                    <div class="text-white/20 text-[8px] font-black uppercase tracking-widest group-hover:text-white/40 transition-colors">{{ $stat[1] }}</div>
                </div>
                @endforeach

                <div class="glass-card p-8 rounded-[2.5rem] border-[#D4AF37]/20 bg-[#D4AF37]/5 relative overflow-hidden group">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-[#D4AF37] opacity-10 -mr-16 -mt-16 rounded-full blur-2xl group-hover:scale-150 transition-all duration-1000"></div>
                    <div class="text-3xl mb-6 relative z-10">📦</div>
                    <div class="text-[#D4AF37] font-outfit font-black text-4xl mb-1 tracking-tighter relative z-10">{{ $stats['total_aset'] }}</div>
                    <div class="text-[#D4AF37]/40 text-[8px] font-black uppercase tracking-widest relative z-10">Total Aset</div>
                </div>
            </div>
        </div>
        @endif

        {{-- SUB-UNIT SECTOR GRID --}}
        @if ($gedung->children->count() > 0)
        <div class="animate-reveal" style="animation-delay: 300ms;">
            <div class="flex items-center gap-6 mb-10">
                <h3 class="text-[10px] font-syne font-black text-white uppercase tracking-[0.4em]">Fasilitas & Sub-Bagian</h3>
                <div class="flex-grow h-px bg-white/5"></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 items-stretch">
                @foreach ($gedung->children as $child)
                <div class="asset-card group glass-card rounded-[3rem] border-white/5 overflow-hidden hover:border-[#D4AF37]/30 transition-all duration-700 flex flex-col h-full hover:shadow-[0_40px_100px_rgba(0,0,0,0.5)]">
                    <a href="{{ route('gedung.show', $child->id) }}" class="block relative aspect-[16/10] overflow-hidden">
                        @if($child->foto)
                            <img src="{{ asset(basename($child->foto)) }}" 
                                 class="w-full h-full object-cover grayscale-[0.2] group-hover:grayscale-0 group-hover:scale-110 transition-all duration-1000" 
                                 alt="{{ $child->nama }}"
                                 onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                            <div class="hidden w-full h-full bg-[#020617] items-center justify-center text-6xl opacity-10">🏛️</div>
                        @else
                            <div class="flex w-full h-full bg-[#020617] items-center justify-center text-6xl opacity-10">🏛️</div>
                        @endif
                        

                    </a>

                    <div class="p-10 flex flex-col flex-grow relative">
                        <span class="text-[#D4AF37] font-black text-[8px] uppercase tracking-[0.4em] block mb-3">{{ $child->kategori }}</span>
                        <a href="{{ route('gedung.show', $child->id) }}">
                            <h4 class="text-xl font-syne font-black text-white hover:text-[#D4AF37] transition-colors leading-[1.1] mb-4 uppercase tracking-tight">{{ $child->nama }}</h4>
                        </a>
                        <p class="text-white/30 text-[10px] leading-relaxed mb-8 italic line-clamp-2">"{{ $child->deskripsi }}"</p>
                        
                        <div class="mt-auto pt-6 border-t border-white/5 flex items-center justify-between">
                             <a href="{{ route('gedung.show', $child->id) }}" class="text-[8px] font-black text-white uppercase tracking-[0.4em] flex items-center gap-3 group/btn">
                                 Lihat Fasilitas 
                                 <span class="w-6 h-px bg-white/10 group-hover/btn:w-10 group-hover/btn:bg-[#D4AF37] transition-all"></span>
                             </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @else
            {{-- Fallback UI for leaf nodes — redundant but styled --}}
        @endif

    </div>
</div>
@endsection
