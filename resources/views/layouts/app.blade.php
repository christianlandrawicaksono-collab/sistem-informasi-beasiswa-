<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SCOLA') — Sistem Informasi Beasiswa UNIKA</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="nomu-ambient-bg text-[#0F151D] min-h-screen flex flex-col selection:bg-[#FFEAE3] selection:text-[#0F151D]">

    <!-- Scroll Progress Hairline -->
    <div class="fixed top-0 left-0 right-0 h-[3px] z-50 pointer-events-none">
        <div data-motion="scroll-progress" class="h-full origin-left bg-linear-to-r from-[#F13F07] to-[#FF7448]" style="transform: scaleX(0);"></div>
    </div>

    <!-- Floating Pill Navbar (Inspired by Nomu.store) -->
    <header class="sticky top-4 z-40 px-4 sm:px-6 lg:px-8 pt-2">
        <div class="max-w-6xl mx-auto">
            <nav class="nomu-nav-pill rounded-full px-4 sm:px-6 py-2.5 flex items-center justify-between gap-4" aria-label="Navigasi utama">
                <!-- Brand -->
                <a href="{{ route('landing') }}" class="flex items-center gap-2.5 shrink-0 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#FF7448] rounded-full pr-2">
                    <div class="size-9 rounded-full bg-linear-to-tr from-[#F13F07] to-[#FF7448] flex items-center justify-center text-white shadow-sm">
                        <svg class="size-4.5" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M22 10v6M2 10l10-5 10 5-10 5z"/>
                            <path d="M6 12v5c3 3 9 3 12 0v-5"/>
                        </svg>
                    </div>
                    <div class="leading-tight">
                        <span class="text-base font-extrabold tracking-tight text-[#0F151D]">scola</span>
                        <span class="hidden sm:block text-[10px] font-mono uppercase tracking-wider text-[#5B6573]">UNIKA Soegijapranata</span>
                    </div>
                </a>

                <!-- Center Nav Links (Desktop) -->
                <div class="hidden md:flex items-center gap-1 bg-[#F1EBE9]/70 p-1 rounded-full">
                    <a href="{{ route('landing') }}" class="px-4 py-1.5 rounded-full text-xs font-semibold transition {{ request()->routeIs('landing') ? 'bg-white text-[#0F151D] shadow-xs' : 'text-[#5B6573] hover:text-[#0F151D]' }}">
                        Beranda
                    </a>
                    <a href="{{ route('landing') }}#daftar-beasiswa" class="px-4 py-1.5 rounded-full text-xs font-semibold text-[#5B6573] hover:text-[#0F151D] transition">
                        Katalog Beasiswa
                    </a>
                    <a href="{{ route('landing') }}#alur-seleksi" class="px-4 py-1.5 rounded-full text-xs font-semibold text-[#5B6573] hover:text-[#0F151D] transition">
                        Alur &amp; SPK SAW
                    </a>
                </div>

                <!-- Right Actions -->
                <div class="hidden md:flex items-center gap-2 shrink-0">
                    @auth
                        @php
                            $roleBadges = [
                                'admin' => ['bg' => 'bg-[#E4EDFF] text-[#243C61]', 'label' => 'Admin'],
                                'reviewer' => ['bg' => 'bg-[#FFEAE3] text-[#B83209]', 'label' => 'Reviewer SAW'],
                                'mahasiswa' => ['bg' => 'bg-[#E5F3EE] text-[#237C65]', 'label' => 'Mahasiswa'],
                            ];
                            $badge = $roleBadges[auth()->user()->role] ?? ['bg' => 'bg-[#F1EBE9] text-[#0F151D]', 'label' => 'User'];
                            $dashRoute = auth()->user()->isAdmin() ? route('admin.dashboard') : (auth()->user()->isReviewer() ? route('reviewer.dashboard') : route('mahasiswa.dashboard'));
                        @endphp

                        <span class="px-2.5 py-1 text-[11px] font-mono font-medium rounded-full {{ $badge['bg'] }}">
                            {{ $badge['label'] }}
                        </span>

                        <a href="{{ $dashRoute }}" data-motion="pill-press" class="px-4 py-2 rounded-full bg-[#0F151D] hover:bg-[#1B232E] text-white text-xs font-semibold transition">
                            Dashboard
                        </a>

                        <form action="{{ route('logout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="px-3 py-2 rounded-full text-xs font-semibold text-[#5B6573] hover:text-[#B83209] hover:bg-[#FFEAE3]/60 transition cursor-pointer" title="Keluar">
                                Keluar
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="px-4 py-2 rounded-full text-xs font-semibold text-[#0F151D] hover:bg-[#F1EBE9] transition">
                            Masuk
                        </a>
                        <a href="{{ route('register') }}" data-motion="pill-press" class="nomu-cta-btn px-4 py-2 rounded-full text-xs font-semibold">
                            Daftar Mahasiswa
                        </a>
                    @endauth
                </div>

                <!-- Mobile Hamburger Button -->
                <button id="mobile-menu-toggle" type="button" aria-label="Buka menu navigasi" aria-expanded="false" class="md:hidden size-10 rounded-full bg-[#F1EBE9] flex items-center justify-center text-[#0F151D] cursor-pointer">
                    <svg class="size-5" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <line x1="4" x2="20" y1="8" y2="8"/>
                        <line x1="4" x2="20" y1="16" y2="16"/>
                    </svg>
                </button>
            </nav>

            <!-- Mobile Menu Drawer -->
            <div id="mobile-menu-drawer" class="hidden md:hidden mt-2 p-4 rounded-[24px] bg-white border border-[#0F151D]/10 shadow-xl space-y-2">
                <a href="{{ route('landing') }}" class="block px-4 py-2.5 rounded-xl text-sm font-semibold text-[#0F151D] hover:bg-[#F1EBE9]">Beranda</a>
                <a href="{{ route('landing') }}#daftar-beasiswa" class="block px-4 py-2.5 rounded-xl text-sm font-medium text-[#5B6573] hover:bg-[#F1EBE9]">Katalog Beasiswa</a>
                <a href="{{ route('landing') }}#alur-seleksi" class="block px-4 py-2.5 rounded-xl text-sm font-medium text-[#5B6573] hover:bg-[#F1EBE9]">Alur &amp; SPK SAW</a>
                <div class="border-t border-[#0F151D]/8 pt-3 flex flex-col gap-2">
                    @auth
                        @php
                            $dashRoute = auth()->user()->isAdmin() ? route('admin.dashboard') : (auth()->user()->isReviewer() ? route('reviewer.dashboard') : route('mahasiswa.dashboard'));
                        @endphp
                        <a href="{{ $dashRoute }}" class="w-full text-center py-2.5 rounded-full bg-[#0F151D] text-white text-sm font-semibold">Buka Dashboard</a>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full py-2.5 rounded-full bg-[#FFEAE3] text-[#B83209] text-sm font-semibold">Keluar</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="w-full text-center py-2.5 rounded-full bg-[#F1EBE9] text-[#0F151D] text-sm font-semibold">Masuk</a>
                        <a href="{{ route('register') }}" class="w-full text-center py-2.5 rounded-full nomu-cta-btn text-sm font-semibold">Daftar Mahasiswa</a>
                    @endauth
                </div>
            </div>
        </div>
    </header>

    <!-- Flash Alerts -->
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 mt-5 w-full">
        @if(session('success'))
            <div role="status" class="p-4 mb-4 rounded-2xl bg-[#E5F3EE] border border-[#237C65]/20 text-[#185947] flex items-center gap-3 shadow-xs">
                <svg class="size-5 shrink-0 text-[#237C65]" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                    <polyline points="22 4 12 14.01 9 11.01"/>
                </svg>
                <p class="text-sm font-medium">{{ session('success') }}</p>
            </div>
        @endif

        @if(session('error'))
            <div role="alert" class="p-4 mb-4 rounded-2xl bg-[#FFEAE3] border border-[#F13F07]/20 text-[#9B2906] flex items-center gap-3 shadow-xs">
                <svg class="size-5 shrink-0 text-[#F13F07]" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <circle cx="12" cy="12" r="10"/>
                    <line x1="12" x2="12" y1="8" y2="12"/>
                    <line x1="12" x2="12.01" y1="16" y2="16"/>
                </svg>
                <p class="text-sm font-medium">{{ session('error') }}</p>
            </div>
        @endif
    </div>

    <!-- Main Content -->
    <main class="flex-1 max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-6 w-full">
        @yield('content')
    </main>

    <!-- Nomu-Inspired Dark Editorial Footer -->
    <footer class="bg-[#0D1117] text-[#FFF9F6] mt-20 rounded-t-[32px] sm:rounded-t-[48px]">
        <div class="max-w-6xl mx-auto px-6 sm:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-12 gap-8 pb-10 border-b border-white/10">
                <div class="md:col-span-6 space-y-3">
                    <div class="flex items-center gap-2.5">
                        <div class="size-9 rounded-full bg-linear-to-tr from-[#F13F07] to-[#FF7448] flex items-center justify-center text-white">
                            <svg class="size-4.5" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <path d="M22 10v6M2 10l10-5 10 5-10 5z"/>
                                <path d="M6 12v5c3 3 9 3 12 0v-5"/>
                            </svg>
                        </div>
                        <span class="text-xl font-extrabold tracking-tight">scola</span>
                    </div>
                    <p class="text-sm text-white/65 max-w-md leading-relaxed">
                        Sistem Informasi &amp; Manajemen Beasiswa terpusat untuk Universitas Katolik Soegijapranata (UNIKA) dengan seleksi berbasis <span class="text-[#FF7448] font-medium">Simple Additive Weighting (SAW)</span>.
                    </p>
                </div>

                <div class="md:col-span-3 space-y-2.5">
                    <p class="nomu-label text-white/45">Navigasi</p>
                    <ul class="space-y-2 text-sm text-white/75">
                        <li><a href="{{ route('landing') }}" class="hover:text-[#FF7448] transition">Beranda</a></li>
                        <li><a href="{{ route('landing') }}#daftar-beasiswa" class="hover:text-[#FF7448] transition">Katalog Beasiswa</a></li>
                        <li><a href="{{ route('login') }}" class="hover:text-[#FF7448] transition">Masuk Portal</a></li>
                    </ul>
                </div>

                <div class="md:col-span-3 space-y-2.5">
                    <p class="nomu-label text-white/45">Tim Pengembang</p>
                    <ul class="space-y-1.5 text-xs text-white/70">
                        <li>Anachasi Nathaniel B. W. <span class="font-mono text-white/40">· 24.N2.0002</span></li>
                        <li>Christian Landra W. <span class="font-mono text-white/40">· 24.N2.0003</span></li>
                        <li>William Wijaya Handoyo <span class="font-mono text-white/40">· 24.N2.0004</span></li>
                    </ul>
                </div>
            </div>

            <div class="pt-6 flex flex-col sm:flex-row justify-between items-center gap-3 text-xs text-white/45">
                <p>&copy; {{ date('Y') }} SCOLA — UNIKA Soegijapranata. Seluruh hak cipta dilindungi.</p>
                <p class="font-mono">Laravel 12 · Tailwind CSS v4 · Framer Motion</p>
            </div>
        </div>
    </footer>

</body>
</html>
