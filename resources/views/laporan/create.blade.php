@extends('layout')

@section('content')
<div class="relative min-h-screen pt-24 pb-20 px-6">
    <div class="container mx-auto relative z-10">
        
        <div class="max-w-4xl mx-auto">
            {{-- PAGE HEADER & BACK BUTTON --}}
            <div class="flex flex-col md:flex-row justify-between items-end gap-8 mb-16 animate-reveal">
                <div class="space-y-4">
                    <div class="inline-flex items-center gap-3 px-3 py-1 rounded-full bg-red-500/10 border border-red-500/20">
                        <span class="w-1.5 h-1.5 rounded-full bg-red-500 animate-pulse"></span>
                        <span class="text-[9px] font-black uppercase tracking-[0.4em] text-red-500">Pelaporan Kerusakan</span>
                    </div>
                    <h2 class="text-5xl md:text-7xl font-syne font-black text-white tracking-tighter leading-none">LAPORAN <br><span class="text-white/20 italic font-light tracking-normal">KERUSAKAN.</span></h2>
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

            <form action="{{ route('laporan.store') }}" method="POST" enctype="multipart/form-data" class="glass-card rounded-[4rem] border-white/5 overflow-hidden animate-reveal shadow-2xl" style="animation-delay: 200ms;">
                @csrf

                {{-- STEP 1: LOKASI --}}
                <div class="p-12 md:p-16 border-b border-white/5 relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-64 h-64 bg-[#D4AF37] opacity-5 -mr-32 -mt-32 rounded-full blur-3xl"></div>
                    
                    <div class="flex items-center gap-6 mb-12">
                        <div class="w-12 h-12 bg-white/5 border border-white/10 rounded-2xl flex items-center justify-center font-black text-white/50 text-xl glow-white-sm">01</div>
                        <h3 class="text-xs font-syne font-black text-white uppercase tracking-[0.4em]">Pilih Lokasi Gedung</h3>
                    </div>

                    <div class="glass-card p-8 rounded-3xl border border-white/5 bg-white/[0.02] flex flex-col md:flex-row items-center justify-between gap-8">
                        <div class="space-y-3">
                            <p class="text-[9px] font-black text-[#D4AF37] uppercase tracking-[0.4em]">Gedung yang Dilaporkan</p>
                            <h4 class="text-3xl font-syne font-black text-white tracking-tighter leading-none">{{ $gedung->nama }}</h4>
                            @if($gedung->parent)
                                <p class="text-[10px] font-black text-[#D4AF37] uppercase tracking-[0.2em] italic">Bagian dari: {{ $gedung->parent->nama }}</p>
                            @endif
                        </div>
                        <div class="text-6xl opacity-10">🏛️</div>
                    </div>
                    
                    <input type="hidden" name="gedung_id" value="{{ $gedung->id }}">
                </div>

                {{-- STEP 2: DETAIL RUANGAN --}}
                <div class="p-12 md:p-16 border-b border-white/5 bg-white/[0.01]">
                    <div class="flex items-center gap-6 mb-12">
                        <div class="w-12 h-12 bg-white/5 border border-white/10 rounded-2xl flex items-center justify-center font-black text-white/50 text-xl">02</div>
                        <h3 class="text-xs font-syne font-black text-white uppercase tracking-[0.4em]">Detail Lokasi Kerusakan</h3>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
                        <div class="md:col-span-2 space-y-3">
                            <label class="block text-[10px] font-black text-white/60 uppercase tracking-[0.4em] ml-1">Ruangan / Zona Spesifik</label>
                            <input type="text" name="ruangan" placeholder="Contoh: Lab 2.1, Koridor Utama, Sayap B" value="{{ old('ruangan') }}" class="w-full bg-white/5 border border-white/20 p-6 rounded-2xl focus:ring-2 focus:ring-[#D4AF37] outline-none transition-all text-white font-bold text-sm placeholder-white/40" required>
                        </div>
                        <div class="space-y-3">
                            <label class="block text-[10px] font-black text-white/60 uppercase tracking-[0.4em] ml-1">Lantai</label>
                            <input type="number" name="lantai" placeholder="LANTAI" value="{{ old('lantai') }}" class="w-full bg-white/5 border border-white/20 p-6 rounded-2xl focus:ring-2 focus:ring-[#D4AF37] outline-none transition-all text-white font-bold text-sm placeholder-white/40">
                        </div>
                    </div>
                </div>

                {{-- STEP 3: KATEGORI --}}
                <div class="p-12 md:p-16 border-b border-white/5">
                    <div class="flex items-center gap-6 mb-12">
                        <div class="w-12 h-12 bg-white/5 border border-white/10 rounded-2xl flex items-center justify-center font-black text-white/50 text-xl">03</div>
                        <h3 class="text-xs font-syne font-black text-white uppercase tracking-[0.4em]">Kategori Kerusakan</h3>
                    </div>

                    <input type="hidden" name="kategori" id="input_kategori" value="{{ old('kategori') }}" required>
                    
                    <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-4 mb-12">
                        @php
                            $kategoris = [
                                'Meja & Kursi' => '🪑',
                                'Elektronik' => '💻',
                                'Toilet & Kebersihan' => '🚽',
                                'Pintu & Jendela' => '🚪',
                                'Atap & Plafon' => '🏠',
                                'Dinding & Cat' => '🧱',
                                'Lantai' => '🔲',
                                'Instalasi Listrik' => '⚡',
                                'Instalasi Air' => '🚰',
                                'Lainnya' => '📦'
                            ];
                        @endphp
                        
                        @foreach($kategoris as $nama => $icon)
                        <div class="kategori-card glass-card p-6 rounded-3xl border-white/10 text-center flex flex-col items-center justify-center gap-4 group cursor-pointer transition-all duration-500 hover:border-[#D4AF37]/50" data-kategori="{{ $nama }}">
                            <span class="text-3xl grayscale group-hover:grayscale-0 transition-all duration-500 group-hover:scale-110">{{ $icon }}</span>
                            <span class="text-[9px] font-black text-white/60 uppercase tracking-widest group-hover:text-[#D4AF37] transition-colors">{{ $nama }}</span>
                        </div>
                        @endforeach
                    </div>

                    {{-- SUB-ITEMS --}}
                    <div id="sub_item_container" class="hidden glass-card p-10 rounded-[2.5rem] border-white/10 bg-white/[0.02] relative">
                        <label class="block text-[10px] font-black text-[#D4AF37] uppercase tracking-[0.4em] mb-8 ml-1 italic">Pilih Item yang Rusak</label>
                        <input type="hidden" name="sub_item" id="input_sub_item" value="{{ old('sub_item') }}" required>
                        <div id="sub_item_buttons" class="flex flex-wrap gap-3">
                            {{-- Inject by JS --}}
                        </div>
                        <div id="sub_item_custom" class="hidden mt-8">
                            <input type="text" id="custom_sub_item" placeholder="Tulis item yang rusak secara spesifik..." class="w-full bg-white/5 border border-white/20 p-5 rounded-2xl focus:ring-2 focus:ring-[#D4AF37] outline-none transition-all text-white font-bold text-sm placeholder-white/40">
                        </div>
                    </div>
                </div>

                {{-- STEP 4: KONDISI --}}
                <div class="p-12 md:p-16 border-b border-white/5 bg-white/[0.01]">
                    <div class="flex items-center gap-6 mb-12">
                        <div class="w-12 h-12 bg-white/5 border border-white/10 rounded-2xl flex items-center justify-center font-black text-white/50 text-xl">04</div>
                        <h3 class="text-xs font-syne font-black text-white uppercase tracking-[0.4em]">Tingkat Kerusakan</h3>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-12">
                        @foreach([
                            'Sangat Baik' => ['#10b981', 'Sangat Baik', 'Kondisi sangat baik / seperti baru.'],
                            'Baik' => ['#22c55e', 'Baik', 'Berfungsi sebagaimana mestinya.'],
                            'Cukup' => ['#eab308', 'Cukup', 'Berfungsi namun mulai aus.'],
                            'Rusak Ringan' => ['#f97316', 'Rusak Ringan', 'Terdeteksi kerusakan ringan.'],
                            'Rusak Berat' => ['#ef4444', 'Rusak Berat', 'Kerusakan parah / berbahaya.']
                        ] as $val => $meta)
                        <label class="cursor-pointer relative group">
                            <input type="radio" name="kondisi" value="{{ $val }}" class="peer sr-only" required {{ old('kondisi') == $val ? 'checked' : '' }}>
                            <div class="p-6 rounded-[2rem] glass-card border-white/10 flex flex-col justify-center h-full transition-all duration-500 peer-checked:border-[{{ $meta[0] }}]/50 peer-checked:bg-[{{ $meta[0] }}]/5 group-hover:border-white/30 hover:bg-white/[0.02]">
                                <h4 class="font-black text-[10px] uppercase tracking-widest mb-2 transition-colors peer-checked:text-[{{ $meta[0] }}]" style="color: {{ $meta[0] }}">{{ $meta[1] }}</h4>
                                <p class="text-[9px] font-bold text-white/60 uppercase tracking-widest leading-relaxed">{{ $meta[2] }}</p>
                            </div>
                        </label>
                        @endforeach
                    </div>

                    <div class="space-y-10">
                        <div class="space-y-4">
                            <label class="block text-[10px] font-black text-white/60 uppercase tracking-[0.4em] ml-1">Deskripsi Kerusakan (Opsional)</label>
                            <textarea name="deskripsi" rows="3" placeholder="Jelaskan kerusakan secara detail..." class="w-full bg-white/5 border border-white/20 p-6 rounded-2xl focus:ring-2 focus:ring-[#D4AF37] outline-none transition-all text-white font-bold text-sm placeholder-white/40">{{ old('deskripsi') }}</textarea>
                        </div>

                        <div class="space-y-4">
                            <label class="block text-[10px] font-black text-white/60 uppercase tracking-[0.4em] ml-1">Bukti Foto (Opsional)</label>
                            <div class="relative group">
                                <input type="file" name="foto" accept="image/*" class="w-full bg-white/5 border border-white/20 p-5 rounded-2xl text-[10px] text-white/60 font-black uppercase tracking-widest file:mr-6 file:py-3 file:px-6 file:rounded-xl file:border-0 file:text-[9px] file:font-black file:uppercase file:tracking-widest file:bg-white/10 file:text-white hover:file:bg-[#D4AF37] hover:file:text-[#020617] transition-all cursor-pointer">
                            </div>
                            <p class="text-[9px] font-black text-[#D4AF37] uppercase tracking-[0.3em] ml-1">FORMAT: JPG, PNG, WEBP • MAKS 10MB</p>
                        </div>
                    </div>
                </div>

                {{-- STEP 5: PELAPOR --}}
                <div class="p-12 md:p-16 relative overflow-hidden">
                    <div class="absolute bottom-0 left-0 w-64 h-64 bg-blue-500 opacity-5 -ml-32 -mb-32 rounded-full blur-3xl"></div>

                    <div class="flex items-center gap-6 mb-12">
                        <div class="w-12 h-12 bg-white/5 border border-white/10 rounded-2xl flex items-center justify-center font-black text-white/50 text-xl">05</div>
                        <h3 class="text-xs font-syne font-black text-white uppercase tracking-[0.4em]">Data Pelapor</h3>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-16">
                        <div class="space-y-3">
                            <label class="block text-[10px] font-black text-white/60 uppercase tracking-[0.4em] ml-1">Nama Lengkap</label>
                            <input type="text" name="nama_pelapor" value="{{ old('nama_pelapor') }}" placeholder="Nama Lengkap" class="w-full bg-white/5 border border-white/20 p-5 rounded-2xl focus:ring-2 focus:ring-[#D4AF37] outline-none transition-all text-white font-bold text-sm placeholder-white/40" required>
                        </div>
                        <div class="space-y-3">
                            <label class="block text-[10px] font-black text-white/60 uppercase tracking-[0.4em] ml-1">NIP / NIM</label>
                            <input type="text" name="nim_nip" value="{{ old('nim_nip') }}" placeholder="Nomor Identitas (NIP/NIM)" class="w-full bg-white/5 border border-white/20 p-5 rounded-2xl focus:ring-2 focus:ring-[#D4AF37] outline-none transition-all text-white font-bold text-sm placeholder-white/40" required>
                        </div>
                        <div class="space-y-3">
                            <label class="block text-[10px] font-black text-white/60 uppercase tracking-[0.4em] ml-1">Fakultas / Unit</label>
                            <select name="fakultas" class="w-full bg-white/5 border border-white/20 p-5 rounded-2xl focus:ring-2 focus:ring-[#D4AF37] outline-none transition-all text-white font-bold text-sm appearance-none cursor-pointer" required>
                                <option value="" disabled {{ old('fakultas') ? '' : 'selected' }} class="bg-[#020617] text-white/40">-- PILIH FAKULTAS --</option>
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
                        KIRIM LAPORAN
                    </button>
                    <p class="text-center text-[10px] font-black text-white/40 uppercase tracking-[0.4em] mt-8">Laporan akan segera diproses oleh divisi terkait paling cepat 1x24 jam.</p>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Sub-items dictionary
    const subItemsMap = {
        'Meja & Kursi': ['Meja Dosen', 'Meja Mahasiswa', 'Kursi Dosen', 'Kursi Mahasiswa', 'Podium', 'Lemari'],
        'Elektronik': ['AC', 'Proyektor', 'Layar Proyektor', 'Lampu', 'Stop Kontak', 'Kipas Angin', 'Komputer', 'TV/Monitor'],
        'Toilet & Kebersihan': ['Kloset', 'Wastafel', 'Cermin', 'Keran Air', 'Pintu Toilet', 'Sekat Toilet', 'Saluran Air'],
        'Pintu & Jendela': ['Engsel Pintu', 'Kunci Pintu', 'Handle Pintu', 'Kaca Jendela', 'Teralis', 'Pintu Utama'],
        'Atap & Plafon': ['Plafon Bocor', 'Plafon Retak', 'Plafon Lepas', 'Atap Bocor', 'Talang Air'],
        'Dinding & Cat': ['Cat Mengelupas', 'Dinding Retak', 'Dinding Lembab', 'Wallpaper Rusak'],
        'Lantai': ['Keramik Retak', 'Keramik Lepas', 'Lantai Licin', 'Lantai Berlubang'],
        'Instalasi Listrik': ['Saklar Rusak', 'MCB Trip', 'Kabel Terkelupas', 'Grounding', 'Panel Listrik'],
        'Instalasi Air': ['Pipa Bocor', 'Pipa Tersumbat', 'Pompa Air', 'Tandon Air'],
        'Tangga & Koridor': ['Pegangan Tangga', 'Anak Tangga', 'Ramp Rusak', 'Koridor Licin'],
        'Papan Tulis & Proyektor': ['Papan Tulis', 'Penghapus', 'Spidol/Kapur', 'Remote Proyektor', 'Kabel HDMI'],
        'Kunci & Akses Ruangan': ['Kunci Rusak', 'Gembok', 'Kartu Akses', 'Fingerprint'],
        'Lainnya': ['Lainnya...']
    };

    const cards = document.querySelectorAll('.kategori-card');
    const inputKategori = document.getElementById('input_kategori');
    const containerSubItem = document.getElementById('sub_item_container');
    const buttonsSubItem = document.getElementById('sub_item_buttons');
    const inputSubItem = document.getElementById('input_sub_item');
    const customSubItemDiv = document.getElementById('sub_item_custom');
    const customSubItemInput = document.getElementById('custom_sub_item');

    cards.forEach(card => {
        card.addEventListener('click', function() {
            cards.forEach(c => {
                c.classList.remove('border-[#D4AF37]/50', 'bg-[#D4AF37]/5', 'scale-[1.02]');
                c.querySelector('span:first-child').classList.add('grayscale');
                c.querySelector('span:last-child').classList.replace('text-white', 'text-white/20');
            });

            this.classList.add('border-[#D4AF37]/50', 'bg-[#D4AF37]/5', 'scale-[1.02]');
            this.querySelector('span:first-child').classList.remove('grayscale');
            this.querySelector('span:last-child').classList.replace('text-white/20', 'text-white');

            const kategori = this.dataset.kategori;
            inputKategori.value = kategori;
            renderSubItems(kategori);
        });
    });

    function renderSubItems(kategori) {
        containerSubItem.classList.remove('hidden');
        buttonsSubItem.innerHTML = '';
        inputSubItem.value = '';
        customSubItemDiv.classList.add('hidden');
        customSubItemInput.required = false;

        const items = subItemsMap[kategori] || [];
        
        items.forEach(item => {
            const btn = document.createElement('button');
            btn.type = 'button';
            btn.className = 'px-5 py-2.5 rounded-xl border border-white/10 bg-white/5 text-[10px] font-black uppercase tracking-widest text-white/50 hover:bg-white/10 hover:text-white transition-all';
            btn.innerText = item;
            
            btn.addEventListener('click', function() {
                buttonsSubItem.querySelectorAll('button').forEach(b => {
                    b.classList.remove('bg-[#D4AF37]', 'text-black', 'border-[#D4AF37]');
                    b.classList.add('bg-white/5', 'text-white/50', 'border-white/10');
                });
                
                this.classList.remove('bg-white/5', 'text-white/50', 'border-white/10');
                this.classList.add('bg-[#D4AF37]', 'text-black', 'border-[#D4AF37]');

                if (item === 'Lainnya...') {
                    customSubItemDiv.classList.remove('hidden');
                    customSubItemInput.required = true;
                    inputSubItem.value = customSubItemInput.value;
                } else {
                    customSubItemDiv.classList.add('hidden');
                    customSubItemInput.required = false;
                    inputSubItem.value = item;
                }
            });

            buttonsSubItem.appendChild(btn);
        });

        if (kategori === 'Lainnya') {
            buttonsSubItem.querySelector('button').click();
        }
    }

    customSubItemInput.addEventListener('input', function() {
        if(customSubItemDiv.classList.contains('hidden') === false) {
            inputSubItem.value = this.value;
        }
    });

</script>
@endsection

