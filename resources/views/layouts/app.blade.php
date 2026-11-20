<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SCOLA') - Sistem Informasi Beasiswa UNIKA</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 min-h-screen flex flex-col">

    <!-- Top Navigation Bar -->
    <nav class="bg-white border-b border-slate-200 sticky top-0 z-50 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <!-- Brand / Logo -->
                <div class="flex items-center space-x-3">
                    <a href="{{ route('landing') }}" class="flex items-center space-x-2">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-amber-500 to-yellow-400 flex items-center justify-center text-white shadow-md shadow-amber-200">
                            <i class="fa-solid fa-graduation-cap text-lg"></i>
                        </div>
                        <div>
                            <span class="text-xl font-extrabold tracking-tight text-slate-900">SCOLA</span>
                            <span class="text-xs block text-slate-500 font-medium -mt-1">UNIKA Soegijapranata</span>
                        </div>
                    </a>

                    <!-- Nav Links -->
                    <div class="hidden md:flex ml-8 space-x-6">
                        <a href="{{ route('landing') }}" class="text-sm font-semibold {{ request()->routeIs('landing') ? 'text-amber-600' : 'text-slate-600 hover:text-slate-900' }}">Beranda</a>
                        <a href="{{ route('landing') }}#daftar-beasiswa" class="text-sm font-medium text-slate-600 hover:text-slate-900">Daftar Beasiswa</a>
                    </div>
                </div>

                <!-- User Profile / Auth Action -->
                <div class="flex items-center space-x-4">
                    @auth
                        <!-- Role Badge -->
                        @php
                            $roleBadges = [
                                'admin' => ['bg' => 'bg-purple-100 text-purple-700 border-purple-200', 'label' => 'Admin Kemahasiswaan'],
                                'reviewer' => ['bg' => 'bg-blue-100 text-blue-700 border-blue-200', 'label' => 'Tim Reviewer'],
                                'mahasiswa' => ['bg' => 'bg-emerald-100 text-emerald-700 border-emerald-200', 'label' => 'Mahasiswa'],
                            ];
                            $badge = $roleBadges[auth()->user()->role] ?? ['bg' => 'bg-slate-100 text-slate-700 border-slate-200', 'label' => 'User'];
                        @endphp
                        <span class="hidden sm:inline-flex px-2.5 py-1 text-xs font-semibold rounded-full border {{ $badge['bg'] }}">
                            {{ $badge['label'] }}
                        </span>

                        <!-- Dashboard Direct Link -->
                        @if(auth()->user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}" class="text-sm font-semibold text-slate-700 hover:text-amber-600 flex items-center space-x-1">
                                <i class="fa-solid fa-gauge-high text-xs"></i>
                                <span>Dashboard</span>
                            </a>
                        @elseif(auth()->user()->isReviewer())
                            <a href="{{ route('reviewer.dashboard') }}" class="text-sm font-semibold text-slate-700 hover:text-amber-600 flex items-center space-x-1">
                                <i class="fa-solid fa-chart-simple text-xs"></i>
                                <span>Reviewer</span>
                            </a>
                        @else
                            <a href="{{ route('mahasiswa.dashboard') }}" class="text-sm font-semibold text-slate-700 hover:text-amber-600 flex items-center space-x-1">
                                <i class="fa-solid fa-user-graduate text-xs"></i>
                                <span>Portal Mahasiswa</span>
                            </a>
                        @endif

                        <!-- Logout Button -->
                        <form action="{{ route('logout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="text-sm text-rose-600 hover:text-rose-800 font-medium px-3 py-1.5 rounded-lg hover:bg-rose-50 transition">
                                <i class="fa-solid fa-arrow-right-from-bracket mr-1"></i> Keluar
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="text-sm font-semibold text-slate-700 hover:text-slate-900 px-3 py-2">Masuk</a>
                        <a href="{{ route('register') }}" class="text-sm font-semibold bg-amber-500 hover:bg-amber-600 text-white px-4 py-2 rounded-xl shadow-sm transition shadow-amber-200">
                            Daftar Mahasiswa
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Flash Alerts -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4 w-full">
        @if(session('success'))
            <div class="p-4 mb-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 flex items-start space-x-3 shadow-sm">
                <i class="fa-solid fa-circle-check text-emerald-500 text-lg mt-0.5"></i>
                <div class="text-sm font-medium">{{ session('success') }}</div>
            </div>
        @endif

        @if(session('error'))
            <div class="p-4 mb-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 flex items-start space-x-3 shadow-sm">
                <i class="fa-solid fa-circle-exclamation text-rose-500 text-lg mt-0.5"></i>
                <div class="text-sm font-medium">{{ session('error') }}</div>
            </div>
        @endif
    </div>

    <!-- Main Content -->
    <main class="flex-1 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 w-full">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-slate-200 py-6 text-center text-xs text-slate-500 mt-12">
        <div class="max-w-7xl mx-auto px-4">
            <p class="font-semibold text-slate-700 mb-1">SCOLA - Sistem Informasi & Manajemen Beasiswa UNIKA Soegijapranata</p>
            <p>Dibuat oleh Tim Pengembang SCOLA: Anachasi Nathaniel • Christian Landra • William Wijaya</p>
        </div>
    </footer>

</body>
</html>
