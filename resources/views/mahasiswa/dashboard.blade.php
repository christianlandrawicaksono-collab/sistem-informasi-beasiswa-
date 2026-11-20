@extends('layouts.app')

@section('title', 'Dashboard Mahasiswa')

@section('content')
<!-- Header User Profile & Info -->
<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8 bg-white p-6 rounded-3xl border border-slate-200 shadow-sm">
    <div class="flex items-center space-x-4">
        <div class="w-14 h-14 rounded-2xl bg-amber-500 text-white flex items-center justify-center font-bold text-2xl shadow-md shadow-amber-200">
            {{ substr($user->name, 0, 1) }}
        </div>
        <div>
            <h1 class="text-2xl font-extrabold text-slate-900">{{ $profil->nama_lengkap }}</h1>
            <p class="text-xs text-slate-500">
                NIM: <span class="font-semibold text-slate-700">{{ $profil->nim }}</span> • 
                {{ $profil->prodi }} ({{ $profil->fakultas }}) • Semester {{ $profil->semester }}
            </p>
        </div>
    </div>
    <div class="flex items-center space-x-2">
        <a href="{{ route('mahasiswa.profil') }}" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold rounded-xl transition flex items-center space-x-1.5">
            <i class="fa-solid fa-user-pen"></i>
            <span>Edit Profil & Data Akademik</span>
        </a>
    </div>
</div>

<!-- 3 Ringkasan Status (Sesuai Wireframe 2) -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <!-- Card 1: Status Aktif -->
    <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm flex flex-col justify-between">
        <div>
            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block mb-1">Status Pengajuan</span>
            @if($pengajuanAktif)
                @php
                    $statusLabels = [
                        'draft' => ['label' => 'Draft Pengajuan', 'color' => 'text-slate-700', 'step' => 'Tahap 1 dari 5'],
                        'submitted' => ['label' => 'Terkirim (Submitted)', 'color' => 'text-blue-600', 'step' => 'Tahap 2 dari 5'],
                        'verifikasi_berkas' => ['label' => 'Verifikasi Berkas', 'color' => 'text-amber-600', 'step' => 'Tahap 3 dari 5'],
                        'seleksi_saw' => ['label' => 'Seleksi SAW', 'color' => 'text-purple-600', 'step' => 'Tahap 4 dari 5'],
                        'diterima' => ['label' => 'Lolos Beasiswa (Diterima)', 'color' => 'text-emerald-600', 'step' => 'Tahap 5 dari 5'],
                        'ditolak' => ['label' => 'Tidak Lolos', 'color' => 'text-rose-600', 'step' => 'Tahap Selesai'],
                    ];
                    $st = $statusLabels[$pengajuanAktif->status_tahap] ?? ['label' => 'Proses', 'color' => 'text-slate-700', 'step' => '-'];
                @endphp
                <h3 class="text-2xl font-black {{ $st['color'] }}">{{ $st['label'] }}</h3>
                <p class="text-xs text-slate-400 mt-1">{{ $st['step'] }}</p>
                <p class="text-xs font-medium text-slate-600 mt-2 truncate">{{ $pengajuanAktif->beasiswa->nama_program }}</p>
            @else
                <h3 class="text-xl font-bold text-slate-400">Belum Ada Pengajuan</h3>
                <p class="text-xs text-slate-400 mt-1">Pilih beasiswa yang tersedia untuk memulai.</p>
            @endif
        </div>
        @if($pengajuanAktif)
            <div class="mt-4 pt-3 border-t border-slate-100 flex justify-between items-center text-xs">
                <span class="text-slate-400">No. Daftar:</span>
                <span class="font-mono font-bold text-slate-700">{{ $pengajuanAktif->nomor_pendaftaran }}</span>
            </div>
        @endif
    </div>

    <!-- Card 2: Berkas Terunggah (Sesuai Wireframe 2) -->
    <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm flex flex-col justify-between">
        <div>
            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block mb-1">Berkas Terunggah</span>
            @if($pengajuanAktif)
                @php
                    $totalBerkas = $pengajuanAktif->berkas->count();
                    $targetBerkas = 4; // KTM, KK, Slip, Transkrip
                    $percent = min(100, round(($totalBerkas / $targetBerkas) * 100));
                @endphp
                <h3 class="text-2xl font-black text-slate-900">{{ $totalBerkas }} / {{ $targetBerkas }}</h3>
                <div class="w-full bg-slate-100 rounded-full h-2 mt-3 overflow-hidden">
                    <div class="bg-amber-500 h-2 rounded-full" style="width: {{ $percent }}%"></div>
                </div>
                <p class="text-xs text-slate-500 mt-2">
                    {{ $totalBerkas >= $targetBerkas ? 'Seluruh berkas utama sudah diunggah' : ($targetBerkas - $totalBerkas) . ' berkas wajib belum diunggah' }}
                </p>
            @else
                <h3 class="text-2xl font-black text-slate-900">-</h3>
                <p class="text-xs text-slate-400 mt-1">Daftar program beasiswa terlebih dahulu.</p>
            @endif
        </div>
        @if($pengajuanAktif)
            <div class="mt-4 pt-3 border-t border-slate-100">
                <a href="{{ route('mahasiswa.berkas', $pengajuanAktif->id) }}" class="text-xs font-bold text-amber-600 hover:text-amber-700 flex items-center space-x-1">
                    <span>Kelola Berkas Persyaratan</span>
                    <i class="fa-solid fa-arrow-right text-[10px]"></i>
                </a>
            </div>
        @endif
    </div>

    <!-- Card 3: Rekomendasi Beasiswa (Sesuai Wireframe 2) -->
    <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm flex flex-col justify-between">
        <div>
            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block mb-1">Rekomendasi</span>
            <h3 class="text-2xl font-black text-slate-900">{{ $rekomendasi->count() }} Beasiswa</h3>
            <p class="text-xs text-slate-500 mt-1">Berdasarkan profil akademik (IPK: {{ number_format($profil->ipk, 2) }})</p>
        </div>
        <div class="mt-4 pt-3 border-t border-slate-100">
            <a href="{{ route('landing') }}#daftar-beasiswa" class="text-xs font-bold text-amber-600 hover:text-amber-700 flex items-center space-x-1">
                <span>Lihat Semua Beasiswa</span>
                <i class="fa-solid fa-arrow-right text-[10px]"></i>
            </a>
        </div>
    </div>
</div>

<!-- Alur Pengajuan / Visual Stepper (Sesuai Wireframe 2) -->
@if($pengajuanAktif)
<div class="bg-white p-6 sm:p-8 rounded-3xl border border-slate-200 shadow-sm mb-8">
    <h2 class="text-base font-bold text-slate-900 mb-6 flex items-center space-x-2">
        <i class="fa-solid fa-route text-amber-500"></i>
        <span>Alur Pengajuan Beasiswa</span>
    </h2>

    @php
        $steps = [
            'draft' => ['title' => 'Draft', 'desc' => 'Isi data & berkas'],
            'submitted' => ['title' => 'Submitted', 'desc' => 'Terkirim ke panitia'],
            'verifikasi_berkas' => ['title' => 'Verifikasi Berkas', 'desc' => 'Pemeriksaan dokumen'],
            'seleksi_saw' => ['title' => 'Seleksi SAW', 'desc' => 'Perangkingan SPK'],
            'pengumuman' => ['title' => 'Pengumuman', 'desc' => 'Hasil kelulusan'],
        ];
        $order = ['draft', 'submitted', 'verifikasi_berkas', 'seleksi_saw', 'pengumuman'];
        $currentIdx = array_search($pengajuanAktif->status_tahap, $order);
        if ($pengajuanAktif->status_tahap === 'diterima' || $pengajuanAktif->status_tahap === 'ditolak') {
            $currentIdx = 4;
        }
    @endphp

    <div class="grid grid-cols-2 sm:grid-cols-5 gap-4 relative">
        @foreach($order as $idx => $sKey)
            @php
                $isCompleted = $idx < $currentIdx;
                $isCurrent = $idx === $currentIdx;
            @endphp
            <div class="flex flex-col items-center text-center">
                <div class="w-10 h-10 rounded-full flex items-center justify-center font-bold text-sm mb-2 transition {{ $isCompleted ? 'bg-emerald-500 text-white shadow-md shadow-emerald-200' : ($isCurrent ? 'bg-amber-500 text-white ring-4 ring-amber-100 shadow-md shadow-amber-200' : 'bg-slate-100 text-slate-400') }}">
                    @if($isCompleted)
                        <i class="fa-solid fa-check"></i>
                    @else
                        {{ $idx + 1 }}
                    @endif
                </div>
                <h4 class="text-xs font-bold {{ $isCurrent ? 'text-amber-600' : ($isCompleted ? 'text-slate-800' : 'text-slate-400') }}">
                    {{ $steps[$sKey]['title'] }}
                </h4>
                <p class="text-[10px] text-slate-400 mt-0.5">{{ $steps[$sKey]['desc'] }}</p>
            </div>
        @endforeach
    </div>
</div>
@endif

<!-- Tabel Berkas & Riwayat Pengajuan (Sesuai Wireframe 2) -->
<div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden mb-8">
    <div class="p-6 border-b border-slate-100 flex justify-between items-center">
        <div>
            <h2 class="text-base font-bold text-slate-900">Kelengkapan Berkas Persyaratan</h2>
            <p class="text-xs text-slate-500">Unggah berkas sesuai format .pdf / .jpg maksimal 3MB</p>
        </div>
        @if($pengajuanAktif)
            <a href="{{ route('mahasiswa.berkas', $pengajuanAktif->id) }}" class="px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white text-xs font-bold rounded-xl transition shadow-sm">
                Kelola & Unggah Berkas
            </a>
        @endif
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm text-slate-600">
            <thead class="bg-slate-50 text-[11px] font-bold text-slate-400 uppercase tracking-wider">
                <tr>
                    <th class="px-6 py-3.5">Nama Dokumen</th>
                    <th class="px-6 py-3.5">Wajib</th>
                    <th class="px-6 py-3.5">Status Validasi</th>
                    <th class="px-6 py-3.5 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @if($pengajuanAktif && $pengajuanAktif->berkas->isNotEmpty())
                    @foreach($pengajuanAktif->berkas as $doc)
                        <tr class="hover:bg-slate-50/50">
                            <td class="px-6 py-4 font-semibold text-slate-900 flex items-center space-x-2">
                                <i class="fa-regular fa-file-pdf text-rose-500 text-base"></i>
                                <span>{{ $doc->nama_dokumen }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-xs font-semibold px-2 py-0.5 rounded {{ $doc->wajib ? 'bg-amber-50 text-amber-700' : 'bg-slate-100 text-slate-600' }}">
                                    {{ $doc->wajib ? 'Ya' : 'Opsional' }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                @php
                                    $bBadges = [
                                        'pending' => ['label' => 'Menunggu Verifikasi', 'class' => 'bg-slate-100 text-slate-600'],
                                        'valid' => ['label' => 'Valid', 'class' => 'bg-emerald-100 text-emerald-700'],
                                        'perlu_revisi' => ['label' => 'Perlu Revisi', 'class' => 'bg-amber-100 text-amber-700'],
                                        'ditolak' => ['label' => 'Ditolak', 'class' => 'bg-rose-100 text-rose-700'],
                                    ];
                                    $bSt = $bBadges[$doc->status_verifikasi] ?? ['label' => '-', 'class' => ''];
                                @endphp
                                <span class="text-xs font-semibold px-2.5 py-1 rounded-full {{ $bSt['class'] }}">
                                    {{ $bSt['label'] }}
                                </span>
                                @if($doc->catatan_verifikasi)
                                    <p class="text-[11px] text-amber-700 mt-1">Catatan: {{ $doc->catatan_verifikasi }}</p>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right">
                                <a href="{{ asset('storage/' . $doc->file_path) }}" target="_blank" class="text-xs font-bold text-amber-600 hover:text-amber-800">
                                    Lihat Berkas <i class="fa-solid fa-arrow-up-right-from-square text-[10px] ml-1"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="4" class="px-6 py-8 text-center text-xs text-slate-400">
                            Belum ada dokumen yang diunggah untuk pengajuan ini.
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>
@endsection
