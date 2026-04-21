@extends('layout')

@section('content')
<div class="relative min-h-screen pt-24 pb-20 px-6 flex items-center justify-center">
    
    <div class="glass-card max-w-lg w-full rounded-[4rem] text-center p-12 border-white/5 shadow-[0_50px_100px_rgba(0,0,0,0.5)] animate-reveal relative overflow-hidden">
        
        <div class="absolute inset-0 bg-[#D4AF37] opacity-[0.02]"></div>

        <div class="relative z-10">
            <!-- Icon sukses -->
            <div class="w-28 h-28 glass-card border-[#D4AF37]/20 bg-[#D4AF37]/5 rounded-full flex items-center justify-center text-5xl mx-auto mb-10 shadow-[0_0_50px_rgba(212,175,55,0.1)] relative">
                <span class="absolute inset-0 border border-[#D4AF37]/30 rounded-full animate-ping opacity-50"></span>
                <span class="relative z-10 grayscale-[0.2]">✅</span>
            </div>

            <!-- Judul -->
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-500/10 border border-emerald-500/20 mb-6">
                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                <span class="text-[9px] font-black uppercase tracking-[0.4em] text-emerald-400">Terkirim</span>
            </div>
            
            <h2 class="text-2xl md:text-4xl font-syne font-black text-white mb-6 uppercase tracking-tight leading-[1.1] break-words">
                {{ session('judul') ?? $judul ?? 'Berhasil' }}
            </h2>

            <!-- Pesan -->
            <p class="text-white/40 text-sm leading-relaxed mb-12 italic">
                "{{ session('pesan') ?? $pesan ?? 'Data Anda telah kami terima dan akan segera diproses. Terima kasih atas kontribusi Anda.' }}"
            </p>

            <!-- Tombol-tombol -->
            <div class="flex flex-col gap-4 mb-10">
                <a href="{{ route('katalog.index') }}" class="btn-premium py-5 rounded-2xl text-[10px] uppercase tracking-widest text-center shadow-lg">
                    Kembali ke Katalog
                </a>

                <a href="{{ url()->previous() }}" class="glass-card py-5 rounded-2xl border-white/5 text-[10px] text-white/50 font-black uppercase tracking-widest hover:text-white hover:bg-white/5 transition-all text-center">
                    Kirim Data Lainnya
                </a>
            </div>

            <!-- Footer -->
            <div class="pt-8 border-t border-white/5">
                <p id="sheet-sync-status" class="text-[8px] text-white/20 font-black uppercase tracking-[0.4em]">SI-ASET UGM • Infrastructure Control • 2026</p>
            </div>
        </div>
    </div>
</div>

@if(session('webhook_type') || isset($webhook_type))
{{-- Google Apps Script Webhook: kirim data via browser (bypass InfinityFree API block) --}}
<script>
    (function () {
        const APPS_SCRIPT_URL = 'https://script.google.com/macros/s/AKfycbxpl6xVntDBO1jPKUaxMFlmbD44vWrHbELPrzClyk5MyOPkijIA3IqzvQxH-gH0JoCfRg/exec';

        if (!APPS_SCRIPT_URL || APPS_SCRIPT_URL === 'GANTI_DENGAN_URL_APPS_SCRIPT_ANDA') return;

        const payload = {
            type: @json(session('webhook_type') ?? $webhook_type ?? null),
            data: @json(session('webhook_data') ?? $webhook_data ?? null)
        };

        fetch(APPS_SCRIPT_URL, {
            method: 'POST',
            mode: 'no-cors',
            body: JSON.stringify(payload),
            headers: { 'Content-Type': 'text/plain' },
        })
            .then(() => {
                const el = document.getElementById('sheet-sync-status');
                if (el) { 
                    el.innerHTML = '<span class="text-emerald-400">DATA SYNC COMPLETE • </span> SI-ASET UGM'; 
                }
            })
            .catch(err => {
                console.warn('⚠️ Webhook fetch error (non-critical):', err);
            });
    })();
</script>
@endif
@endsection