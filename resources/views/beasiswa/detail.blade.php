@extends('layouts.app')

@section('title', $beasiswa->nama_program)

@section('content')
<div class="max-w-4xl mx-auto my-6">
    <div class="mb-6">
        <a href="{{ route('landing') }}" class="text-xs font-bold text-amber-600 hover:underline flex items-center space-x-1 mb-2">
            <i class="fa-solid fa-arrow-left"></i>
            <span>Kembali ke Katalog Beasiswa</span>
        </a>
        <div class="flex items-center space-x-2 mb-1">
            <span class="text-xs font-bold px-2.5 py-0.5 rounded-full bg-emerald-100 text-emerald-700">Dibuka</span>
            <span class="text-xs font-medium text-slate-400">• {{ $beasiswa->kategori }}</span>
        </div>
        <h1 class="text-3xl font-extrabold text-slate-900">{{ $beasiswa->nama_program }}</h1>
        <p class="text-sm text-slate-500 mt-1">Diselenggarakan oleh: <strong class="text-slate-700">{{ $beasiswa->penyelenggara }}</strong></p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <!-- Main Details -->
        <div class="md:col-span-2 space-y-6">
            <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm">
                <h3 class="text-base font-bold text-slate-900 mb-3">Deskripsi Program</h3>
                <p class="text-sm text-slate-600 leading-relaxed">{{ $beasiswa->deskripsi }}</p>
            </div>

            <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm">
                <h3 class="text-base font-bold text-slate-900 mb-3">Persyaratan & Berkas Administrasi</h3>
                <div class="text-sm text-slate-600 whitespace-pre-line leading-relaxed">{{ $beasiswa->persyaratan }}</div>
            </div>

            <!-- Kriteria Bobot SAW -->
            @if($beasiswa->kriteria->isNotEmpty())
                <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm">
                    <h3 class="text-base font-bold text-slate-900 mb-3">Kriteria Penilaian Seleksi (SAW)</h3>
                    <div class="grid grid-cols-2 gap-3">
                        @foreach($beasiswa->kriteria as $c)
                            <div class="p-3 bg-slate-50 rounded-xl border border-slate-200 flex justify-between items-center text-xs">
                                <div>
                                    <span class="font-bold text-slate-800 block">{{ $c->nama_kriteria }}</span>
                                    <span class="text-[10px] text-slate-400 uppercase">Sifat: {{ $c->sifat }}</span>
                                </div>
                                <span class="font-bold text-purple-700 bg-purple-50 px-2.5 py-1 rounded-lg">{{ $c->bobot }}%</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        <!-- Sidebar Action -->
        <div class="space-y-6">
            <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm">
                <h3 class="text-sm font-bold text-slate-900 mb-4 pb-2 border-b border-slate-100">Informasi Pendaftaran</h3>
                <div class="space-y-3 text-xs mb-6">
                    <div class="flex justify-between">
                        <span class="text-slate-400">Batas Waktu:</span>
                        <span class="font-bold text-slate-800">{{ $beasiswa->tgl_tutup->format('d M Y') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-400">Alokasi Kuota:</span>
                        <span class="font-bold text-slate-800">{{ $beasiswa->kuota }} Mahasiswa</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-400">Minimal IPK:</span>
                        <span class="font-bold text-slate-800">{{ number_format($beasiswa->ipk_minimal, 2) }}</span>
                    </div>
                </div>

                @auth
                    @if(auth()->user()->isMahasiswa())
                        <form action="{{ route('mahasiswa.ajukan', $beasiswa->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full py-3 bg-amber-500 hover:bg-amber-600 text-white font-bold rounded-xl text-sm transition shadow-md shadow-amber-200">
                                Ajukan Beasiswa Ini
                            </button>
                        </form>
                    @else
                        <div class="p-3 bg-slate-100 rounded-xl text-xs text-slate-500 text-center">
                            Anda login sebagai {{ strtoupper(auth()->user()->role) }}. Pendaftaran hanya untuk akun mahasiswa.
                        </div>
                    @endif
                @else
                    <a href="{{ route('login') }}" class="block text-center w-full py-3 bg-amber-500 hover:bg-amber-600 text-white font-bold rounded-xl text-sm transition shadow-md shadow-amber-200">
                        Masuk untuk Mendaftar
                    </a>
                @endauth
            </div>
        </div>
    </div>
</div>
@endsection
