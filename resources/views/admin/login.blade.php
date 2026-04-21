<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin | SI-ASET UGM</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;900&family=Syne:wght@700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        :root {
            --obsidian: #020617;
            --gold: #D4AF37;
            --emerald: #10B981;
        }
        body {
            font-family: 'Outfit', sans-serif;
            background: var(--obsidian);
        }
        .mesh-gradient {
            position: fixed;
            inset: 0;
            background: 
                radial-gradient(circle at 20% 30%, rgba(212, 175, 55, 0.05) 0%, transparent 40%),
                radial-gradient(circle at 80% 70%, rgba(16, 185, 129, 0.05) 0%, transparent 40%),
                radial-gradient(circle at 50% 50%, rgba(59, 130, 246, 0.05) 0%, transparent 40%);
            z-index: 1;
        }
        .glass-card {
            background: rgba(255, 255, 255, 0.02);
            backdrop-filter: blur(40px);
            border: 1px solid rgba(255, 255, 255, 0.05);
            box-shadow: 0 40px 100px rgba(0, 0, 0, 0.5);
        }
        .btn-premium {
            background: var(--gold);
            color: var(--obsidian);
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: 0.15em;
            transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }
        .btn-premium:hover {
            transform: scale(1.02);
            box-shadow: 0 20px 40px rgba(212, 175, 55, 0.2);
            filter: brightness(1.1);
        }
        @keyframes reveal {
            from { opacity: 0; transform: translateY(30px) scale(0.95); }
            to { opacity: 1; transform: translateY(0) scale(1); }
        }
        .animate-reveal {
            animation: reveal 1.2s cubic-bezier(0.2, 0.8, 0.2, 1) forwards;
        }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen p-4 md:p-8 lg:p-12 py-12 md:py-20">
    <div class="mesh-gradient"></div>

    <div class="relative z-10 w-full max-w-xl animate-reveal">
        {{-- GLOWING ORB BEHIND CARD --}}
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-80 h-80 bg-[#D4AF37] opacity-10 blur-[100px] rounded-full"></div>

        <div class="glass-card rounded-[2.5rem] md:rounded-[4rem] p-8 md:p-16 lg:p-20 relative overflow-hidden">
            <div class="absolute top-0 right-0 w-40 h-40 bg-white/5 -mr-20 -mt-20 rounded-full blur-3xl"></div>
            
            <div class="text-center mb-8 md:mb-16 space-y-4">
                <div class="inline-flex items-center gap-3 px-3 py-1 rounded-full bg-white/5 border border-white/10 mb-2">
                    <span class="w-1.5 h-1.5 rounded-full bg-[#D4AF37] animate-pulse"></span>
                    <span class="text-[9px] font-black uppercase tracking-[0.4em] text-white/40">Login Admin</span>
                </div>
                <h1 class="text-3xl md:text-5xl font-syne font-black text-white tracking-tighter leading-none uppercase">
                    SI-ASET <br>
                    <span class="text-[#D4AF37] italic tracking-normal">NEXUS.</span>
                </h1>
                <p class="text-[9px] md:text-[10px] font-black text-white/20 uppercase tracking-[0.4em]">Administrative Access Required</p>
            </div>

            @if($errors->any() || session('error'))
            <div class="bg-red-500/10 border border-red-500/20 p-5 rounded-2xl mb-10 flex items-center gap-4 text-[10px] font-black uppercase tracking-widest text-red-500 animate-pulse">
                <span>🚫</span> {{ $errors->first() ?: session('error') }}
            </div>
            @endif

            <form method="POST" action="{{ route('admin.login.post') }}" class="space-y-6 md:space-y-10">
                @csrf
                
                <div class="space-y-4">
                    <label class="text-[9px] font-black uppercase tracking-[0.4em] text-white/20 ml-2">Alamat Email Admin</label>
                    <input type="email" name="email" value="{{ old('email') }}" placeholder="admin@nexus.ugm" required
                        class="w-full bg-white/5 border border-white/5 py-5 px-8 rounded-2xl outline-none focus:ring-1 focus:ring-[#D4AF37] transition-all text-white font-bold placeholder-white/10 text-sm">
                </div>

                <div class="space-y-4">
                    <label class="text-[9px] font-black uppercase tracking-[0.4em] text-white/20 ml-2">Security Key (Password)</label>
                    <input type="password" name="password" placeholder="••••••••" required
                        class="w-full bg-white/5 border border-white/5 py-5 px-8 rounded-2xl outline-none focus:ring-1 focus:ring-[#D4AF37] transition-all text-white font-bold placeholder-white/10 text-sm">
                </div>

                <div class="pt-6">
                    <button type="submit" class="btn-premium w-full py-5 rounded-2xl text-xs flex items-center justify-center gap-4 group">
                        Masuk ke Dashboard
                        <span class="opacity-30 group-hover:opacity-100 group-hover:translate-x-2 transition-all">→</span>
                    </button>
                </div>
            </form>

            <div class="text-center mt-12">
                <p class="text-[9px] font-black text-white/10 uppercase tracking-[0.5em]">
                    &copy; MMXXVI ACADEMIC CORE INFRASTRUCTURE
                </p>
            </div>
        </div>
    </div>
</body>
</html>

