@extends('layouts.admin')

@section('content')
<div class="space-y-12 animate-reveal">
    {{-- HEADER DASHBOARD --}}
    <div class="flex flex-col md:flex-row justify-between items-end gap-6 mb-8">
        <div>
            <div class="flex items-center gap-4 mb-2">
                <h1 class="text-4xl md:text-5xl font-syne font-black text-white tracking-tighter">Dashboard Utama</h1>
                <button onclick="refreshDashboard()" id="btn-refresh" class="w-10 h-10 flex items-center justify-center rounded-xl bg-white/5 hover:bg-white/10 border border-white/5 transition-all group">
                    <span class="text-lg block group-active:scale-90 transition-transform text-white/50 group-hover:text-white">🔄</span>
                </button>
            </div>
            <div class="flex items-center gap-3">
                <div class="flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                    <p class="text-[10px] font-black text-emerald-500 uppercase tracking-[0.3em]">Sinkronisasi Aktif</p>
                </div>
                <span id="last-update" class="text-[9px] font-bold text-white/30 uppercase tracking-widest border-l border-white/10 pl-3">Sinkronisasi pada {{ now()->format('H:i:s') }}</span>
            </div>
        </div>
        <div class="flex flex-wrap gap-3">
            <a href="https://docs.google.com/spreadsheets/d/{{ config('google.spreadsheet_id') }}" target="_blank" class="bg-white/5 hover:bg-white/10 text-white px-6 py-3 rounded-2xl font-black text-[10px] uppercase tracking-widest border border-white/10 transition-all flex items-center gap-2">
                📊 Spreadsheet Database
            </a>
        </div>
    </div>

    {{-- BENTO GRID STATS --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        {{-- KARTU UTAMA (LAPORAN) --}}
        <div class="md:col-span-2 glass-card p-10 rounded-[2.5rem] relative overflow-hidden group border border-white/10">
            <div class="absolute top-0 right-0 w-64 h-64 bg-blue-500/5 rounded-full blur-[80px] -mr-32 -mt-32"></div>
            <div class="relative z-10 flex flex-col justify-between h-full">
                <div class="flex justify-between items-start mb-12">
                    <div class="w-16 h-16 bg-gradient-to-br from-white/10 to-white/5 rounded-2xl flex items-center justify-center text-3xl border border-white/10 shadow-inner">
                        📉
                    </div>
                    <span class="text-[10px] font-black text-blue-400 bg-blue-500/10 px-3 py-1 rounded-full uppercase tracking-widest border border-blue-500/20">Laporan Masuk</span>
                </div>
                <div>
                    <p class="text-xs font-black text-white/40 uppercase tracking-[0.4em] mb-4">Total Kerusakan Terdata</p>
                    <div class="flex items-baseline gap-4">
                        <div id="total-laporan" class="text-7xl md:text-9xl font-syne font-black text-white tracking-tighter leading-none">{{ $totalLaporan }}</div>
                        <div class="text-emerald-500 font-black text-sm flex items-center gap-1">
                            <span>↑</span> 12% <span class="text-white/20 text-[10px] tracking-normal font-normal">dari minggu lalu</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- KARTU KEDUA (SARAN) --}}
        <div class="glass-card p-10 rounded-[2.5rem] relative overflow-hidden group border border-white/10 flex flex-col justify-between">
            <div class="absolute bottom-0 left-0 w-64 h-64 bg-yellow-500/5 rounded-full blur-[80px] -ml-32 -mb-32"></div>
            <div class="relative z-10">
                <div class="w-16 h-16 bg-gradient-to-br from-[#F9C11C]/20 to-transparent rounded-2xl flex items-center justify-center text-3xl border border-[#F9C11C]/20 mb-12">
                    ✨
                </div>
                <p class="text-xs font-black text-white/40 uppercase tracking-[0.3em] mb-4">Usulan Aset Baru</p>
                <div id="total-saran" class="text-6xl md:text-7xl font-syne font-black text-[#F9C11C] tracking-tighter leading-none">{{ $totalSaran }}</div>
            </div>
            <div class="relative z-10 mt-8 pt-6 border-t border-white/5">
                <p class="text-[9px] text-white/30 font-bold uppercase tracking-widest leading-loose">Menunggu proses audit oleh divisi pengadaan internal.</p>
            </div>
        </div>
    </div>

    {{-- SECOND LAYER BENTO (KATEGORI) --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
        {{-- TABEL REKAP KATEGORI (KERUSAKAN) --}}
        <div class="glass-card rounded-[2.5rem] border border-white/5 overflow-hidden">
            <div class="p-8 border-b border-white/5 flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 bg-white/5 rounded-xl flex items-center justify-center text-xl">📊</div>
                    <h3 class="text-lg font-syne font-black text-white tracking-tight">Kategori Barang Rusak</h3>
                </div>
            </div>
            <div class="p-4 md:p-8">
                <div class="space-y-4">
                    @foreach($rekapKategori as $kat)
                    <div class="group flex items-center justify-between p-4 rounded-2xl hover:bg-white/5 transition-all border border-transparent hover:border-white/5">
                        <div class="flex items-center gap-6">
                            <div class="w-12 h-12 flex items-center justify-center text-2xl bg-white/5 rounded-xl font-syne font-black text-white">
                                {{ $kat->total }}
                            </div>
                            <div>
                                <p class="text-sm font-black text-white tracking-tight">{{ $kat->kategori }}</p>
                                <div class="flex gap-2 mt-1">
                                    <span class="text-[9px] font-bold text-red-500 uppercase tracking-tighter">{{ $kat->berat }} Rusak Berat</span>
                                    <span class="text-[9px] font-bold text-white/20 uppercase tracking-tighter">•</span>
                                    <span class="text-[9px] font-bold text-emerald-500 uppercase tracking-tighter">{{ $kat->sangat_baik }} Sangat Baik</span>
                                </div>
                            </div>
                        </div>
                        <div class="flex -space-x-2">
                             <div class="w-8 h-8 rounded-full bg-red-500/20 border-2 border-[#020617] flex items-center justify-center text-[9px] font-black text-red-400 group-hover:scale-110 transition-transform">{{ $kat->berat }}</div>
                             <div class="w-8 h-8 rounded-full bg-emerald-500/20 border-2 border-[#020617] flex items-center justify-center text-[9px] font-black text-emerald-400 group-hover:scale-110 transition-transform">{{ $kat->sangat_baik }}</div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- TABEL KATEGORI (SARAN) --}}
        <div class="glass-card rounded-[2.5rem] border border-white/5 overflow-hidden">
            <div class="p-8 border-b border-white/5 flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 bg-white/5 rounded-xl flex items-center justify-center text-xl">💡</div>
                    <h3 class="text-lg font-syne font-black text-white tracking-tight">Kategori Barang Diusulkan</h3>
                </div>
            </div>
            <div class="p-4 md:p-8">
                <div class="space-y-4">
                    @foreach($kategoriSaran as $ks)
                    <div class="group flex items-center justify-between p-4 rounded-2xl hover:bg-white/5 transition-all border border-transparent hover:border-white/5">
                        <div class="flex items-center gap-6">
                            <div class="w-12 h-12 flex items-center justify-center text-2xl bg-white/5 rounded-xl font-syne font-black text-[#F9C11C]">
                                {{ $ks->total_request }}
                            </div>
                            <div>
                                <p class="text-sm font-black text-white tracking-tight">{{ $ks->nama_aset }}</p>
                                <div class="flex gap-2 mt-1">
                                    <span class="text-[9px] font-bold text-white/50 uppercase tracking-tighter">Total Item Diminta: <span class="text-yellow-400">{{ $ks->total_jumlah }}</span></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    {{-- THIRD LAYER BENTO (FAKULTAS/GEDUNG) --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-12">
        {{-- TABEL REKAP GEDUNG (KERUSAKAN) --}}
        <div class="glass-card rounded-[2.5rem] border border-white/5 overflow-hidden">
            <div class="p-8 border-b border-white/5 flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 bg-white/5 rounded-xl flex items-center justify-center text-xl">🏢</div>
                    <h3 class="text-lg font-syne font-black text-white tracking-tight">Total Lokasi Laporan Kerusakan</h3>
                </div>
            </div>
            <div class="p-4 md:p-8">
                <div class="space-y-4">
                    @foreach($rekapGedung as $rekGd)
                    <div class="flex items-center justify-between p-4 rounded-2xl hover:bg-white/5 transition-all border border-transparent hover:border-white/5 group">
                        <div class="flex items-center gap-4">
                            <div class="w-2 h-8 bg-blue-500/20 rounded-full group-hover:bg-blue-500 transition-all"></div>
                            <a href="{{ url('/katalog/'.$rekGd->gedung->id) }}" class="text-sm font-black text-white hover:text-blue-400 transition-colors" target="_blank">{{ $rekGd->gedung->nama }}</a>
                        </div>
                        <div class="text-right">
                            <p class="text-lg font-syne font-black text-white leading-none">{{ $rekGd->total }}</p>
                            <p class="text-[8px] font-bold text-white/30 uppercase tracking-widest mt-1">Total Laporan</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- TABEL REKAP GEDUNG (SARAN) --}}
        <div class="glass-card rounded-[2.5rem] border border-white/5 overflow-hidden">
            <div class="p-8 border-b border-white/5 flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 bg-white/5 rounded-xl flex items-center justify-center text-xl">🏗️</div>
                    <h3 class="text-lg font-syne font-black text-white tracking-tight">Total Lokasi Saran Aset Baru</h3>
                </div>
            </div>
            <div class="p-4 md:p-8">
                <div class="space-y-4">
                    @foreach($rekapGedungSaran as $rgs)
                    <div class="flex items-center justify-between p-4 rounded-2xl hover:bg-white/5 transition-all border border-transparent hover:border-white/5 group">
                        <div class="flex items-center gap-4">
                            <div class="w-2 h-8 bg-yellow-500/20 rounded-full group-hover:bg-yellow-500 transition-all"></div>
                            <a href="{{ url('/katalog/'.$rgs->gedung->id) }}" class="text-sm font-black text-white hover:text-yellow-400 transition-colors" target="_blank">{{ $rgs->gedung->nama }}</a>
                        </div>
                        <div class="text-right">
                            <p class="text-lg font-syne font-black text-white leading-none">{{ $rgs->total }}</p>
                            <p class="text-[8px] font-bold text-white/30 uppercase tracking-widest mt-1">Total Usulan</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-8 mb-8 md:mb-12">
        {{-- LOKASI TERSERING RUSAK --}}
        <div class="glass-card rounded-[3rem] border border-red-500/5 overflow-hidden relative">
            <div class="absolute top-0 right-0 w-full h-full bg-gradient-to-br from-red-500/0 to-red-500/[0.02] pointer-events-none"></div>
            <div class="p-10 border-b border-white/5 flex items-center gap-6">
                <div class="w-14 h-14 bg-red-500/10 rounded-2xl flex items-center justify-center text-3xl shadow-lg shadow-red-500/10 border border-red-500/20 animate-pulse">🚨</div>
                <div>
                    <h3 class="text-2xl font-syne font-black text-white tracking-tight">Lokasi Tersering Laporan Kerusakan</h3>
                    <p class="text-[10px] text-red-400 font-bold uppercase tracking-[0.3em]">Berdasarkan Frekuensi Laporan Tertinggi</p>
                </div>
            </div>
            <div class="p-4 md:p-10 overflow-x-auto">
                <table class="w-full text-left border-separate border-spacing-y-4">
                    <thead>
                        <tr class="text-[10px] font-black text-white/20 uppercase tracking-[0.4em]">
                            <th class="px-6 pb-2">Fakultas / Gedung</th>
                            <th class="px-6 pb-2">Ruangan</th>
                            <th class="px-6 pb-2">Item Rusak</th>
                            <th class="px-6 pb-2 text-right">Frekuensi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($ruanganKritis as $rk)
                        <tr class="group hover:bg-white/5 transition-all">
                            <td class="px-6 py-6 rounded-l-3xl bg-white/[0.02] border-l border-y border-white/5">
                                <span class="text-[11px] font-black text-white group-hover:text-blue-300 transition-colors uppercase">{{ $rk->gedung->nama }}</span>
                            </td>
                            <td class="px-6 py-6 bg-white/[0.02] border-y border-white/5">
                                <span class="font-mono text-xs text-white/40 tracking-tighter">{{ $rk->ruangan }}</span>
                            </td>
                            <td class="px-6 py-6 bg-white/[0.02] border-y border-white/5">
                                <span class="text-[10px] font-black text-red-400 border border-red-500/20 bg-red-500/5 px-3 py-1 rounded-lg">
                                    {{ $rk->sub_item }}
                                </span>
                            </td>
                            <td class="px-6 py-6 rounded-r-3xl bg-white/[0.02] border-r border-y border-white/5 text-right font-syne font-black text-white text-xl">
                                {{ $rk->total }}<span class="text-[10px] text-white/20 ml-1 italic font-normal tracking-normal">laporan</span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{-- LOKASI TERSERING SARAN ASET --}}
        <div class="glass-card rounded-[3rem] border border-yellow-500/5 overflow-hidden relative">
            <div class="absolute top-0 right-0 w-full h-full bg-gradient-to-br from-yellow-500/0 to-yellow-500/[0.02] pointer-events-none"></div>
            <div class="p-10 border-b border-white/5 flex items-center gap-6">
                <div class="w-14 h-14 bg-yellow-500/10 rounded-2xl flex items-center justify-center text-3xl shadow-lg shadow-yellow-500/10 border border-yellow-500/20 animate-pulse">🌟</div>
                <div>
                    <h3 class="text-2xl font-syne font-black text-white tracking-tight">Lokasi Tersering Usulan Aset</h3>
                    <p class="text-[10px] text-yellow-400 font-bold uppercase tracking-[0.3em]">Berdasarkan Frekuensi Usulan Tertinggi</p>
                </div>
            </div>
            <div class="p-4 md:p-10 overflow-x-auto">
                <table class="w-full text-left border-separate border-spacing-y-4">
                    <thead>
                        <tr class="text-[10px] font-black text-white/20 uppercase tracking-[0.4em]">
                            <th class="px-6 pb-2">Fakultas / Gedung</th>
                            <th class="px-6 pb-2">Ruangan</th>
                            <th class="px-6 pb-2">Item Diusulkan</th>
                            <th class="px-6 pb-2 text-right">Frekuensi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($ruanganKritisSaran as $rks)
                        <tr class="group hover:bg-white/5 transition-all">
                            <td class="px-6 py-6 rounded-l-3xl bg-white/[0.02] border-l border-y border-white/5">
                                <span class="text-[11px] font-black text-white group-hover:text-yellow-300 transition-colors uppercase">{{ $rks->gedung->nama }}</span>
                            </td>
                            <td class="px-6 py-6 bg-white/[0.02] border-y border-white/5">
                                <span class="font-mono text-xs text-white/40 tracking-tighter">{{ $rks->ruangan }}</span>
                            </td>
                            <td class="px-6 py-6 bg-white/[0.02] border-y border-white/5">
                                <span class="text-[10px] font-black text-yellow-400 border border-yellow-500/20 bg-yellow-500/5 px-3 py-1 rounded-lg">
                                    {{ $rks->nama_aset }}
                                </span>
                            </td>
                            <td class="px-6 py-6 rounded-r-3xl bg-white/[0.02] border-r border-y border-white/5 text-right font-syne font-black text-white text-xl">
                                {{ $rks->total }}<span class="text-[10px] text-white/20 ml-1 italic font-normal tracking-normal">usulan</span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

</div>

<style>
    @keyframes spin {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }
    .animate-spin-once {
        animation: spin 0.5s linear;
    }
</style>

{{-- Pusher Library (CDN) --}}
<script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>

<script>
    // Konfigurasi Pusher
    // Pusing keys dari .env atau hardcode (untuk testing cepat di hosting)
    const PUSHER_KEY = "{{ config('broadcasting.connections.pusher.key') }}";
    const PUSHER_CLUSTER = "{{ config('broadcasting.connections.pusher.options.cluster') }}";

    if (PUSHER_KEY) {
        const pusher = new Pusher(PUSHER_KEY, {
            cluster: PUSHER_CLUSTER
        });

        const channel = pusher.subscribe('dashboard-channel');
        
        // Listen saat ada data masuk (Event DashboardUpdated)
        channel.bind('dashboard.updated', function(data) {
            console.log('🔔 DashboardUpdated: Ada data masuk baru!');
            refreshDashboard();
        });
    }

    function refreshDashboard() {
        const btn = document.querySelector('#btn-refresh span');
        if(btn) btn.style.transform = 'rotate(0deg)';
        if(btn) btn.classList.add('animate-spin-once');
        
        setTimeout(() => {
            if(btn) btn.classList.remove('animate-spin-once');
        }, 500);

        fetch("{{ route('admin.dashboard.data') }}", {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(response => response.json())
        .then(data => {
            // Update kartu statistik
            const totalLaporan = document.querySelector('#total-laporan');
            const totalSaran = document.querySelector('#total-saran');
            
            if (totalLaporan) totalLaporan.textContent = data.totalLaporan;
            if (totalSaran) totalSaran.textContent = data.totalSaran;

            // Update timestamp
            const lastUpdate = document.querySelector('#last-update');
            if (lastUpdate) lastUpdate.textContent = 'Pembaruan: ' + data.lastUpdate;
        })
        .catch(err => console.log('Refresh error:', err));
    }

    // Manual triggers
    document.querySelector('#btn-refresh').addEventListener('click', function() {
        refreshDashboard();
    });
</script>
@endsection
