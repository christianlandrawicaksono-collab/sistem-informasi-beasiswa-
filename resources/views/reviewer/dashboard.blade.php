@extends('layouts.app')

@section('title', 'Sistem Pendukung Keputusan - Perangkingan SAW')

@section('content')
<div class="mb-8 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
    <div>
        <div class="inline-flex items-center space-x-1.5 px-3 py-1 rounded-full bg-purple-100 text-purple-700 text-xs font-bold mb-2">
            <i class="fa-solid fa-calculator"></i>
            <span>Decision Support System (SPK)</span>
        </div>
        <h1 class="text-2xl font-extrabold text-slate-900">Perangkingan Metode Simple Additive Weighting (SAW)</h1>
        <p class="text-xs text-slate-500">Normalisasi matriks keputusan dan perhitungan preferensi kandidat penerima beasiswa secara objektif.</p>
    </div>

    @if($beasiswaDipilih)
        <form action="{{ route('reviewer.hitung.saw', $beasiswaDipilih->id) }}" method="POST">
            @csrf
            <button type="submit" class="px-5 py-2.5 bg-purple-600 hover:bg-purple-700 text-white text-xs font-bold rounded-xl transition shadow-md shadow-purple-200 flex items-center space-x-2">
                <i class="fa-solid fa-arrows-rotate"></i>
                <span>Hitung Ulang Skor SAW</span>
            </button>
        </form>
    @endif
</div>

<!-- Panel Bobot Kriteria SAW (Sesuai Wireframe 3) -->
@if($beasiswaDipilih && $beasiswaDipilih->kriteria->isNotEmpty())
<div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm mb-8">
    <div class="flex justify-between items-center mb-4 pb-3 border-b border-slate-100">
        <div>
            <h3 class="text-sm font-bold text-slate-900">Bobot Kriteria Penilaian: {{ $beasiswaDipilih->nama_program }}</h3>
            <p class="text-xs text-slate-400">Total pembobotan harus bernilai 100%</p>
        </div>
        <span class="text-xs font-bold px-3 py-1 bg-purple-50 text-purple-700 rounded-full border border-purple-200">
            Kuota: {{ $beasiswaDipilih->kuota }} Mahasiswa
        </span>
    </div>

    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
        @foreach($beasiswaDipilih->kriteria as $crit)
            <div class="bg-slate-50 p-4 rounded-2xl border border-slate-200/60">
                <div class="flex justify-between items-start mb-2">
                    <span class="text-xs font-bold text-slate-500 font-mono">{{ $crit->kode_kriteria }}</span>
                    <span class="text-[10px] font-bold px-2 py-0.5 rounded uppercase {{ $crit->sifat === 'benefit' ? 'bg-emerald-100 text-emerald-700' : 'bg-amber-100 text-amber-700' }}">
                        {{ $crit->sifat }}
                    </span>
                </div>
                <h4 class="text-xs font-bold text-slate-800 mb-1">{{ $crit->nama_kriteria }}</h4>
                <p class="text-xl font-black text-purple-700">{{ $crit->bobot }}%</p>
            </div>
        @endforeach
    </div>
</div>
@endif

<!-- Tabel Pelamar & Hasil Perangkingan SAW (Sesuai Wireframe 3) -->
<div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden mb-8">
    <div class="p-6 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-base font-bold text-slate-900">Data Pelamar & Hasil Perangkingan SAW</h2>
            <p class="text-xs text-slate-500">Urutan rekomendasi penerima beasiswa berdasarkan nilai total preferensi tertinggi ($V_i$)</p>
        </div>
        <div class="flex items-center space-x-2">
            <button onclick="window.print()" class="px-3.5 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold rounded-xl transition flex items-center space-x-1">
                <i class="fa-solid fa-print"></i>
                <span>Cetak / Ekspor PDF</span>
            </button>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm text-slate-600">
            <thead class="bg-slate-50 text-[11px] font-bold text-slate-400 uppercase tracking-wider">
                <tr>
                    <th class="px-6 py-3.5 text-center">Rank</th>
                    <th class="px-6 py-3.5">Nama Mahasiswa</th>
                    <th class="px-6 py-3.5">Status Berkas</th>
                    <th class="px-6 py-3.5 text-center">C1 (IPK)</th>
                    <th class="px-6 py-3.5 text-center">C2 (Gaji Ortu)</th>
                    <th class="px-6 py-3.5 text-center">C3 (Tanggungan)</th>
                    <th class="px-6 py-3.5 text-center">C4 (Prestasi)</th>
                    <th class="px-6 py-3.5 text-right">Skor Akhir SAW ($V_i$)</th>
                    <th class="px-6 py-3.5 text-center">Status Kelulusan</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 font-medium">
                @forelse($ranking as $idx => $r)
                    @php
                        $isWinner = ($idx + 1) <= ($beasiswaDipilih->kuota ?? 0);
                    @endphp
                    <tr class="hover:bg-purple-50/30 transition {{ $isWinner ? 'bg-emerald-50/20' : '' }}">
                        <td class="px-6 py-4 text-center">
                            @if($idx === 0)
                                <span class="w-7 h-7 rounded-full bg-amber-400 text-slate-900 font-black text-xs inline-flex items-center justify-center shadow-sm">1</span>
                            @elseif($idx === 1)
                                <span class="w-7 h-7 rounded-full bg-slate-300 text-slate-900 font-black text-xs inline-flex items-center justify-center shadow-sm">2</span>
                            @elseif($idx === 2)
                                <span class="w-7 h-7 rounded-full bg-amber-700 text-white font-black text-xs inline-flex items-center justify-center shadow-sm">3</span>
                            @else
                                <span class="font-bold text-slate-500">{{ $idx + 1 }}</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <span class="font-bold text-slate-900 block">{{ $r->profil->nama_lengkap }}</span>
                            <span class="text-xs text-slate-400">NIM: {{ $r->profil->nim }} • {{ $r->profil->prodi }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-xs font-semibold px-2.5 py-0.5 rounded-full bg-emerald-100 text-emerald-700">
                                Terverifikasi
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center text-xs font-semibold">
                            {{ number_format($r->profil->ipk, 2) }}
                        </td>
                        <td class="px-6 py-4 text-center text-xs text-slate-500">
                            Rp {{ number_format($r->profil->penghasilan_ortu, 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-4 text-center text-xs">
                            {{ $r->profil->jumlah_tanggungan }} Orang
                        </td>
                        <td class="px-6 py-4 text-center text-xs">
                            {{ $r->profil->skor_prestasi }}
                        </td>
                        <td class="px-6 py-4 text-right font-mono font-black text-purple-700 text-base">
                            {{ number_format($r->total_skor_saw, 4) }}
                        </td>
                        <td class="px-6 py-4 text-center">
                            @if($r->status_tahap === 'diterima')
                                <span class="text-xs font-bold px-3 py-1 rounded-full bg-emerald-100 text-emerald-800">
                                    <i class="fa-solid fa-check mr-1"></i> Diterima
                                </span>
                            @elseif($r->status_tahap === 'ditolak')
                                <span class="text-xs font-bold px-3 py-1 rounded-full bg-rose-100 text-rose-800">
                                    Ditolak
                                </span>
                            @else
                                <span class="text-xs font-semibold px-2.5 py-1 rounded-full {{ $isWinner ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-slate-100 text-slate-600' }}">
                                    {{ $isWinner ? 'Rekomendasi Lolos' : 'Di Bawah Kuota' }}
                                </span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="px-6 py-12 text-center text-xs text-slate-400">
                            Belum ada perangkingan SAW yang dihitung untuk beasiswa ini.<br>
                            Klik tombol <strong>"Hitung Ulang Skor SAW"</strong> di atas untuk menjalankan kalkulasi.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
