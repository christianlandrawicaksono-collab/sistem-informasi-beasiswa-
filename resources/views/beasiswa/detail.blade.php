@extends('layouts.app')

@section('title', $beasiswa->nama_program)

@section('content')
<div class="max-w-5xl mx-auto my-4">
    <div data-motion="hero-item" class="mb-8">
        <a href="{{ route('landing') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-[#5B6573] hover:text-[#FF7448] transition mb-4">
            <svg class="size-3.5" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m12 19-7-7 7-7"/><path d="M19 12H5"/></svg>
            <span>Kembali ke Katalog Beasiswa</span>
        </a>

        <div class="flex flex-wrap items-center gap-2 mb-3">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-[#E5F3EE] text-[#237C65] text-xs font-semibold">
                <span class="size-1.5 rounded-full bg-[#237C65]"></span>
                Pendaftaran Dibuka
            </span>
            <span class="px-3 py-1 rounded-full bg-[#F1EBE9] text-[#0F151D] text-xs font-semibold">
                {{ $beasiswa->kategori }}
            </span>
        </div>

        <h1 class="text-3xl sm:text-4xl font-extrabold text-[#0F151D] leading-tight">{{ $beasiswa->nama_program }}</h1>
        <p class="text-sm text-[#5B6573] mt-2">Diselenggarakan oleh <strong class="text-[#0F151D]">{{ $beasiswa->penyelenggara }}</strong></p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Details -->
        <div class="lg:col-span-2 space-y-6">
            <div data-motion="hero-item" class="nomu-card p-6 sm:p-7">
                <span class="nomu-label text-[#FF7448] block mb-2">Tentang Program</span>
                <h2 class="text-lg font-bold text-[#0F151D] mb-3">Deskripsi &amp; Tujuan Beasiswa</h2>
                <p class="text-sm text-[#5B6573] leading-relaxed">{{ $beasiswa->deskripsi }}</p>
            </div>

            <div data-motion="reveal" class="nomu-card p-6 sm:p-7">
                <span class="nomu-label text-[#FF7448] block mb-2">Administrasi</span>
                <h2 class="text-lg font-bold text-[#0F151D] mb-3">Persyaratan &amp; Berkas Wajib</h2>
                <div class="text-sm text-[#5B6573] whitespace-pre-line leading-relaxed bg-[#FFF9F6] p-4 rounded-2xl border border-[#0F151D]/6">{{ $beasiswa->persyaratan }}</div>
            </div>

            @if($beasiswa->kriteria->isNotEmpty())
                <div data-motion="reveal" class="nomu-panel p-6 sm:p-7">
                    <span class="nomu-label text-[#526991] block mb-1.5">Metode Seleksi</span>
                    <h2 class="text-lg font-bold text-[#0F151D] mb-4">Kriteria Penilaian SPK (SAW)</h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        @foreach($beasiswa->kriteria as $c)
                            <div class="p-4 rounded-2xl bg-[#E4EDFF]/70 border border-[#526991]/15 flex justify-between items-center">
                                <div>
                                    <span class="nomu-label text-[#526991] block">{{ $c->kode_kriteria }} · {{ $c->sifat }}</span>
                                    <span class="font-bold text-sm text-[#0F151D]">{{ $c->nama_kriteria }}</span>
                                </div>
                                <span class="font-mono font-extrabold text-base text-[#243C61] bg-white px-3 py-1 rounded-full shadow-xs tabular-nums">
                                    {{ $c->bobot }}%
                                </span>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        <!-- Sidebar CTA Card -->
        <div class="lg:col-span-1">
            <div data-motion="hero-item" class="nomu-panel p-6 sticky top-24">
                <span class="nomu-label text-[#FF7448] block mb-1">Ringkasan</span>
                <h3 class="text-lg font-bold text-[#0F151D] mb-5 pb-3 border-b border-[#0F151D]/8">Informasi Pendaftaran</h3>

                <div class="space-y-3.5 text-sm mb-6">
                    <div class="flex justify-between items-center">
                        <span class="text-[#5B6573]">Batas Waktu</span>
                        <span class="font-bold text-[#0F151D] font-mono tabular-nums">{{ $beasiswa->tgl_tutup->format('d M Y') }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-[#5B6573]">Alokasi Kuota</span>
                        <span class="font-bold text-[#0F151D] tabular-nums">{{ $beasiswa->kuota }} Mahasiswa</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-[#5B6573]">Minimal IPK</span>
                        <span class="font-bold text-[#FF7448] font-mono tabular-nums">{{ number_format($beasiswa->ipk_minimal, 2) }}</span>
                    </div>
                </div>

                @auth
                    @if(auth()->user()->isMahasiswa())
                        <form action="{{ route('mahasiswa.ajukan', $beasiswa->id) }}" method="POST">
                            @csrf
                            <button type="submit" data-motion="pill-press" class="w-full py-3.5 rounded-full nomu-cta-btn font-bold text-sm cursor-pointer">
                                Ajukan Beasiswa Ini
                            </button>
                        </form>
                    @else
                        <div class="p-3.5 rounded-2xl bg-[#F1EBE9] text-xs text-[#5B6573] text-center">
                            Login sebagai <strong class="text-[#0F151D]">{{ strtoupper(auth()->user()->role) }}</strong>. Pendaftaran khusus akun Mahasiswa.
                        </div>
                    @endif
                @else
                    <a href="{{ route('login') }}" data-motion="pill-press" class="block text-center w-full py-3.5 rounded-full nomu-cta-btn font-bold text-sm">
                        Masuk untuk Mendaftar
                    </a>
                @endauth
            </div>
        </div>
    </div>
</div>
@endsection
