@extends('layout')

@section('content')
<div class="relative min-h-screen pt-24 pb-20 px-6">
    <div class="container mx-auto relative z-10">

        {{-- PAGE HEADER --}}
        <div class="flex flex-col md:flex-row justify-between items-start md:items-end gap-8 mb-16 animate-reveal">
            <div class="space-y-4">
                <div class="inline-flex items-center gap-3 px-3 py-1 rounded-full bg-[#D4AF37]/10 border border-[#D4AF37]/20">
                    <span class="w-1.5 h-1.5 rounded-full bg-[#D4AF37] animate-pulse"></span>
                    <span class="text-[9px] font-black uppercase tracking-[0.4em] text-[#D4AF37]">Katalog Utama</span>
                </div>
                <h2 class="text-5xl md:text-8xl font-syne font-black text-white tracking-tighter leading-none uppercase">KATALOG <br><span class="text-white/20 italic font-light tracking-normal">ASET.</span></h2>
                <p class="text-white/30 font-bold text-sm max-w-lg">Pilih gedung untuk mengakses data aset, melaporkan kerusakan, atau mengusulkan pengembangan infrastruktur.</p>
            </div>
            <a href="{{ url('/') }}" class="btn-premium px-8 py-4 rounded-2xl text-[10px]">
                ← Kembali ke Beranda
            </a>
        </div>

        {{-- SEARCH BAR --}}
        <div class="glass-card mb-16 rounded-[2.5rem] border-white/5 p-4 flex flex-col md:flex-row gap-4 items-center animate-reveal" style="animation-delay: 100ms;">
            <div class="relative flex-1 w-full">
                <span class="absolute inset-y-0 left-6 flex items-center text-white/20 text-xl">🔍</span>
                <input type="text" id="searchInput" placeholder="Cari nama gedung, fakultas, atau lokasi..."
                    class="w-full bg-white/5 border border-white/5 py-5 pl-16 pr-6 rounded-2xl outline-none focus:ring-1 focus:ring-[#D4AF37] transition-all font-bold text-sm text-white placeholder-white/20">
            </div>
            <div class="flex flex-col md:flex-row gap-3 w-full md:w-auto">
                <button onclick="filterAssets()" class="btn-premium px-8 py-5 rounded-2xl text-[10px] whitespace-nowrap">
                    CARI GEDUNG
                </button>
                <button id="btn-refresh" onclick="document.getElementById('searchInput').value=''; filterAssets();"
                    class="glass-card border-white/5 px-6 py-5 rounded-2xl text-[10px] font-black text-white/40 hover:text-white uppercase tracking-widest transition-all w-full md:w-auto flex items-center justify-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                            d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15">
                        </path>
                    </svg>
                    RESET
                </button>
            </div>
        </div>

        {{-- ASSET GRID --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 items-stretch">

            @foreach ($gedungs as $gedung)
            <div class="asset-card group glass-card rounded-[3rem] border-white/5 overflow-hidden hover:border-[#D4AF37]/30 transition-all duration-700 flex flex-col h-full hover:shadow-[0_40px_100px_rgba(0,0,0,0.5)] animate-reveal">
                <a href="{{ route('gedung.show', $gedung->id) }}" class="block relative overflow-hidden flex-shrink-0">
                    <div class="relative h-64">
                        @if($gedung->foto)
                            <img src="{{ asset(basename($gedung->foto)) }}"
                                class="w-full h-full object-cover grayscale-[0.2] group-hover:grayscale-0 group-hover:scale-110 transition-all duration-1000"
                                alt="{{ $gedung->nama }}"
                                onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                            <div class="hidden w-full h-full bg-[#020617] items-center justify-center text-[80px] opacity-10">🏛️</div>
                        @else
                            <div class="flex w-full h-full bg-[#020617] items-center justify-center text-[80px] opacity-10">🏛️</div>
                        @endif

                        <div class="absolute inset-0 bg-gradient-to-t from-[#020617] via-transparent to-transparent opacity-60"></div>



                        @if ($gedung->children_count > 0)
                            <div class="absolute bottom-6 left-6 glass-card border-white/10 text-white text-[9px] font-black px-4 py-2 rounded-xl tracking-widest uppercase flex items-center gap-2">
                                <span>📂</span> {{ $gedung->children_count }} Sub-Unit
                            </div>
                        @endif
                    </div>
                </a>

                <div class="p-10 flex flex-col flex-grow">
                    <span class="text-[#D4AF37] font-black text-[8px] uppercase tracking-[0.4em] block mb-3">{{ $gedung->kategori }}</span>
                    <a href="{{ route('gedung.show', $gedung->id) }}">
                        <h4 class="text-xl font-syne font-black text-white hover:text-[#D4AF37] transition-colors leading-[1.1] mb-4 uppercase tracking-tight">
                            {{ $gedung->nama }}
                        </h4>
                    </a>
                    <p class="text-white/30 text-[10px] leading-relaxed mb-8 italic line-clamp-2">"{{ $gedung->deskripsi }}"</p>

                    <div class="mt-auto pt-6 border-t border-white/5 flex items-center justify-between">
                        <a href="{{ route('gedung.show', $gedung->id) }}" class="text-[8px] font-black text-white uppercase tracking-[0.4em] flex items-center gap-3 group/btn">
                            Lihat Detail
                            <span class="w-6 h-px bg-white/10 group-hover/btn:w-10 group-hover/btn:bg-[#D4AF37] transition-all"></span>
                        </a>
                    </div>
                </div>
            </div>
            @endforeach

        </div>
    </div>
</div>

<script>
    function filterAssets() {
        const input = document.getElementById('searchInput');
        const filter = input.value.toLowerCase();
        const cards = document.getElementsByClassName('asset-card');

        for (let i = 0; i < cards.length; i++) {
            let title = cards[i].querySelector('h4').innerText.toLowerCase();
            let desc = cards[i].querySelector('p') ? cards[i].querySelector('p').innerText.toLowerCase() : '';

            if (title.indexOf(filter) > -1 || desc.indexOf(filter) > -1) {
                cards[i].style.display = "";
            } else {
                cards[i].style.display = "none";
            }
        }
    }

    document.getElementById('searchInput').addEventListener('keyup', filterAssets);
</script>

@endsection