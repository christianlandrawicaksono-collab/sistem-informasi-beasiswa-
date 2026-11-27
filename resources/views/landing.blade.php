@extends('layouts.app')

@section('title', 'Portal Beasiswa UNIKA')

@section('content')
<!-- 1. Editorial Hero Section (Inspired by Nomu.store) -->
<section class="pt-6 sm:pt-10 pb-14 text-center relative">
    <div class="max-w-3xl mx-auto">
        <div data-motion="hero-item" class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-[#F1EBE9] border border-[#0F151D]/8 text-xs font-medium text-[#0F151D] mb-6">
            <span class="size-2 rounded-full bg-[#FF7448]"></span>
            <span>Portal Resmi Beasiswa UNIKA Soegijapranata</span>
        </div>

        <h1 data-motion="hero-item" class="text-4xl sm:text-6xl font-extrabold text-[#0F151D] leading-[1.06] tracking-[-0.035em] text-balance mb-5">
            Temukan &amp; Ajukan Beasiswa <span class="text-[#FF7448]">Secara Terpusat.</span>
        </h1>

        <p data-motion="hero-item" class="text-base sm:text-lg text-[#5B6573] max-w-2xl mx-auto leading-relaxed mb-9">
            Satu platform terintegrasi untuk menjelajahi peluang bantuan studi internal maupun eksternal, mengunggah berkas persyaratan, hingga memantau seleksi berbasis metode SAW secara transparan.
        </p>

        <!-- Prompt-Style Search & Filter Bar (Inspired by Nomu Prompt Pill) -->
        <form data-motion="hero-item" action="{{ route('landing') }}" method="GET" class="max-w-2xl mx-auto bg-white p-2 rounded-[28px] sm:rounded-full border border-[#0F151D]/10 shadow-[0_16px_40px_-24px_rgba(15,21,29,0.28)] flex flex-col sm:flex-row items-stretch sm:items-center gap-2">
            <div class="flex-1 relative flex items-center">
                <svg class="size-4.5 text-[#5B6573] absolute left-4 pointer-events-none" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <circle cx="11" cy="11" r="8"/>
                    <path d="m21 21-4.3-4.3"/>
                </svg>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari beasiswa atau penyelenggara..." aria-label="Cari beasiswa" class="w-full pl-11 pr-4 py-3 rounded-full bg-transparent text-sm text-[#0F151D] placeholder:text-[#5B6573]/70 focus:outline-none">
            </div>

            <div class="sm:border-l sm:border-[#0F151D]/10 sm:pl-2">
                <select name="kategori" aria-label="Filter kategori beasiswa" class="w-full sm:w-auto px-3 py-3 rounded-full bg-[#F7F5EE] sm:bg-transparent text-xs font-semibold text-[#0F151D] focus:outline-none cursor-pointer">
                    <option value="">Semua Kategori</option>
                    <option value="Prestasi Akademik" {{ request('kategori') == 'Prestasi Akademik' ? 'selected' : '' }}>Prestasi Akademik</option>
                    <option value="Bantuan Ekonomi" {{ request('kategori') == 'Bantuan Ekonomi' ? 'selected' : '' }}>Bantuan Ekonomi</option>
                    <option value="Eksternal" {{ request('kategori') == 'Eksternal' ? 'selected' : '' }}>Beasiswa Eksternal</option>
                </select>
            </div>

            <button type="submit" data-motion="pill-press" class="nomu-cta-btn px-6 py-3 rounded-full text-xs font-bold tracking-wide cursor-pointer shrink-0">
                Cari Program
            </button>
        </form>

        <!-- Quick Category Chips -->
        <div data-motion="hero-item" class="mt-5 flex flex-wrap items-center justify-center gap-2 text-xs">
            <span class="text-[#5B6573] mr-1">Populer:</span>
            <a href="{{ route('landing', ['kategori' => 'Prestasi Akademik']) }}" class="px-3 py-1 rounded-full bg-white border border-[#0F151D]/8 text-[#0F151D] hover:border-[#FF7448]/50 transition font-medium">Prestasi Akademik</a>
            <a href="{{ route('landing', ['kategori' => 'Bantuan Ekonomi']) }}" class="px-3 py-1 rounded-full bg-white border border-[#0F151D]/8 text-[#0F151D] hover:border-[#FF7448]/50 transition font-medium">Bantuan Ekonomi</a>
            <a href="{{ route('landing', ['kategori' => 'Eksternal']) }}" class="px-3 py-1 rounded-full bg-white border border-[#0F151D]/8 text-[#0F151D] hover:border-[#FF7448]/50 transition font-medium">Mitra Eksternal</a>
        </div>
    </div>
</section>

<!-- 2. Nomu-Style Interactive Numbered Journey Strip -->
<section id="alur-seleksi" data-motion="reveal" class="mb-16">
    <div class="nomu-panel p-3 sm:p-4">
        <div class="grid grid-cols-2 sm:grid-cols-5 gap-2" role="tablist" aria-label="Tahapan Pendaftaran SCOLA">
            @php
                $journeySteps = [
                    ['num' => '01', 'title' => 'Eksplorasi Program', 'desc' => 'Mahasiswa menjelajahi daftar beasiswa internal & eksternal lengkap dengan kuota dan batas IPK minimal.'],
                    ['num' => '02', 'title' => 'Profil & Ekonomi', 'desc' => 'Melengkapi data akademik (IPK, semester) serta kondisi ekonomi keluarga untuk pencocokan kriteria otomatis.'],
                    ['num' => '03', 'title' => 'Unggah Berkas', 'desc' => 'Upload KHS, KTM, Kartu Keluarga, dan Slip Gaji format PDF/JPG langsung dengan pelacakan revisi.'],
                    ['num' => '04', 'title' => 'Verifikasi & SAW', 'desc' => 'Admin memverifikasi keabsahan berkas, lalu sistem menghitung bobot skor akhir menggunakan metode SAW.'],
                    ['num' => '05', 'title' => 'Pengumuman Hasil', 'desc' => 'Hasil kelulusan berdasarkan peringkat SAW & kuota langsung dipublikasikan ke dashboard mahasiswa.'],
                ];
            @endphp

            @foreach($journeySteps as $idx => $step)
                <button type="button"
                    data-journey-step="{{ $step['num'] }}"
                    data-active="{{ $idx === 0 ? 'true' : 'false' }}"
                    class="group text-left p-3.5 rounded-[20px] transition cursor-pointer border border-transparent
                           data-[active=true]:bg-[#FFF9F6] data-[active=true]:border-[#FF7448]/25 data-[active=true]:shadow-xs
                           hover:bg-[#FFF9F6]/60">
                    <span class="nomu-label block mb-1 text-[#5B6573] group-data-[active=true]:text-[#FF7448]">{{ $step['num'] }}</span>
                    <span class="text-xs sm:text-sm font-bold text-[#0F151D] block leading-snug">{{ $step['title'] }}</span>
                    <span class="block h-[2px] mt-2.5 rounded-full bg-transparent group-data-[active=true]:bg-linear-to-r group-data-[active=true]:from-[#F13F07] group-data-[active=true]:to-[#FF7448]"></span>
                </button>
            @endforeach
        </div>

        <div class="mt-3 p-5 sm:p-6 rounded-[22px] bg-[#FFF9F6] border border-[#0F151D]/6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            @foreach($journeySteps as $idx => $step)
                <div data-journey-panel="{{ $step['num'] }}" class="{{ $idx === 0 ? '' : 'hidden' }} flex-1">
                    <span class="nomu-label text-[#FF7448] block mb-1">Tahap {{ $step['num'] }} — Alur Sistem SCOLA</span>
                    <h3 class="text-base sm:text-lg font-bold text-[#0F151D] mb-1">{{ $step['title'] }}</h3>
                    <p class="text-sm text-[#5B6573]">{{ $step['desc'] }}</p>
                </div>
            @endforeach
            <div class="shrink-0">
                @auth
                    <a href="{{ auth()->user()->isMahasiswa() ? route('mahasiswa.dashboard') : route('admin.dashboard') }}" data-motion="pill-press" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full bg-[#0F151D] text-white text-xs font-semibold hover:bg-[#1B232E] transition">
                        <span>Buka Portal Saya</span>
                        <svg class="size-3.5" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                    </a>
                @else
                    <a href="{{ route('register') }}" data-motion="pill-press" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full nomu-cta-btn text-xs font-semibold">
                        <span>Mulai Daftar</span>
                        <svg class="size-3.5" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                    </a>
                @endauth
            </div>
        </div>
    </div>
</section>

<!-- 3. Katalog Program Beasiswa -->
<section id="daftar-beasiswa" class="mb-20">
    <div data-motion="reveal" class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 mb-8">
        <div>
            <span class="nomu-label text-[#FF7448] block mb-1.5">Direktori Beasiswa Aktif</span>
            <h2 class="text-2xl sm:text-3xl font-extrabold text-[#0F151D]">Program Sedang Dibuka</h2>
        </div>
        <div class="flex items-center gap-2">
            @if(request()->filled('search') || request()->filled('kategori'))
                <a href="{{ route('landing') }}" class="px-3.5 py-1.5 rounded-full bg-[#FFEAE3] text-[#B83209] text-xs font-semibold hover:brightness-95 transition">
                    Reset Filter
                </a>
            @endif
            <span class="px-3.5 py-1.5 rounded-full bg-[#E4EDFF] text-[#243C61] text-xs font-mono font-medium tabular-nums">
                {{ $beasiswas->count() }} Program Tersedia
            </span>
        </div>
    </div>

    @if($beasiswas->isEmpty())
        <div class="nomu-panel p-12 text-center">
            <div class="size-12 rounded-2xl bg-[#F1EBE9] text-[#5B6573] mx-auto mb-3 flex items-center justify-center">
                <svg class="size-6" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
            </div>
            <h3 class="text-base font-bold text-[#0F151D]">Tidak ada beasiswa yang cocok</h3>
            <p class="text-sm text-[#5B6573] mt-1">Coba atur ulang kata kunci pencarian atau pilih kategori lain.</p>
            <a href="{{ route('landing') }}" class="inline-block mt-5 px-5 py-2 rounded-full bg-[#0F151D] text-white text-xs font-semibold">Lihat Semua Program</a>
        </div>
    @else
        <div data-motion="stagger-grid" class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($beasiswas as $b)
                <article data-motion-card data-motion="card-hover" class="nomu-card nomu-card-interactive p-6 flex flex-col justify-between">
                    <div>
                        <!-- Top Badges -->
                        <div class="flex items-center justify-between gap-2 mb-5">
                            <span class="px-3 py-1 rounded-full bg-[#F1EBE9] text-[#0F151D] text-[11px] font-semibold">
                                {{ $b->kategori }}
                            </span>
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-[#E5F3EE] text-[#237C65] text-[11px] font-semibold">
                                <span class="size-1.5 rounded-full bg-[#237C65]"></span>
                                Dibuka
                            </span>
                        </div>

                        <!-- Title & Organizer -->
                        <h3 class="text-lg font-extrabold text-[#0F151D] leading-snug mb-1.5">
                            {{ $b->nama_program }}
                        </h3>
                        <p class="text-xs font-medium text-[#5B6573] flex items-center gap-1.5 mb-3">
                            <svg class="size-3.5 shrink-0 text-[#FF7448]" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M6 22V4a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v18Z"/><path d="M6 12H4a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h2"/><path d="M18 9h2a2 2 0 0 1 2 2v9a2 2 0 0 1-2 2h-2"/><path d="M10 6h4"/><path d="M10 10h4"/><path d="M10 14h4"/><path d="M10 18h4"/></svg>
                            <span>{{ $b->penyelenggara }}</span>
                        </p>

                        <p class="text-sm text-[#5B6573] line-clamp-2 leading-relaxed mb-6">
                            {{ $b->deskripsi }}
                        </p>
                    </div>

                    <div>
                        <!-- Metadata Bento Strip -->
                        <div class="grid grid-cols-3 gap-2 p-3 rounded-2xl bg-[#FFF9F6] border border-[#0F151D]/6 mb-5 text-center">
                            <div>
                                <span class="block text-[10px] font-mono uppercase text-[#5B6573]">Tenggat</span>
                                <span class="text-xs font-bold text-[#0F151D] tabular-nums">{{ $b->tgl_tutup->format('d M y') }}</span>
                            </div>
                            <div class="border-x border-[#0F151D]/8">
                                <span class="block text-[10px] font-mono uppercase text-[#5B6573]">Kuota</span>
                                <span class="text-xs font-bold text-[#0F151D] tabular-nums">{{ $b->kuota }} Kursi</span>
                            </div>
                            <div>
                                <span class="block text-[10px] font-mono uppercase text-[#5B6573]">Min. IPK</span>
                                <span class="text-xs font-bold text-[#FF7448] tabular-nums">{{ number_format($b->ipk_minimal, 2) }}</span>
                            </div>
                        </div>

                        <a href="{{ route('beasiswa.detail', $b->id) }}" data-motion="pill-press" class="w-full py-3 rounded-full bg-[#0F151D] hover:bg-[#FF7448] text-white text-xs font-bold flex items-center justify-center gap-2 transition-colors">
                            <span>Lihat Detail &amp; Persyaratan</span>
                            <svg class="size-3.5" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                        </a>
                    </div>
                </article>
            @endforeach
        </div>
    @endif
</section>

<!-- 4. Nomu-Signature Comparison Panel (Cara Lama vs SCOLA) -->
<section data-motion="reveal" class="mb-8">
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-6 px-2">
        <div>
            <span class="nomu-label text-[#FF7448] block mb-1.5">Keunggulan Sistem</span>
            <h2 class="text-2xl sm:text-3xl font-extrabold text-[#0F151D]">
                Mengapa Pengelolaan Beasiswa Beralih ke <span class="text-[#FF7448]">SCOLA</span>
            </h2>
        </div>
        <p class="text-sm text-[#5B6573] max-w-md">
            Dirancang khusus untuk menjawab permasalahan distribusi informasi dan transparansi seleksi beasiswa di lingkungan UNIKA.
        </p>
    </div>

    <div class="nomu-panel p-2 sm:p-3 overflow-x-auto">
        <table class="w-full text-left border-collapse min-w-[600px]">
            <thead>
                <tr>
                    <th class="p-5 text-xs font-mono uppercase tracking-wider text-[#5B6573] w-[30%]">Aspek Pengelolaan</th>
                    <th class="p-5 text-sm font-semibold text-[#5B6573] w-[35%]">Proses Konvensional (Manual)</th>
                    <th class="p-6 bg-[#D3E1FF] rounded-t-[24px] w-[35%]">
                        <span class="nomu-label text-[#526991] block mb-1">Platform Terintegrasi</span>
                        <span class="text-lg font-extrabold text-[#0F151D]">SCOLA UNIKA</span>
                    </th>
                </tr>
            </thead>
            <tbody class="text-sm">
                <tr class="border-t border-[#0F151D]/6">
                    <td class="p-5 font-semibold text-[#0F151D] bg-[#F8F9FB] rounded-l-xl">
                        <span class="block text-[10px] font-mono text-[#5B6573] mb-0.5">01</span>
                        Informasi Program
                    </td>
                    <td class="p-5 text-[#5B6573] bg-[#F8F9FB]">Tersebar di banyak papan pengumuman &amp; chat grup</td>
                    <td class="p-5 bg-[#DCE7FF] text-[#243C61] font-semibold">
                        <span class="inline-flex items-center gap-2.5">
                            <span class="size-5 rounded-full bg-white/80 text-[#237C65] inline-flex items-center justify-center shrink-0">
                                <svg class="size-3" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" aria-hidden="true"><polyline points="20 6 9 17 4 12"/></svg>
                            </span>
                            Terpusat dengan Filter Kategori &amp; Rekomendasi IPK
                        </span>
                    </td>
                </tr>
                <tr class="border-t border-[#0F151D]/6">
                    <td class="p-5 font-semibold text-[#0F151D]">
                        <span class="block text-[10px] font-mono text-[#5B6573] mb-0.5">02</span>
                        Pengumpulan &amp; Revisi Berkas
                    </td>
                    <td class="p-5 text-[#5B6573]">Berkas fisik / email rawan hilang, revisi lambat</td>
                    <td class="p-5 bg-[#E4EDFF] text-[#243C61] font-semibold">
                        <span class="inline-flex items-center gap-2.5">
                            <span class="size-5 rounded-full bg-white/80 text-[#237C65] inline-flex items-center justify-center shrink-0">
                                <svg class="size-3" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" aria-hidden="true"><polyline points="20 6 9 17 4 12"/></svg>
                            </span>
                            Unggah Online &amp; Pelacakan Status Real-Time
                        </span>
                    </td>
                </tr>
                <tr class="border-t border-[#0F151D]/6">
                    <td class="p-5 font-semibold text-[#0F151D] bg-[#F8F9FB] rounded-l-xl">
                        <span class="block text-[10px] font-mono text-[#5B6573] mb-0.5">03</span>
                        Seleksi &amp; Perangkingan
                    </td>
                    <td class="p-5 text-[#5B6573] bg-[#F8F9FB]">Rekap spreadsheet manual rentan bias &amp; human error</td>
                    <td class="p-5 bg-[#DCE7FF] text-[#243C61] font-semibold rounded-b-[24px]">
                        <span class="inline-flex items-center gap-2.5">
                            <span class="size-5 rounded-full bg-white/80 text-[#237C65] inline-flex items-center justify-center shrink-0">
                                <svg class="size-3" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" aria-hidden="true"><polyline points="20 6 9 17 4 12"/></svg>
                            </span>
                            Otomatis &amp; Objektif dengan Algoritma SPK SAW
                        </span>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</section>
@endsection
