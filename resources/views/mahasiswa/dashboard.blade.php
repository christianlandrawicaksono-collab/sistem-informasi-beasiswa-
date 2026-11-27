@extends('layouts.app')

@section('title', 'Portal Mahasiswa')

@section('content')
<!-- Header User Profile Banner -->
<div data-motion="hero-item" class="nomu-panel p-6 sm:p-7 mb-8 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
    <div class="flex items-center gap-4">
        <div class="size-14 rounded-full bg-linear-to-tr from-[#F13F07] to-[#FF7448] text-white flex items-center justify-center font-extrabold text-xl shadow-md shrink-0">
            {{ substr($user->name, 0, 1) }}
        </div>
        <div>
            <span class="nomu-label text-[#FF7448] block">Student Portal</span>
            <h1 class="text-xl sm:text-2xl font-extrabold text-[#0F151D]">{{ $profil->nama_lengkap }}</h1>
            <p class="text-xs text-[#5B6573] mt-0.5">
                NIM: <span class="font-mono font-semibold text-[#0F151D]">{{ $profil->nim }}</span> · {{ $profil->prodi }} ({{ $profil->fakultas }}) · Semester {{ $profil->semester }}
            </p>
        </div>
    </div>

    <a href="{{ route('mahasiswa.profil') }}" data-motion="pill-press" class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-full bg-[#F1EBE9] hover:bg-[#E4EDFF] text-[#0F151D] text-xs font-bold transition shrink-0">
        <svg class="size-3.5" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/></svg>
        <span>Edit Profil &amp; IPK</span>
    </a>
</div>

<!-- 3 Bento Summary Cards -->
<div data-motion="stagger-grid" class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-8">
    <!-- Card 1: Status Pengajuan -->
    <div data-motion-card class="nomu-card p-6 flex flex-col justify-between">
        <div>
            <span class="nomu-label text-[#5B6573] block mb-2">Status Pengajuan</span>
            @if($pengajuanAktif)
                @php
                    $statusLabels = [
                        'draft' => ['label' => 'Draft Pengajuan', 'color' => 'text-[#0F151D]', 'step' => 'Tahap 01 dari 05'],
                        'submitted' => ['label' => 'Terkirim (Submitted)', 'color' => 'text-[#243C61]', 'step' => 'Tahap 02 dari 05'],
                        'verifikasi_berkas' => ['label' => 'Verifikasi Berkas', 'color' => 'text-[#FF7448]', 'step' => 'Tahap 03 dari 05'],
                        'seleksi_saw' => ['label' => 'Seleksi SAW', 'color' => 'text-[#526991]', 'step' => 'Tahap 04 dari 05'],
                        'diterima' => ['label' => 'Lolos Beasiswa', 'color' => 'text-[#237C65]', 'step' => 'Tahap 05 dari 05'],
                        'ditolak' => ['label' => 'Tidak Lolos', 'color' => 'text-[#B83209]', 'step' => 'Seleksi Selesai'],
                    ];
                    $st = $statusLabels[$pengajuanAktif->status_tahap] ?? ['label' => 'Proses', 'color' => 'text-[#0F151D]', 'step' => '-'];
                @endphp
                <h2 class="text-xl font-extrabold {{ $st['color'] }}">{{ $st['label'] }}</h2>
                <p class="text-xs font-mono text-[#5B6573] mt-1">{{ $st['step'] }}</p>
                <p class="text-xs font-semibold text-[#0F151D] mt-2 truncate">{{ $pengajuanAktif->beasiswa->nama_program }}</p>
            @else
                <h2 class="text-lg font-bold text-[#5B6573]">Belum Ada Pengajuan</h2>
                <p class="text-xs text-[#5B6573] mt-1">Pilih program beasiswa di katalog untuk memulai.</p>
            @endif
        </div>
        @if($pengajuanAktif)
            <div class="mt-4 pt-3 border-t border-[#0F151D]/8 flex justify-between items-center text-xs">
                <span class="text-[#5B6573]">No. Pendaftaran</span>
                <span class="font-mono font-bold text-[#0F151D]">{{ $pengajuanAktif->nomor_pendaftaran }}</span>
            </div>
        @endif
    </div>

    <!-- Card 2: Berkas Terunggah -->
    <div data-motion-card class="nomu-card p-6 flex flex-col justify-between">
        <div>
            <span class="nomu-label text-[#5B6573] block mb-2">Berkas Terunggah</span>
            @if($pengajuanAktif)
                @php
                    $totalBerkas = $pengajuanAktif->berkas->count();
                    $targetBerkas = 4;
                    $percent = min(100, round(($totalBerkas / $targetBerkas) * 100));
                @endphp
                <h2 class="text-2xl font-extrabold text-[#0F151D] tabular-nums">{{ $totalBerkas }} <span class="text-sm font-medium text-[#5B6573]">/ {{ $targetBerkas }} wajib</span></h2>
                <div class="w-full bg-[#F1EBE9] rounded-full h-2.5 mt-3 overflow-hidden">
                    <div data-motion="progress-fill" data-width="{{ $percent }}%" class="bg-linear-to-r from-[#F13F07] to-[#FF7448] h-2.5 rounded-full" style="width: {{ $percent }}%"></div>
                </div>
                <p class="text-xs text-[#5B6573] mt-2">
                    {{ $totalBerkas >= $targetBerkas ? 'Semua berkas utama sudah diunggah.' : ($targetBerkas - $totalBerkas) . ' berkas wajib belum diunggah.' }}
                </p>
            @else
                <h2 class="text-2xl font-extrabold text-[#5B6573]">—</h2>
                <p class="text-xs text-[#5B6573] mt-1">Ajukan beasiswa untuk mengunggah berkas.</p>
            @endif
        </div>
        @if($pengajuanAktif)
            <div class="mt-4 pt-3 border-t border-[#0F151D]/8">
                <a href="{{ route('mahasiswa.berkas', $pengajuanAktif->id) }}" class="text-xs font-bold text-[#FF7448] hover:underline inline-flex items-center gap-1">
                    <span>Kelola Berkas Persyaratan</span>
                    <svg class="size-3" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                </a>
            </div>
        @endif
    </div>

    <!-- Card 3: Rekomendasi Beasiswa (Periwinkle Highlight) -->
    <div data-motion-card class="rounded-[24px] p-6 bg-[#E4EDFF] border border-[#526991]/15 flex flex-col justify-between shadow-xs">
        <div>
            <span class="nomu-label text-[#526991] block mb-2">Rekomendasi Profil</span>
            <h2 class="text-2xl font-extrabold text-[#0F151D] tabular-nums">{{ $rekomendasi->count() }} Beasiswa</h2>
            <p class="text-xs text-[#243C61] mt-1">Cocok dengan IPK Anda saat ini (<span class="font-mono font-bold">{{ number_format($profil->ipk, 2) }}</span>)</p>
        </div>
        <div class="mt-4 pt-3 border-t border-[#526991]/15">
            <a href="{{ route('landing') }}#daftar-beasiswa" class="text-xs font-bold text-[#243C61] hover:underline inline-flex items-center gap-1">
                <span>Jelajahi Katalog Beasiswa</span>
                <svg class="size-3" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
            </a>
        </div>
    </div>
</div>

<!-- Nomu-Style Numbered Stepper Alur Pengajuan -->
@if($pengajuanAktif)
<div data-motion="reveal" class="nomu-panel p-6 sm:p-7 mb-8">
    <div class="flex items-center justify-between mb-6">
        <div>
            <span class="nomu-label text-[#FF7448] block">Pelacakan Real-Time</span>
            <h2 class="text-base font-extrabold text-[#0F151D]">Alur Pengajuan Beasiswa</h2>
        </div>
        <span class="text-xs font-mono text-[#5B6573]">{{ $pengajuanAktif->nomor_pendaftaran }}</span>
    </div>

    @php
        $steps = [
            'draft' => ['num' => '01', 'title' => 'Draft', 'desc' => 'Lengkapi berkas'],
            'submitted' => ['num' => '02', 'title' => 'Submitted', 'desc' => 'Terkirim ke admin'],
            'verifikasi_berkas' => ['num' => '03', 'title' => 'Verifikasi', 'desc' => 'Cek keabsahan'],
            'seleksi_saw' => ['num' => '04', 'title' => 'Seleksi SAW', 'desc' => 'Hitung bobot SPK'],
            'pengumuman' => ['num' => '05', 'title' => 'Pengumuman', 'desc' => 'Hasil kelulusan'],
        ];
        $order = ['draft', 'submitted', 'verifikasi_berkas', 'seleksi_saw', 'pengumuman'];
        $currentIdx = array_search($pengajuanAktif->status_tahap, $order);
        if ($pengajuanAktif->status_tahap === 'diterima' || $pengajuanAktif->status_tahap === 'ditolak') {
            $currentIdx = 4;
        }
    @endphp

    <div class="grid grid-cols-2 sm:grid-cols-5 gap-3">
        @foreach($order as $idx => $sKey)
            @php
                $isCompleted = $idx < $currentIdx;
                $isCurrent = $idx === $currentIdx;
            @endphp
            <div class="p-4 rounded-2xl border transition {{ $isCurrent ? 'bg-[#FFF9F6] border-[#FF7448]/35 shadow-xs' : ($isCompleted ? 'bg-[#E5F3EE]/50 border-[#237C65]/20' : 'bg-[#F8F9FB] border-[#0F151D]/6') }}">
                <div class="flex items-center justify-between mb-2">
                    <span class="nomu-label {{ $isCurrent ? 'text-[#FF7448]' : ($isCompleted ? 'text-[#237C65]' : 'text-[#5B6573]') }}">
                        {{ $steps[$sKey]['num'] }}
                    </span>
                    @if($isCompleted)
                        <span class="size-5 rounded-full bg-[#237C65] text-white inline-flex items-center justify-center">
                            <svg class="size-3" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" aria-hidden="true"><polyline points="20 6 9 17 4 12"/></svg>
                        </span>
                    @elseif($isCurrent)
                        <span class="size-2.5 rounded-full bg-[#FF7448]"></span>
                    @endif
                </div>
                <h3 class="text-xs font-bold text-[#0F151D]">{{ $steps[$sKey]['title'] }}</h3>
                <p class="text-[11px] text-[#5B6573] mt-0.5">{{ $steps[$sKey]['desc'] }}</p>
            </div>
        @endforeach
    </div>
</div>
@endif

<!-- Tabel Kelengkapan Berkas -->
<div data-motion="reveal" class="nomu-panel overflow-hidden mb-8">
    <div class="p-6 border-b border-[#0F151D]/8 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <span class="nomu-label text-[#FF7448] block">Dokumen Administrasi</span>
            <h2 class="text-base font-extrabold text-[#0F151D]">Kelengkapan Berkas Persyaratan</h2>
        </div>
        @if($pengajuanAktif)
            <a href="{{ route('mahasiswa.berkas', $pengajuanAktif->id) }}" data-motion="pill-press" class="nomu-cta-btn px-5 py-2.5 rounded-full text-xs font-bold text-center">
                Kelola &amp; Unggah Berkas
            </a>
        @endif
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm">
            <thead class="bg-[#FFF9F6] text-[11px] font-mono uppercase tracking-wider text-[#5B6573] border-b border-[#0F151D]/8">
                <tr>
                    <th class="px-6 py-3.5">Nama Dokumen</th>
                    <th class="px-6 py-3.5">Sifat</th>
                    <th class="px-6 py-3.5">Status Validasi</th>
                    <th class="px-6 py-3.5 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody data-motion="table-stagger" class="divide-y divide-[#0F151D]/6">
                @if($pengajuanAktif && $pengajuanAktif->berkas->isNotEmpty())
                    @foreach($pengajuanAktif->berkas as $doc)
                        <tr class="hover:bg-[#FFF9F6]/60 transition">
                            <td class="px-6 py-4 font-semibold text-[#0F151D]">{{ $doc->nama_dokumen }}</td>
                            <td class="px-6 py-4">
                                <span class="text-xs font-semibold px-2.5 py-0.5 rounded-full {{ $doc->wajib ? 'bg-[#FFEAE3] text-[#B83209]' : 'bg-[#F1EBE9] text-[#5B6573]' }}">
                                    {{ $doc->wajib ? 'Wajib' : 'Opsional' }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                @php
                                    $bBadges = [
                                        'pending' => ['label' => 'Menunggu Verifikasi', 'class' => 'bg-[#F1EBE9] text-[#5B6573]'],
                                        'valid' => ['label' => 'Valid', 'class' => 'bg-[#E5F3EE] text-[#237C65]'],
                                        'perlu_revisi' => ['label' => 'Perlu Revisi', 'class' => 'bg-[#FFEAE3] text-[#B83209]'],
                                        'ditolak' => ['label' => 'Ditolak', 'class' => 'bg-[#FFEAE3] text-[#B83209]'],
                                    ];
                                    $bSt = $bBadges[$doc->status_verifikasi] ?? ['label' => '-', 'class' => 'bg-[#F1EBE9]'];
                                @endphp
                                <span class="text-xs font-semibold px-3 py-1 rounded-full {{ $bSt['class'] }}">
                                    {{ $bSt['label'] }}
                                </span>
                                @if($doc->catatan_verifikasi)
                                    <p class="text-xs text-[#B83209] mt-1">Catatan: {{ $doc->catatan_verifikasi }}</p>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right">
                                <a href="{{ asset('storage/' . $doc->file_path) }}" target="_blank" class="text-xs font-bold text-[#243C61] hover:text-[#FF7448] transition">
                                    Lihat Berkas &rarr;
                                </a>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="4" class="px-6 py-10 text-center text-xs text-[#5B6573]">
                            Belum ada dokumen yang diunggah untuk pengajuan ini.
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>
@endsection
