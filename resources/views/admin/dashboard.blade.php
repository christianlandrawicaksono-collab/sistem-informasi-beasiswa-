@extends('layouts.app')

@section('title', 'Dashboard Admin Kemahasiswaan')

@section('content')
<div data-motion="hero-item" class="mb-8 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
    <div>
        <span class="nomu-label text-[#FF7448] block mb-1">Admin &amp; Management Portal</span>
        <h1 class="text-2xl sm:text-3xl font-extrabold text-[#0F151D]">Dashboard Kemahasiswaan</h1>
        <p class="text-xs text-[#5B6573] mt-1">Kelola program beasiswa, verifikasi kelengkapan berkas, dan pantau statistik pelamar.</p>
    </div>

    <div class="flex flex-wrap items-center gap-2.5">
        <a href="{{ route('admin.beasiswa.index') }}" class="px-4 py-2.5 rounded-full bg-white border border-[#0F151D]/10 text-[#0F151D] text-xs font-bold hover:bg-[#F1EBE9] transition">
            Daftar Beasiswa
        </a>
        <a href="{{ route('admin.beasiswa.create') }}" data-motion="pill-press" class="nomu-cta-btn px-5 py-2.5 rounded-full text-xs font-bold inline-flex items-center gap-1.5">
            <svg class="size-3.5" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" aria-hidden="true"><line x1="12" x2="12" y1="5" y2="19"/><line x1="5" x2="19" y1="12" y2="12"/></svg>
            <span>Tambah Beasiswa</span>
        </a>
        <a href="{{ route('reviewer.dashboard') }}" data-motion="pill-press" class="px-5 py-2.5 rounded-full bg-[#0F151D] hover:bg-[#1B232E] text-white text-xs font-bold transition">
            Panel Seleksi SAW
        </a>
    </div>
</div>

<!-- 4 Bento KPI Cards -->
<div data-motion="stagger-grid" class="grid grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-5 mb-8">
    <div data-motion-card class="nomu-card p-5 sm:p-6">
        <span class="nomu-label text-[#5B6573] block mb-2">Total Pelamar</span>
        <p class="text-3xl font-extrabold text-[#0F151D] tabular-nums">{{ $totalPelamar }}</p>
        <span class="text-xs text-[#237C65] font-semibold mt-1 inline-block">Real-Time</span>
    </div>

    <div data-motion-card class="rounded-[24px] p-5 sm:p-6 bg-[#FFEAE3]/70 border border-[#FF7448]/25 shadow-xs">
        <span class="nomu-label text-[#B83209] block mb-2">Perlu Verifikasi</span>
        <p class="text-3xl font-extrabold text-[#F13F07] tabular-nums">{{ $perluVerifikasi }}</p>
        <span class="text-xs text-[#B83209] font-medium mt-1 block">Berkas menunggu</span>
    </div>

    <div data-motion-card class="nomu-card p-5 sm:p-6">
        <span class="nomu-label text-[#5B6573] block mb-2">Terverifikasi</span>
        <p class="text-3xl font-extrabold text-[#237C65] tabular-nums">{{ $terverifikasi }}</p>
        <span class="text-xs text-[#5B6573] mt-1 block">Siap seleksi SAW</span>
    </div>

    <div data-motion-card class="rounded-[24px] p-5 sm:p-6 bg-[#E4EDFF] border border-[#526991]/15 shadow-xs">
        <span class="nomu-label text-[#526991] block mb-2">Total Kuota</span>
        <p class="text-3xl font-extrabold text-[#243C61] tabular-nums">{{ $totalKuota }}</p>
        <span class="text-xs text-[#243C61] mt-1 block">Kapasitas penerima</span>
    </div>
</div>

<!-- Data Pelamar Panel -->
<div data-motion="reveal" class="nomu-panel overflow-hidden mb-8">
    <div class="p-6 border-b border-[#0F151D]/8 flex justify-between items-center">
        <div>
            <span class="nomu-label text-[#FF7448] block">Antrean Pendaftaran</span>
            <h2 class="text-base font-extrabold text-[#0F151D]">Data Pelamar Beasiswa</h2>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm">
            <thead class="bg-[#FFF9F6] text-[11px] font-mono uppercase tracking-wider text-[#5B6573] border-b border-[#0F151D]/8">
                <tr>
                    <th class="px-6 py-3.5">No. Daftar</th>
                    <th class="px-6 py-3.5">Mahasiswa</th>
                    <th class="px-6 py-3.5">Program Beasiswa</th>
                    <th class="px-6 py-3.5">Tahap</th>
                    <th class="px-6 py-3.5">Skor SAW</th>
                    <th class="px-6 py-3.5 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody data-motion="table-stagger" class="divide-y divide-[#0F151D]/6">
                @forelse($pelamars as $p)
                    <tr class="hover:bg-[#FFF9F6]/60 transition">
                        <td class="px-6 py-4 font-mono text-xs font-bold text-[#0F151D]">
                            {{ $p->nomor_pendaftaran }}
                        </td>
                        <td class="px-6 py-4">
                            <span class="font-bold text-[#0F151D] block">{{ $p->profil->nama_lengkap }}</span>
                            <span class="text-xs text-[#5B6573] font-mono">NIM {{ $p->profil->nim }} · IPK {{ number_format($p->profil->ipk, 2) }}</span>
                        </td>
                        <td class="px-6 py-4 font-medium text-[#0F151D]">
                            {{ $p->beasiswa->nama_program }}
                        </td>
                        <td class="px-6 py-4">
                            @php
                                $stBadge = [
                                    'draft' => 'bg-[#F1EBE9] text-[#5B6573]',
                                    'submitted' => 'bg-[#E4EDFF] text-[#243C61]',
                                    'verifikasi_berkas' => 'bg-[#FFEAE3] text-[#B83209]',
                                    'seleksi_saw' => 'bg-[#D3E1FF] text-[#243C61]',
                                    'diterima' => 'bg-[#E5F3EE] text-[#237C65]',
                                    'ditolak' => 'bg-[#FFEAE3] text-[#B83209]',
                                ];
                                $bClass = $stBadge[$p->status_tahap] ?? 'bg-[#F1EBE9] text-[#5B6573]';
                            @endphp
                            <span class="text-[11px] font-bold px-3 py-1 rounded-full uppercase {{ $bClass }}">
                                {{ str_replace('_', ' ', $p->status_tahap) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 font-mono font-bold text-[#0F151D] tabular-nums">
                            {{ $p->total_skor_saw ? number_format($p->total_skor_saw, 4) : '—' }}
                        </td>
                        <td class="px-6 py-4 text-right">
                            <a href="{{ route('admin.verifikasi', $p->id) }}" data-motion="pill-press" class="inline-block px-4 py-2 rounded-full bg-[#0F151D] hover:bg-[#FF7448] text-white text-xs font-bold transition">
                                Verifikasi Berkas
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-10 text-center text-xs text-[#5B6573]">
                            Belum ada pendaftaran beasiswa yang masuk.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($pelamars->hasPages())
        <div class="p-4 border-t border-[#0F151D]/8">
            {{ $pelamars->links() }}
        </div>
    @endif
</div>
@endsection
