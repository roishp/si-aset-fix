<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SI-ASET UGM</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700;800&family=Syne:wght@700;800&display=swap" rel="stylesheet">
    
    <style>

        body { 
            font-family: 'Outfit', sans-serif; 
            overflow-x: hidden; 
            position: relative; 
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



        /* --- GLOBAL GRADIENTS & MESH --- */
        .mesh-gradient {
            position: fixed;
            top: 0; left: 0; width: 100%; height: 100%;
            background: 
                radial-gradient(at 0% 0%, rgba(212, 175, 55, 0.03) 0, transparent 50%),
                radial-gradient(at 100% 0%, rgba(16, 185, 129, 0.03) 0, transparent 50%),
                radial-gradient(at 50% 50%, rgba(2, 6, 23, 1) 0, rgba(2, 6, 23, 1) 100%);
            z-index: -2;
        }

        .noise-overlay {
            position: fixed;
            top: 0; left: 0; width: 100%; height: 100%;
            background: url('https://grainy-gradients.vercel.app/noise.svg');
            opacity: 0.02;
            pointer-events: none;
            z-index: -1;
        }

        /* --- NAVIGATION --- */
        .nav-glass {
            background: rgba(2, 6, 23, 0.7);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }

        .nav-link-premium {
            font-size: 10px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.3em;
            color: rgba(255, 255, 255, 0.4);
            transition: all 0.4s cubic-bezier(0.23, 1, 0.32, 1);
            position: relative;
        }

        .nav-link-premium:hover, .nav-link-premium.active {
            color: #D4AF37;
        }

        .nav-link-premium::after {
            content: '';
            position: absolute;
            bottom: -8px; left: 50%; width: 0; height: 1px;
            background: #D4AF37;
            transition: all 0.4s cubic-bezier(0.23, 1, 0.32, 1);
            transform: translateX(-50%);
        }

        .nav-link-premium:hover::after, .nav-link-premium.active::after {
            width: 20px;
        }

        /* --- BUTTONS --- */
        .btn-premium {
            background: linear-gradient(135deg, #D4AF37 0%, #F9C11C 100%);
            color: #020617;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.2em;
            padding: 14px 32px;
            border-radius: 12px;
            font-size: 10px;
            transition: all 0.4s cubic-bezier(0.23, 1, 0.32, 1);
            box-shadow: 0 10px 30px rgba(212, 175, 55, 0.2);
        }

        .btn-premium:hover {
            transform: translateY(-3px) scale(1.02);
            box-shadow: 0 15px 40px rgba(212, 175, 55, 0.3);
        }



        /* --- MOBILE SIDEBAR (RIGHT) --- */
        .mobile-menu {
            position: fixed;
            top: 0;
            right: -100%;
            width: 280px;
            height: 100%;
            background: #001A38;
            z-index: 1001;
            transition: right 0.35s cubic-bezier(0.4, 0, 0.2, 1);
            padding: 20px;
            overflow-y: auto;
            box-shadow: -10px 0 30px rgba(0,0,0,0.4);
        }

        .mobile-menu.active {
            right: 0;
        }

        .mobile-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.7);
            z-index: 999;
            display: none;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .mobile-overlay.active {
            display: block;
            opacity: 1;
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
        input[type="password"], input[type="tel"], textarea, select {
            color: #ffffff;
            caret-color: #D4AF37;
        }
        input::placeholder, textarea::placeholder {
            color: rgba(255, 255, 255, 0.2);
        }
        select option {
            background: #020617;
            color: #ffffff;
        }
        /* asset-card hover lift */
        .asset-card {
            transition: transform 0.5s cubic-bezier(0.23, 1, 0.32, 1), box-shadow 0.5s cubic-bezier(0.23, 1, 0.32, 1);
        }
        .asset-card:hover {
            transform: translateY(-8px);
        }
    </style>

    @stack('styles')
</head>
<body class="bg-[#020617] text-white">
    <div class="mesh-gradient"></div>
    <div class="noise-overlay"></div>

    <nav class="nav-glass sticky top-0 z-[100] transition-all duration-500">
        <div class="container mx-auto px-6 py-6 flex justify-between items-center">
            
            <a href="{{ url('/') }}" class="flex items-center space-x-4 group">
                <div class="w-12 h-12 bg-gradient-to-br from-[#D4AF37] to-[#F9C11C] rounded-2xl flex items-center justify-center font-black text-[#020617] shadow-xl shadow-yellow-500/10 group-hover:scale-110 transition-transform">
                    <span class="font-syne text-xl">U</span>
                </div>
                <div class="flex flex-col text-left">
                    <span class="text-2xl font-syne font-black tracking-tighter text-white uppercase leading-none">SI-ASET</span>
                    <span class="text-[8px] uppercase tracking-[0.4em] text-[#D4AF37] font-black mt-1">Divisi Operasional</span>
                </div>
            </a>

            <div class="hidden md:flex items-center space-x-12">
                <a href="{{ url('/') }}" class="nav-link-premium {{ Request::is('/') ? 'active' : '' }}">Beranda</a>
                <a href="{{ url('/katalog') }}" class="nav-link-premium {{ Request::is('katalog*') ? 'active' : '' }}">Katalog</a>
                <a href="{{ url('/kontak') }}" class="btn-premium">Kontak</a>

            </div>

            <div class="md:hidden flex items-center">
                <button id="mobile-menu-button" class="text-white p-2" onclick="openSidebar()">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
                    </svg>
                </button>
            </div>
        </div>
    </nav>

    <main class="relative z-10">
        @yield('content')
    </main>

    <footer class="bg-black/50 py-32 border-t border-white/5 relative z-10 overflow-hidden">
        <div class="container mx-auto px-6 text-center">
            <div class="mb-16">
                <div class="w-16 h-1 bg-gradient-to-r from-transparent via-[#D4AF37] to-transparent mx-auto mb-10"></div>
                <h3 class="text-3xl font-syne font-black text-white tracking-widest uppercase mb-4">Universitas Gadjah Mada</h3>
                <p class="text-[10px] font-black text-[#D4AF37] uppercase tracking-[0.6em]">Manajemen Aset Terpadu</p>
            </div>
            
            <div class="flex justify-center flex-wrap gap-8 mb-16 px-4">
                <a href="{{ url('/') }}" class="text-[9px] font-black text-white/30 uppercase tracking-[0.3em] hover:text-white transition-colors">Keamanan</a>
                <a href="{{ url('/') }}" class="text-[9px] font-black text-white/30 uppercase tracking-[0.3em] hover:text-white transition-colors">Privasi</a>
                <a href="{{ url('/') }}" class="text-[9px] font-black text-white/30 uppercase tracking-[0.3em] hover:text-white transition-colors">Kebijakan Layanan</a>
            </div>

            <p class="text-white/10 text-[8px] uppercase tracking-[0.5em]">© 2026 Infrastruktur Utama — Yogyakarta</p>
        </div>
    </footer>

    <script>
        function openSidebar() {
            document.querySelector('.mobile-menu').classList.add('active');
            document.querySelector('.mobile-overlay').classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        function closeSidebar() {
            document.querySelector('.mobile-menu').classList.remove('active');
            document.querySelector('.mobile-overlay').classList.remove('active');
            document.body.style.overflow = '';
        }

        document.addEventListener('DOMContentLoaded', () => {
            }
        });
    </script>

    <div class="mobile-overlay" id="mobile-overlay" onclick="closeSidebar()"></div>
    <div id="mobile-menu" class="mobile-menu glass-card !border-none !bg-[#020617]/95">
        <div class="flex justify-between items-center mb-10 pb-6 border-b border-white/5">
            <span class="text-white font-syne font-black text-xl tracking-tighter">SI-ASET</span>
            <button onclick="closeSidebar()" class="text-white/50 text-xl">✕</button>
        </div>
        <nav class="flex flex-col gap-6">
            <a href="{{ url('/') }}" class="text-sm font-black text-white/50 hover:text-[#D4AF37] uppercase tracking-widest">Beranda</a>
            <a href="{{ url('/katalog') }}" class="text-sm font-black text-white/50 hover:text-[#D4AF37] uppercase tracking-widest">Katalog</a>
            <a href="{{ url('/kontak') }}" class="text-sm font-black text-white/50 hover:text-[#D4AF37] uppercase tracking-widest">Kontak</a>
        </nav>
    </div>
</body>
</html>