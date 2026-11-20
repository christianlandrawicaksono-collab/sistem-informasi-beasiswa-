@extends('layouts.app')

@section('title', 'Katalog Beasiswa UNIKA')

@section('content')
<!-- Hero Section (Sesuai Wireframe 1) -->
<div class="text-center py-12 px-4 bg-gradient-to-b from-amber-50 to-white rounded-3xl border border-amber-100 shadow-sm mb-12">
    <div class="inline-flex items-center space-x-2 px-3 py-1 rounded-full bg-amber-100 text-amber-800 text-xs font-semibold mb-4">
        <i class="fa-solid fa-bullhorn text-amber-600"></i>
        <span>Portal Resmi Beasiswa Universitas Katolik Soegijapranata</span>
    </div>
    <h1 class="text-3xl sm:text-5xl font-extrabold text-slate-900 tracking-tight mb-4">
        Sistem Informasi Beasiswa UNIKA
    </h1>
    <p class="text-slate-600 max-w-2xl mx-auto text-base sm:text-lg mb-8">
        Temukan peluang bantuan pendidikan, beasiswa prestasi, dan kemitraan eksternal untuk mendukung perjalanan studi Anda di UNIKA.
    </p>

    <!-- Search & Filter Form (Sesuai Mockup 1) -->
    <form action="{{ route('landing') }}" method="GET" class="max-w-3xl mx-auto grid grid-cols-1 sm:grid-cols-12 gap-3 p-2 bg-white rounded-2xl shadow-lg border border-slate-200">
        <div class="sm:col-span-6 relative">
            <i class="fa-solid fa-magnifying-glass absolute left-4 top-3.5 text-slate-400"></i>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama beasiswa atau penyelenggara..." class="w-full pl-11 pr-4 py-2.5 rounded-xl border-none focus:ring-2 focus:ring-amber-500 text-sm bg-slate-50 focus:bg-white">
        </div>
        <div class="sm:col-span-4">
            <select name="kategori" class="w-full py-2.5 px-3 rounded-xl border-none focus:ring-2 focus:ring-amber-500 text-sm bg-slate-50 focus:bg-white text-slate-700">
                <option value="">Semua Kategori</option>
                <option value="Prestasi Akademik" {{ request('kategori') == 'Prestasi Akademik' ? 'selected' : '' }}>Prestasi Akademik</option>
                <option value="Bantuan Ekonomi" {{ request('kategori') == 'Bantuan Ekonomi' ? 'selected' : '' }}>Bantuan Ekonomi</option>
                <option value="Eksternal" {{ request('kategori') == 'Eksternal' ? 'selected' : '' }}>Beasiswa Eksternal</option>
            </select>
        </div>
        <div class="sm:col-span-2">
            <button type="submit" class="w-full h-full py-2.5 bg-amber-500 hover:bg-amber-600 text-white font-semibold rounded-xl text-sm transition shadow-sm shadow-amber-200 flex items-center justify-center space-x-1">
                <span>Cari</span>
            </button>
        </div>
    </form>
</div>

<!-- Daftar Beasiswa Sedang Dibuka (Sesuai Wireframe 1) -->
<div id="daftar-beasiswa" class="mb-12">
    <div class="flex justify-between items-end mb-6">
        <div>
            <h2 class="text-2xl font-bold text-slate-900">Beasiswa Sedang Dibuka</h2>
            <p class="text-sm text-slate-500">Pilih program beasiswa dan lengkapi pengajuan sebelum batas waktu berakhir.</p>
        </div>
        <span class="text-xs font-semibold px-3 py-1 bg-slate-100 text-slate-600 rounded-full">
            {{ $beasiswas->count() }} Program Tersedia
        </span>
    </div>

    @if($beasiswas->isEmpty())
        <div class="bg-white rounded-2xl p-12 text-center border border-slate-200">
            <i class="fa-regular fa-folder-open text-4xl text-slate-300 mb-3"></i>
            <h3 class="text-base font-semibold text-slate-700">Tidak ada beasiswa yang cocok</h3>
            <p class="text-sm text-slate-500 mt-1">Coba atur ulang kata kunci pencarian atau filter kategori Anda.</p>
            <a href="{{ route('landing') }}" class="inline-block mt-4 text-xs font-semibold text-amber-600 hover:underline">Reset Pencarian</a>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($beasiswas as $b)
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm hover:shadow-md transition flex flex-col justify-between overflow-hidden group">
                    <!-- Image / Header Placeholder -->
                    <div class="h-32 bg-gradient-to-tr from-slate-100 to-slate-200 relative flex items-center justify-center border-b border-slate-100">
                        <div class="w-12 h-12 rounded-2xl bg-white shadow-sm flex items-center justify-center text-amber-600 font-bold text-xl">
                            <i class="fa-solid fa-award"></i>
                        </div>
                        <span class="absolute top-3 right-3 text-xs font-bold px-2.5 py-0.5 rounded-full bg-emerald-100 text-emerald-700 border border-emerald-200">
                            Dibuka
                        </span>
                        <span class="absolute bottom-3 left-3 text-xs font-medium px-2 py-0.5 rounded-md bg-white/80 backdrop-blur text-slate-700">
                            {{ $b->kategori }}
                        </span>
                    </div>

                    <!-- Content -->
                    <div class="p-5 flex-1 flex flex-col justify-between">
                        <div>
                            <h3 class="font-bold text-lg text-slate-900 group-hover:text-amber-600 transition mb-1 leading-snug">
                                {{ $b->nama_program }}
                            </h3>
                            <p class="text-xs text-slate-500 mb-3 flex items-center space-x-1">
                                <i class="fa-solid fa-building-columns text-slate-400"></i>
                                <span>{{ $b->penyelenggara }}</span>
                            </p>
                            <p class="text-sm text-slate-600 line-clamp-2 mb-4">
                                {{ $b->deskripsi }}
                            </p>
                        </div>

                        <!-- Meta Info -->
                        <div class="border-t border-slate-100 pt-3 space-y-1.5 text-xs text-slate-600 mb-4">
                            <div class="flex items-center justify-between">
                                <span class="flex items-center text-slate-500">
                                    <i class="fa-regular fa-calendar text-slate-400 mr-1.5"></i> Tenggat:
                                </span>
                                <span class="font-semibold text-slate-800">{{ $b->tgl_tutup->format('d M Y') }}</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="flex items-center text-slate-500">
                                    <i class="fa-solid fa-users text-slate-400 mr-1.5"></i> Kuota:
                                </span>
                                <span class="font-semibold text-slate-800">{{ $b->kuota }} Mahasiswa</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="flex items-center text-slate-500">
                                    <i class="fa-solid fa-chart-line text-slate-400 mr-1.5"></i> Min. IPK:
                                </span>
                                <span class="font-semibold text-slate-800">{{ number_format($b->ipk_minimal, 2) }}</span>
                            </div>
                        </div>

                        <!-- Action -->
                        <a href="{{ route('beasiswa.detail', $b->id) }}" class="w-full text-center py-2.5 bg-slate-900 hover:bg-amber-600 text-white text-sm font-semibold rounded-xl transition shadow-sm">
                            Lihat Detail & Persyaratan
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
