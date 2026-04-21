@extends('layouts.admin')

@section('content')
<div class="space-y-8 animate-reveal">

    {{-- HEADER --}}
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 mb-16">
        <div>
            <div class="inline-flex items-center gap-3 px-3 py-1 rounded-full bg-blue-500/10 border border-blue-500/20 mb-4">
                <span class="w-1.5 h-1.5 rounded-full bg-blue-500 animate-pulse"></span>
                <span class="text-[9px] font-black uppercase tracking-[0.4em] text-blue-400">Daftar Usulan Aset</span>
            </div>
            <h1 class="text-4xl font-syne font-black text-white tracking-tighter uppercase">Saran <br><span class="text-white/40 italic">Penambahan Aset.</span></h1>
            <p class="text-white/30 text-xs mt-2 font-black uppercase tracking-widest">Daftar usulan aset baru dari civitas.</p>
        </div>
        <a href="{{ route('admin.dashboard') }}" class="btn-premium px-6 py-4 rounded-2xl text-[10px]">
            ← Kembali ke Dashboard
        </a>
    </div>

    {{-- TOAST --}}
    <div id="toast-sa" class="fixed top-6 right-6 z-[200] hidden">
        <div id="toast-sa-inner" class="px-6 py-4 rounded-2xl shadow-2xl text-sm font-bold flex items-center gap-3 transition-all" style="opacity:0;">
            <span id="toast-sa-icon">✅</span>
            <span id="toast-sa-msg"></span>
        </div>
    </div>

    {{-- TABEL --}}
    <div class="glass-card rounded-[2.5rem] border-white/5 overflow-hidden">
        <div class="p-8 border-b border-white/5 flex items-center justify-between bg-white/[0.02]">
            <h3 class="text-sm font-syne font-black text-white uppercase tracking-widest flex items-center gap-3">
                <span>📦</span> DAFTAR USULAN ASET
            </h3>
            <span class="px-3 py-1 rounded-lg bg-blue-500/20 text-blue-400 text-[10px] font-black tracking-widest uppercase border border-blue-500/20">{{ $saranAsets->total() }} Usulan</span>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-white/[0.02] text-[9px] uppercase tracking-[0.3em] text-white/30 font-black border-y border-white/5">
                    <tr>
                        <th class="px-6 py-5">ID</th>
                        <th class="px-6 py-5">Timestamp</th>
                        <th class="px-6 py-5">Gedung / Ruangan</th>
                        <th class="px-6 py-5">Aset yang Diusulkan</th>
                        <th class="px-6 py-5 text-center">Qty</th>
                        <th class="px-6 py-5">Pengusul</th>
                        <th class="px-6 py-5 text-center">Visual Log</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @forelse($saranAsets as $saran)
                    <tr class="hover:bg-white/[0.02] transition-colors group" id="sa-row-{{ $saran->id }}">
                        <td class="px-6 py-5 font-mono text-white/20 text-xs">#{{ $saran->id }}</td>
                        <td class="px-6 py-5">
                            <div class="font-black text-white/70 text-xs tracking-wider">{{ $saran->created_at->format('d M Y') }}</div>
                            <div class="text-[10px] text-white/30 font-bold mt-1">{{ $saran->created_at->format('H:i') }} WIB</div>
                        </td>
                        <td class="px-6 py-5">
                            <div class="font-black text-white text-xs">{{ $saran->gedung->nama }}</div>
                            <div class="text-[10px] text-white/30 font-bold mt-1">Zone: <span class="text-white/50">{{ $saran->ruangan }}</span></div>
                        </td>
                        <td class="px-6 py-5">
                            <div class="font-black text-white text-xs">{{ $saran->nama_aset }}</div>
                            <div class="text-[10px] text-white/30 italic mt-1 max-w-xs break-words whitespace-normal leading-relaxed">"{{ $saran->alasan }}"</div>
                        </td>
                        <td class="px-6 py-5 text-center">
                            <span class="inline-block px-3 py-1 rounded-lg bg-blue-500/20 text-blue-400 text-[9px] font-black tracking-widest border border-blue-500/20">{{ $saran->jumlah }}x</span>
                        </td>
                        <td class="px-6 py-5">
                            <div class="font-black text-white/80 text-xs">{{ $saran->nama_pengusul }}</div>
                            <div class="text-[10px] text-white/30 font-bold mt-0.5">{{ $saran->nim_nip ?? '-' }}</div>
                            <div class="text-[10px] text-white/20 mt-0.5">{{ $saran->fakultas ?? '-' }}</div>
                        </td>
                        <td class="px-6 py-5 text-center">
                            @if($saran->foto)
                                <a href="{{ url($saran->foto) }}" target="_blank" class="block mx-auto w-14 h-14">
                                    <img src="{{ url($saran->foto) }}" alt="Foto Saran" class="w-14 h-14 object-cover rounded-xl border border-white/10 mx-auto hover:scale-150 transition-transform cursor-zoom-in grayscale-[0.3] hover:grayscale-0">
                                </a>
                            @else
                                <span class="text-[10px] text-white/20 italic font-black uppercase tracking-widest">—</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-8 py-16 text-center">
                            <div class="inline-flex flex-col items-center justify-center gap-4">
                                <span class="text-4xl grayscale opacity-20">📭</span>
                                <p class="text-[10px] font-black text-white/20 uppercase tracking-widest">Belum ada usulan aset yang masuk</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($saranAsets->hasPages())
        <div class="p-8 border-t border-white/5 bg-white/[0.02]">
            {{ $saranAsets->links() }}
        </div>
        @endif
    </div>
</div>

<script>
    function showSaToast(message, isSuccess) {
        const t = document.getElementById('toast-sa');
        const inner = document.getElementById('toast-sa-inner');
        document.getElementById('toast-sa-msg').textContent = message;
        document.getElementById('toast-sa-icon').textContent = isSuccess ? '✅' : '❌';
        inner.className = `px-6 py-4 rounded-2xl shadow-2xl text-sm font-bold flex items-center gap-3 ${isSuccess ? 'bg-emerald-500/20 border border-emerald-500/30 text-emerald-400' : 'bg-red-500/20 border border-red-500/30 text-red-400'} transition-all`;
        t.classList.remove('hidden');
        setTimeout(() => { inner.style.opacity = '1'; }, 10);
        setTimeout(() => { inner.style.opacity = '0'; setTimeout(() => t.classList.add('hidden'), 300); }, 3000);
    }
</script>
@endsection

