@extends('layout')

@section('content')
<div class="relative min-h-screen pt-24 pb-20 px-6 overflow-hidden">
    {{-- DECORATIVE ELEMENTS --}}
    <div class="absolute top-1/4 -left-20 w-96 h-96 bg-[#D4AF37] opacity-5 blur-[120px] pointer-events-none"></div>
    <div class="absolute bottom-1/4 -right-20 w-96 h-96 bg-blue-500 opacity-5 blur-[120px] pointer-events-none"></div>

    <div class="container mx-auto relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-20 items-start">
            
            {{-- CONTACT INFO --}}
            <div class="lg:col-span-5 space-y-12 animate-reveal">
                <div class="space-y-6">
                    <div class="inline-flex items-center gap-3 px-3 py-1 rounded-full bg-[#D4AF37]/10 border border-[#D4AF37]/20">
                        <span class="w-1.5 h-1.5 rounded-full bg-[#D4AF37] animate-pulse"></span>
                        <span class="text-[9px] font-black uppercase tracking-[0.4em] text-[#D4AF37]">Saluran Komunikasi</span>
                    </div>
                    <h2 class="text-5xl md:text-7xl font-syne font-black text-white tracking-tighter leading-none">HUBUNGI <br><span class="text-white/20 italic font-light tracking-normal">KAMI.</span></h2>
                    <p class="text-white/40 text-sm leading-relaxed max-w-sm border-l border-white/10 pl-6">
                        Saluran komunikasi resmi untuk pelaporan kendala fasilitas dan koordinasi manajemen aset Universitas Gadjah Mada.
                    </p>
                </div>

                <div class="grid grid-cols-1 gap-6">
                    <a href="https://wa.me/628833335151" target="_blank" class="group glass-card p-8 rounded-[2.5rem] border-white/5 hover:border-[#D4AF37]/30 transition-all duration-500 flex items-center gap-8">
                        <div class="w-16 h-16 bg-white/5 rounded-2xl flex items-center justify-center text-3xl group-hover:bg-[#25D366]/20 group-hover:scale-110 transition-all duration-500">
                             <img src="{{ asset('whatsapp.png') }}" alt="WA" class="w-8 h-8 object-contain opacity-50 group-hover:opacity-100 transition-opacity">
                        </div>
                        <div>
                            <p class="text-[9px] font-black text-white/20 uppercase tracking-[0.4em] mb-1">WhatsApp</p>
                            <p class="font-outfit font-black text-white text-xl tracking-tight">0883-3335-151</p>
                        </div>
                    </a>

                    <a href="https://instagram.com/aset.ugm" target="_blank" class="group glass-card p-8 rounded-[2.5rem] border-white/5 hover:border-[#F09433]/30 transition-all duration-500 flex items-center gap-8">
                        <div class="w-16 h-16 bg-white/5 rounded-2xl flex items-center justify-center text-3xl group-hover:bg-[#E1306C]/20 group-hover:scale-110 transition-all duration-500">
                             <img src="{{ asset('instagram.png') }}" alt="IG" class="w-8 h-8 object-contain opacity-50 group-hover:opacity-100 transition-opacity">
                        </div>
                        <div>
                            <p class="text-[9px] font-black text-white/20 uppercase tracking-[0.4em] mb-1">Instagram</p>
                            <p class="font-syne font-black text-white text-xl tracking-tight">@aset.ugm</p>
                        </div>
                    </a>
                </div>

                <div class="glass-card p-8 rounded-[2rem] border-white/5 bg-white/[0.02]">
                    <p class="text-[10px] font-bold text-white/30 italic leading-relaxed tracking-wider">
                        "Efisensi tata kelola infrastruktur dimulai dari transparansi data dan responsivitas pelaporan."
                    </p>
                </div>
            </div>

            {{-- SUGGESTION FORM --}}
            <div class="lg:col-span-7 animate-reveal" style="animation-delay: 200ms;">
                <div class="glass-card p-10 md:p-16 rounded-[3.5rem] border-white/5 shadow-2xl relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-64 h-64 bg-[#D4AF37] opacity-5 -mr-32 -mt-32 rounded-full blur-3xl"></div>
                    
                    <div class="relative z-10">
                        <h3 class="text-3xl font-syne font-black text-white mb-2 tracking-tight">Kotak Saran</h3>
                        <p class="text-[10px] font-black text-white/20 uppercase tracking-[0.4em] mb-12">Kirimkan Umpan Balik & Saran</p>
                        
                        <form action="/kirim-saran" method="POST" class="space-y-8">
                            @csrf
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                <div class="space-y-3">
                                    <label class="text-[9px] font-black uppercase tracking-[0.4em] text-white/20 ml-1">Nama Lengkap</label>
                                    <input type="text" name="nama" class="w-full bg-white/5 border border-white/5 py-4 px-6 rounded-2xl focus:ring-1 focus:ring-[#D4AF37] outline-none transition-all text-white font-bold placeholder-white/10 text-sm" placeholder="Nama Anda" required>
                                </div>
                                
                                <div class="space-y-3">
                                    <label class="text-[9px] font-black uppercase tracking-[0.4em] text-white/20 ml-1">Alamat Email</label>
                                    <input type="email" name="email" class="w-full bg-white/5 border border-white/5 py-4 px-6 rounded-2xl focus:ring-1 focus:ring-[#D4AF37] outline-none transition-all text-white font-bold placeholder-white/10 text-sm" placeholder="email@ugm.ac.id" required>
                                </div>
                            </div>

                            <div class="space-y-3">
                                <label class="text-[9px] font-black uppercase tracking-[0.4em] text-white/20 ml-1">Pesan / Saran</label>
                                <textarea name="pesan" rows="5" class="w-full bg-white/5 border border-white/5 py-4 px-6 rounded-2xl focus:ring-1 focus:ring-[#D4AF37] outline-none transition-all text-white font-bold placeholder-white/10 text-sm" placeholder="Tuliskan pesan atau saran Anda..." required></textarea>
                            </div>

                            <button type="submit" class="btn-premium w-full flex items-center justify-center gap-4">
                                Kirim Pesan
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection