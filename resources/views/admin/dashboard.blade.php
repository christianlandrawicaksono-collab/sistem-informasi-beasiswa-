@extends('layouts.app')

@section('title', 'Dashboard Admin & Tim Penyeleksi')

@section('content')
<div class="mb-8 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
    <div>
        <h1 class="text-2xl font-extrabold text-slate-900">Dashboard Admin & Kemahasiswaan</h1>
        <p class="text-xs text-slate-500">Kelola informasi program beasiswa, verifikasi kelengkapan berkas, dan pantau statistik pelamar.</p>
    </div>
    <div class="flex items-center space-x-3">
        <a href="{{ route('admin.beasiswa.create') }}" class="px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white text-xs font-bold rounded-xl transition shadow-sm shadow-amber-200 flex items-center space-x-1.5">
            <i class="fa-solid fa-plus"></i>
            <span>Tambah Beasiswa</span>
        </a>
        <a href="{{ route('reviewer.dashboard') }}" class="px-4 py-2 bg-slate-900 hover:bg-slate-800 text-white text-xs font-bold rounded-xl transition shadow-sm flex items-center space-x-1.5">
            <i class="fa-solid fa-ranking-star text-amber-400"></i>
            <span>Panel Seleksi SAW</span>
        </a>
    </div>
</div>

<!-- 4 Kartu Statistik (Sesuai Wireframe 3) -->
<div class="grid grid-cols-2 md:grid-cols-4 gap-4 sm:gap-6 mb-8">
    <div class="bg-white p-5 rounded-3xl border border-slate-200 shadow-sm">
        <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block mb-1">Total Pelamar</span>
        <h3 class="text-3xl font-black text-slate-900">{{ $totalPelamar }}</h3>
        <span class="text-[11px] text-emerald-600 font-medium mt-1 inline-flex items-center">
            <i class="fa-solid fa-arrow-up text-[9px] mr-1"></i> Data Real-Time
        </span>
    </div>

    <div class="bg-white p-5 rounded-3xl border border-amber-200 bg-amber-50/20 shadow-sm">
        <span class="text-xs font-bold text-amber-700 uppercase tracking-wider block mb-1">Perlu Verifikasi</span>
        <h3 class="text-3xl font-black text-amber-600">{{ $perluVerifikasi }}</h3>
        <span class="text-[11px] text-amber-700 font-medium mt-1 block">Berkas menunggu</span>
    </div>

    <div class="bg-white p-5 rounded-3xl border border-slate-200 shadow-sm">
        <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block mb-1">Terverifikasi</span>
        <h3 class="text-3xl font-black text-emerald-600">{{ $terverifikasi }}</h3>
        <span class="text-[11px] text-slate-400 font-medium mt-1 block">Siap seleksi SAW</span>
    </div>

    <div class="bg-white p-5 rounded-3xl border border-slate-200 shadow-sm">
        <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block mb-1">Total Kuota</span>
        <h3 class="text-3xl font-black text-slate-900">{{ $totalKuota }}</h3>
        <span class="text-[11px] text-slate-400 font-medium mt-1 block">Kapasitas penerima</span>
    </div>
</div>

<!-- Tabel Pelamar & Status Verifikasi (Sesuai Wireframe 3) -->
<div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden mb-8">
    <div class="p-6 border-b border-slate-100 flex justify-between items-center">
        <div>
            <h2 class="text-base font-bold text-slate-900">Data Pelamar Beasiswa</h2>
            <p class="text-xs text-slate-500">Periksa dan validasi dokumen administratif mahasiswa</p>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm text-slate-600">
            <thead class="bg-slate-50 text-[11px] font-bold text-slate-400 uppercase tracking-wider">
                <tr>
                    <th class="px-6 py-3.5">No. Daftar</th>
                    <th class="px-6 py-3.5">Nama Mahasiswa</th>
                    <th class="px-6 py-3.5">Program Beasiswa</th>
                    <th class="px-6 py-3.5">Tahap Pengajuan</th>
                    <th class="px-6 py-3.5">Skor SAW</th>
                    <th class="px-6 py-3.5 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($pelamars as $p)
                    <tr class="hover:bg-slate-50/50">
                        <td class="px-6 py-4 font-mono text-xs font-bold text-slate-700">
                            {{ $p->nomor_pendaftaran }}
                        </td>
                        <td class="px-6 py-4">
                            <span class="font-bold text-slate-900 block">{{ $p->profil->nama_lengkap }}</span>
                            <span class="text-xs text-slate-400">NIM: {{ $p->profil->nim }} • IPK: {{ number_format($p->profil->ipk, 2) }}</span>
                        </td>
                        <td class="px-6 py-4 font-medium text-slate-800">
                            {{ $p->beasiswa->nama_program }}
                        </td>
                        <td class="px-6 py-4">
                            @php
                                $stBadge = [
                                    'draft' => 'bg-slate-100 text-slate-700',
                                    'submitted' => 'bg-blue-100 text-blue-700',
                                    'verifikasi_berkas' => 'bg-amber-100 text-amber-700',
                                    'seleksi_saw' => 'bg-purple-100 text-purple-700',
                                    'diterima' => 'bg-emerald-100 text-emerald-700',
                                    'ditolak' => 'bg-rose-100 text-rose-700',
                                ];
                                $bClass = $stBadge[$p->status_tahap] ?? 'bg-slate-100 text-slate-700';
                            @endphp
                            <span class="text-xs font-bold px-2.5 py-1 rounded-full uppercase {{ $bClass }}">
                                {{ str_replace('_', ' ', $p->status_tahap) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 font-mono font-bold text-slate-900">
                            {{ $p->total_skor_saw ? number_format($p->total_skor_saw, 4) : '-' }}
                        </td>
                        <td class="px-6 py-4 text-right space-x-2">
                            <a href="{{ route('admin.verifikasi', $p->id) }}" class="px-3 py-1.5 bg-slate-900 hover:bg-amber-600 text-white text-xs font-bold rounded-lg transition">
                                Verifikasi Berkas
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-8 text-center text-xs text-slate-400">
                            Belum ada pendaftaran beasiswa yang masuk.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($pelamars->hasPages())
        <div class="p-4 border-t border-slate-100">
            {{ $pelamars->links() }}
        </div>
    @endif
</div>
@endsection
