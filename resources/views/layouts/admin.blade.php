<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Panel Admin - SI-ASET UGM</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700;800&family=Syne:wght@700;800&display=swap" rel="stylesheet">
    <style>


        body { 
            font-family: 'Outfit', sans-serif; 
            background-color: #020617; 
            color: #ffffff;
        }

        .font-syne { font-family: 'Syne', sans-serif; }

        .glass-card {
            background: rgba(15, 23, 42, 0.65);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.06);
            box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.5);
        }

        /* --- PRECISE TRANSITIONS --- */
        .bg-white, .bg-gray-50, .bg-slate-50, .bg-blue-50, 
        input, textarea, select, button, a, 
        .rounded-2xl, .rounded-\[2rem\], .shadow-xl {
            transition: background-color 0.3s ease, color 0.3s ease, border-color 0.3s ease, box-shadow 0.3s ease, transform 0.3s ease;
        }
        .bg-ugm { background-color: #004a99; }
        .text-ugm { color: #004a99; }
        .sidebar { min-width: 280px; max-width: 280px; background-color: #020617 !important; }

        /* --- BUTTONS --- */
        .btn-premium {
            background: linear-gradient(135deg, #D4AF37 0%, #F9C11C 100%);
            color: #020617 !important;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.2em;
            font-size: 10px;
            transition: all 0.4s cubic-bezier(0.23, 1, 0.32, 1);
            box-shadow: 0 10px 30px rgba(212, 175, 55, 0.2);
            display: inline-block;
        }
        .btn-premium:hover {
            transform: translateY(-2px) scale(1.02);
            box-shadow: 0 15px 40px rgba(212, 175, 55, 0.3);
        }

        /* --- ANIMATIONS --- */
        @keyframes reveal {
            from { opacity: 0; transform: translateY(24px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .animate-reveal {
            animation: reveal 0.7s cubic-bezier(0.25, 1, 0.5, 1) forwards;
            opacity: 0;
        }

        /* --- FORM INPUT STYLES (dark) --- */
        input[type="text"], input[type="number"], input[type="email"],
        input[type="password"], textarea, select {
            color: #ffffff;
            caret-color: #D4AF37;
        }
        input::placeholder, textarea::placeholder { color: rgba(255,255,255,0.2); }
        select option { background: #020617; color: #ffffff; }

        /* Specific fix for elements with low opacity text */
        [data-theme="dark"] .opacity-60,
        [data-theme="dark"] .opacity-50,
        [data-theme="dark"] .opacity-40 {
            opacity: 0.85 !important;
        }
    </style>

</head>
<body class="bg-[#020617] flex min-h-screen text-white" x-data="{ sidebarOpen: false }">

    <!-- OVERLAY UTK MOBILE -->
    <div x-show="sidebarOpen" 
         @click="sidebarOpen = false" 
         x-transition:enter="transition-opacity ease-linear duration-300" 
         x-transition:enter-start="opacity-0" 
         x-transition:enter-end="opacity-100" 
         x-transition:leave="transition-opacity ease-linear duration-300" 
         x-transition:leave-start="opacity-100" 
         x-transition:leave-end="opacity-0" 
         class="fixed inset-0 bg-gray-900/80 z-[10000] lg:hidden"></div>

    <!-- SIDEBAR -->
    <!-- SIDEBAR -->
    <aside :class="sidebarOpen ? 'translate-x-0' : 'translate-x-full'" 
           class="sidebar border-r border-white/5 flex flex-col fixed right-0 lg:left-0 lg:sticky top-0 h-screen z-[10001] transition-transform duration-500 lg:translate-x-0 glass-card !shadow-none">
        
        <div class="p-8 flex items-center gap-4">
            <div class="w-12 h-12 bg-gradient-to-br from-[#D4AF37] to-[#F9C11C] rounded-2xl flex items-center justify-center font-black text-[#001A38] shadow-lg shadow-yellow-500/20 tilt-animation">
                <span class="font-syne text-lg">U</span>
            </div>
            <div>
                <h1 class="text-2xl font-syne font-black tracking-tighter leading-none text-white">SI-ASET</h1>
                <p class="text-[7px] uppercase tracking-[0.4em] text-[#D4AF37] font-black mt-1.5">Panel Administrasi UGM</p>
            </div>
        </div>

        <nav class="flex-grow p-6 space-y-3 mt-4">
            <a href="{{ route('admin.dashboard') }}" class="group flex items-center gap-4 px-4 py-3.5 rounded-2xl transition-all duration-300 {{ Request::is('admin/dashboard') ? 'bg-white/10 text-[#F9C11C] shadow-inner shadow-white/5' : 'text-gray-500 hover:text-white hover:bg-white/5' }}">
                <div class="w-8 h-8 rounded-xl flex items-center justify-center bg-white/5 group-hover:scale-110 transition-transform">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                </div>
                <span class="text-sm font-bold tracking-tight">Dashboard</span>
            </a>
            
            <a href="{{ route('admin.laporan.index') }}" class="group flex items-center gap-4 px-4 py-3.5 rounded-2xl transition-all duration-300 {{ Request::is('admin/laporan*') ? 'bg-white/10 text-[#F9C11C] shadow-inner shadow-white/5' : 'text-gray-500 hover:text-white hover:bg-white/5' }}">
                <div class="w-8 h-8 rounded-xl flex items-center justify-center bg-white/5 group-hover:scale-110 transition-transform">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01m-.01 4h.01"></path></svg>
                </div>
                <span class="text-sm font-bold tracking-tight">Laporan Kerusakan</span>
            </a>

            <a href="{{ route('admin.saran-aset.index') }}" class="group flex items-center gap-4 px-4 py-3.5 rounded-2xl transition-all duration-300 {{ Request::is('admin/saran-aset*') ? 'bg-white/10 text-[#F9C11C] shadow-inner shadow-white/5' : 'text-gray-500 hover:text-white hover:bg-white/5' }}">
                <div class="w-8 h-8 rounded-xl flex items-center justify-center bg-white/5 group-hover:scale-110 transition-transform">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <span class="text-sm font-bold tracking-tight">Saran Aset</span>
            </a>

            <a href="{{ route('admin.saran.index') }}" class="group flex items-center gap-4 px-4 py-3.5 rounded-2xl transition-all duration-300 {{ Request::is('admin/saran') ? 'bg-white/10 text-[#F9C11C] shadow-inner shadow-white/5' : 'text-gray-500 hover:text-white hover:bg-white/5' }}">
                <div class="w-8 h-8 rounded-xl flex items-center justify-center bg-white/5 group-hover:scale-110 transition-transform">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
                </div>
                <span class="text-sm font-bold tracking-tight">Kotak Saran</span>
            </a>

            @if(session('admin_role') === 'admin_utama')
            <div class="pt-8 pb-3 px-4 uppercase text-[9px] font-black text-white/20 tracking-[0.4em]">Administration</div>
            <a href="{{ route('admin.management.index') }}" class="group flex items-center gap-4 px-4 py-3.5 rounded-2xl transition-all duration-300 {{ Request::is('admin/kelola-admin*') ? 'bg-white/10 text-[#F9C11C] shadow-inner shadow-white/5' : 'text-gray-500 hover:text-white hover:bg-white/5' }}">
                <div class="w-8 h-8 rounded-xl flex items-center justify-center bg-white/5 group-hover:scale-110 transition-transform">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                </div>
                <span class="text-sm font-bold tracking-tight">Kelola Admin</span>
            </a>
            @endif
        </nav>

        <div class="p-6 border-t border-white/5 space-y-4">


            <div class="bg-white/5 rounded-2xl p-4">
                <p class="text-[9px] text-white/40 uppercase font-black mb-1">Log Terakhir</p>
                <p class="text-[10px] font-bold text-gray-300 italic">{{ session('admin_last_login', '-') }}</p>
            </div>
            
            <form action="{{ route('admin.logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full bg-red-500/10 hover:bg-red-500 text-red-500 hover:text-white px-4 py-3 rounded-xl transition-all text-xs font-bold uppercase tracking-widest flex items-center justify-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                    Logout
                </button>
            </form>
        </div>
    </aside>

    <!-- CONTENT AREA -->
    <div class="flex-grow flex flex-col h-screen overflow-y-auto bg-[#020617]">
        <!-- HEADER -->
        <header class="glass-card shadow-none px-6 lg:px-10 py-4 border-b border-white/5 flex justify-between items-center sticky top-0 z-30">
            <div>
                <h2 class="text-[10px] font-black text-[#D4AF37] uppercase tracking-[0.4em]">Panel Kontrol Admin</h2>
            </div>
            <div class="flex items-center gap-4 lg:gap-6">
                <!-- Hamburger Menu Button -->
                <button @click="sidebarOpen = true" class="lg:hidden text-gray-400 hover:text-white transition-colors p-2 bg-white/5 rounded-xl">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
                    </svg>
                </button>

                <div class="relative hidden lg:block" x-data="{ open: false }">
                    <button @click="open = !open" class="flex items-center gap-4 group p-1.5 pr-4 rounded-2xl hover:bg-white/5 transition-all border border-transparent hover:border-white/5">
                        <div class="w-10 h-10 bg-gradient-to-tr from-white/10 to-white/20 rounded-xl flex items-center justify-center font-black text-white border border-white/10 uppercase text-xs">
                            {{ substr(session('admin_nama'), 0, 2) }}
                        </div>
                        <div class="text-right hidden sm:block">
                            <p class="text-xs font-black text-white uppercase tracking-tight">{{ session('admin_nama') }}</p>
                            <div class="flex items-center justify-end gap-2 mt-0.5">
                                <span class="bg-blue-500/10 text-blue-400 px-2 py-0.5 rounded-lg text-[8px] font-black uppercase tracking-widest border border-blue-500/20">
                                    {{ session('admin_role') === 'admin_utama' ? 'ROOT' : 'OP' }}
                                </span>
                                @if(session('admin_gedung_nama'))
                                <span class="text-[8px] text-gray-500 font-bold uppercase">{{ session('admin_gedung_nama') }}</span>
                                @endif
                            </div>
                        </div>
                    </button>

                    {{-- Dropdown Menu --}}
                    <div x-show="open" @click.away="open = false" 
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 translate-y-2 scale-95"
                         x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                         class="absolute right-0 mt-3 w-64 glass-card border border-white/10 rounded-[1.5rem] shadow-2xl overflow-hidden z-50">
                        <div class="p-6 border-b border-white/5 bg-white/5">
                            <p class="text-[9px] font-black text-[#D4AF37] uppercase tracking-widest mb-1">Sesi Login</p>
                            <p class="text-sm font-bold text-white truncate">{{ session('admin_nama') }}</p>
                        </div>
                        <div class="p-2">
                            <a href="{{ route('admin.profil') }}" class="flex items-center gap-3 px-4 py-3 hover:bg-white/5 rounded-xl transition-colors text-xs font-bold text-gray-300">
                                <span class="w-8 h-8 flex items-center justify-center bg-white/5 rounded-lg">👤</span> Profil & Keamanan
                            </a>
                            <form action="{{ route('admin.logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 hover:bg-red-500/10 rounded-xl transition-colors text-xs font-bold text-red-400 mt-1">
                                    <span class="w-8 h-8 flex items-center justify-center bg-red-500/5 rounded-lg">🚪</span> Keluar dari Sistem
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- MAIN CONTENT -->
        <main class="p-4 md:p-10">
            @if(session('error'))
                <div class="glass-card border-red-500/20 bg-red-500/5 px-6 py-4 rounded-2xl mb-8 flex items-center gap-4 animate-reveal">
                    <span class="p-2 bg-red-500/20 rounded-lg text-xl">🚨</span>
                    <div>
                        <p class="font-black text-sm text-red-400 uppercase tracking-widest">Akses Ditolak</p>
                        <p class="text-xs text-red-400/60 font-bold mt-0.5">{{ session('error') }}</p>
                    </div>
                </div>
            @endif

            @if(session('success'))
                <div class="glass-card border-emerald-500/20 bg-emerald-500/5 px-6 py-4 rounded-2xl mb-8 flex items-center gap-4">
                    <span class="p-2 bg-emerald-500/20 rounded-lg text-xl">✅</span>
                    <p class="font-black text-sm text-emerald-400">{{ session('success') }}</p>
                </div>
            @endif

            @yield('content')
        </main>
    </div>

</body>
</html>
