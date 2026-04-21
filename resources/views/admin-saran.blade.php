@extends('layouts.admin')

@section('content')
<div class="space-y-8 animate-reveal">

    {{-- BREADCRUMB & BACK BUTTON --}}
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 mb-16">
        <div>
            <div class="inline-flex items-center gap-3 px-3 py-1 rounded-full bg-blue-500/10 border border-blue-500/20 mb-4">
                <span class="w-1.5 h-1.5 rounded-full bg-blue-500 animate-pulse"></span>
                <span class="text-[9px] font-black uppercase tracking-[0.4em] text-blue-400">Usulan Fasilitas</span>
            </div>
            <h1 class="text-4xl font-syne font-black text-white tracking-tighter uppercase">Kotak <br><span class="text-white/40 italic">Saran Fasilitas.</span></h1>
            <p class="text-white/30 text-xs mt-2 font-black uppercase tracking-widest">Saran dan masukan fasilitas dari civitas akademika.</p>
        </div>
        <a href="{{ route('admin.dashboard') }}" class="btn-premium px-6 py-4 rounded-2xl text-[10px]">
            ← Kembali ke Dashboard
        </a>
    </div>

    {{-- KONTEN TABEL --}}
    <div class="glass-card rounded-[2.5rem] border-white/5 overflow-hidden">
        <div class="p-8 border-b border-white/5 flex items-center justify-between bg-white/[0.02]">
            <h3 class="text-sm font-syne font-black text-white uppercase tracking-widest flex items-center gap-3">
                <span>📋</span> DAFTAR SARAN MASUK
            </h3>
            <span class="px-3 py-1 rounded-lg bg-blue-500/20 text-blue-400 text-[10px] font-black tracking-widest uppercase border border-blue-500/20">{{ count($daftarSaran) }} Saran Aktif</span>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-white/[0.02] text-[9px] uppercase tracking-[0.3em] text-white/30 font-black border-y border-white/5">
                    <tr>
                        <th class="px-8 py-5">Nama Pengusul</th>
                        <th class="px-8 py-5">Kontak Pengusul (Email)</th>
                        <th class="px-8 py-5">Detail Saran</th>
                        <th class="px-8 py-5 text-right">Waktu Pengiriman</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5 text-sm">
                    @forelse($daftarSaran as $s)
                    <tr class="hover:bg-white/[0.02] transition-colors group">
                        <td class="px-8 py-6">
                            <span class="font-black text-white text-xs uppercase tracking-wider">{{ $s->nama }}</span>
                        </td>
                        <td class="px-8 py-6 text-white/40 text-xs font-bold tracking-wider">{{ $s->email }}</td>
                        <td class="px-8 py-6">
                            <p class="italic text-white/50 text-xs leading-relaxed group-hover:text-blue-400 transition-colors line-clamp-2">"{{ $s->pesan }}"</p>
                        </td>
                        <td class="px-8 py-6 text-right">
                            <span class="inline-block px-3 py-1.5 rounded-lg bg-white/5 border border-white/10 text-[9px] font-black text-white/40 tracking-widest">{{ $s->created_at->format('d M Y - H:i') }}</span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-8 py-16 text-center">
                            <div class="inline-flex flex-col items-center justify-center gap-4">
                                <span class="text-4xl grayscale opacity-20">📭</span>
                                <p class="text-[10px] font-black text-white/20 uppercase tracking-widest">Belum ada usulan fasilitas yang masuk</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection