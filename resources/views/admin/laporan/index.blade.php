@extends('layouts.admin')

@section('content')
<div class="space-y-8 animate-reveal">
    {{-- BREADCRUMB --}}
    <nav aria-label="breadcrumb">
        <ol class="flex items-center space-x-3 text-[10px] font-black text-white/20 uppercase tracking-[0.4em]">
            <li><a href="{{ route('admin.dashboard') }}" class="hover:text-[#D4AF37] transition-colors">Dashboard Admin</a></li>
            <li>/</li>
            <li class="text-[#D4AF37]">Daftar Laporan</li>
        </ol>
    </nav>

    <div class="flex flex-col md:flex-row justify-between items-end gap-6 mb-16">
        <div class="space-y-2">
            <h1 class="text-4xl md:text-5xl font-syne font-black text-white tracking-tighter uppercase">Data <br><span class="text-white/40 italic">Laporan Kerusakan.</span></h1>
            <div class="flex items-center gap-3">
                <span class="w-1.5 h-1.5 rounded-full bg-blue-500 animate-pulse"></span>
                <p class="text-[9px] font-black text-white/40 uppercase tracking-[0.3em]">Manajemen Aset Fisik</p>
            </div>
        </div>
        <a href="{{ route('admin.dashboard') }}" class="btn-premium px-6 py-4 rounded-2xl text-[10px]">
            ← Kembali ke Dashboard
        </a>
    </div>

    {{-- TABLE CONTAINER --}}
    <div class="glass-card rounded-[2.5rem] border border-white/5 overflow-hidden shadow-none">
        <div class="p-8 border-b border-white/5 bg-white/5 flex items-center justify-between">
            <div class="flex items-center gap-4">
                <div class="w-10 h-10 bg-white/5 rounded-xl flex items-center justify-center text-xl">📋</div>
                <h2 class="text-lg font-syne font-black text-white tracking-tight">Daftar Riwayat Laporan</h2>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-separate border-spacing-y-0">
                <thead>
                    <tr class="text-[10px] font-black text-white/20 uppercase tracking-[0.4em] border-b border-white/5">
                        <th class="px-8 py-6">Identity</th>
                        <th class="px-8 py-6">Timestamp</th>
                        <th class="px-8 py-6">Gedung</th>
                        <th class="px-8 py-6">Jenis Kerusakan</th>
                        <th class="px-8 py-6">Status Level</th>
                        <th class="px-8 py-6 text-right">Visuals</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @forelse($laporans as $laporan)
                    <tr class="group hover:bg-white/[0.02] transition-colors" id="row-{{ $laporan->id }}">
                        <td class="px-8 py-6">
                            <span class="text-xs font-mono text-white/20 group-hover:text-white/40 transition-colors">#{{ $laporan->id }}</span>
                        </td>
                        <td class="px-8 py-6">
                            <div class="text-xs font-bold text-white tracking-tight">{{ $laporan->created_at->format('d M y') }}</div>
                            <div class="text-[9px] font-black text-white/20 uppercase tracking-widest mt-1">{{ $laporan->created_at->format('H:i') }} UTC</div>
                        </td>
                        <td class="px-8 py-6">
                            <div class="text-xs font-black text-white uppercase tracking-tight group-hover:text-blue-400 transition-colors">{{ $laporan->gedung->nama }}</div>
                            <div class="text-[9px] font-bold text-white/30 uppercase tracking-widest mt-1">{{ $laporan->ruangan }} {{ $laporan->lantai ? '— LVL '.$laporan->lantai : '' }}</div>
                        </td>
                        <td class="px-8 py-6">
                            <div class="inline-flex items-center px-2 py-0.5 rounded-lg bg-blue-500/10 text-blue-400 text-[8px] font-black uppercase tracking-widest border border-blue-500/20 mb-1.5">
                                {{ $laporan->kategori }}
                            </div>
                            <div class="text-[11px] font-bold text-white/60 tracking-tight">{{ $laporan->sub_item }}</div>
                        </td>
                        <td class="px-8 py-6">
                            @if($laporan->kondisi === 'Sangat Baik')
                                <span class="px-3 py-1 rounded-full text-[8px] font-black uppercase tracking-widest bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 glow-emerald-sm">Sangat Baik</span>
                            @elseif($laporan->kondisi === 'Baik')
                                <span class="px-3 py-1 rounded-full text-[8px] font-black uppercase tracking-widest bg-green-500/10 text-green-400 border border-green-500/20">Baik</span>
                            @elseif($laporan->kondisi === 'Cukup')
                                <span class="px-3 py-1 rounded-full text-[8px] font-black uppercase tracking-widest bg-yellow-500/10 text-yellow-500 border border-yellow-500/20">Cukup</span>
                            @elseif($laporan->kondisi === 'Rusak Ringan')
                                <span class="px-3 py-1 rounded-full text-[8px] font-black uppercase tracking-widest bg-orange-500/10 text-orange-400 border border-orange-500/20">Rusak Ringan</span>
                            @else
                                <span class="px-3 py-1 rounded-full text-[8px] font-black uppercase tracking-widest bg-red-500/10 text-red-500 border border-red-500/20 glow-red-sm">Rusak Berat</span>
                            @endif
                        </td>
                        <td class="px-8 py-6 text-right">
                            @if($laporan->foto)
                                <a href="{{ url($laporan->foto) }}" target="_blank" class="inline-block relative">
                                    <img src="{{ url($laporan->foto) }}" alt="Foto" class="w-12 h-12 object-cover rounded-xl border border-white/10 group-hover:scale-110 group-hover:border-[#D4AF37] transition-all cursor-zoom-in shadow-xl">
                                </a>
                            @else
                                <span class="text-[9px] font-black text-white/10 uppercase tracking-widest">N/A</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-8 py-32 text-center">
                            <div class="text-5xl mb-6 opacity-20">📡</div>
                            <p class="text-[10px] font-black text-white/30 uppercase tracking-[0.4em]">Tidak ada laporan kerusakan yang terdeteksi saat ini</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($laporans->hasPages())
        <div class="p-8 border-t border-white/5 bg-white/[0.02]">
            {{ $laporans->links() }}
        </div>
        @endif
    </div>
</div>
@endsection

