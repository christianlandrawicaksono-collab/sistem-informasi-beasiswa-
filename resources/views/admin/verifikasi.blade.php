@extends('layouts.app')

@section('title', 'Verifikasi Berkas Pelamar')

@section('content')
<div class="max-w-4xl mx-auto my-4">
    <div data-motion="hero-item" class="mb-6 flex flex-col sm:flex-row sm:items-end justify-between gap-4">
        <div>
            <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-[#5B6573] hover:text-[#FF7448] transition mb-3">
                <svg class="size-3.5" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m12 19-7-7 7-7"/><path d="M19 12H5"/></svg>
                <span>Kembali ke Dashboard Admin</span>
            </a>
            <span class="nomu-label text-[#FF7448] block">Desk Screening</span>
            <h1 class="text-2xl font-extrabold text-[#0F151D]">Verifikasi Berkas Mahasiswa</h1>
        </div>
        <div class="px-4 py-2 rounded-2xl bg-white border border-[#0F151D]/8">
            <span class="nomu-label text-[#5B6573] block">No. Pendaftaran</span>
            <span class="font-mono font-bold text-sm text-[#0F151D]">{{ $pengajuan->nomor_pendaftaran }}</span>
        </div>
    </div>

    <!-- Info Mahasiswa -->
    <div data-motion="hero-item" class="nomu-card p-6 mb-6 grid grid-cols-2 sm:grid-cols-4 gap-4 text-xs">
        <div>
            <span class="nomu-label text-[#5B6573] block mb-1">Mahasiswa</span>
            <span class="font-bold text-[#0F151D] text-sm">{{ $pengajuan->profil->nama_lengkap }}</span>
        </div>
        <div>
            <span class="nomu-label text-[#5B6573] block mb-1">NIM</span>
            <span class="font-bold text-[#0F151D] font-mono text-sm">{{ $pengajuan->profil->nim }}</span>
        </div>
        <div>
            <span class="nomu-label text-[#5B6573] block mb-1">Program Studi</span>
            <span class="font-bold text-[#0F151D]">{{ $pengajuan->profil->prodi }}</span>
        </div>
        <div>
            <span class="nomu-label text-[#5B6573] block mb-1">IPK</span>
            <span class="font-extrabold text-[#FF7448] font-mono text-sm">{{ number_format($pengajuan->profil->ipk, 2) }}</span>
        </div>
    </div>

    <!-- Daftar Dokumen -->
    <div data-motion="reveal" class="nomu-panel overflow-hidden mb-6">
        <div class="p-6 border-b border-[#0F151D]/8">
            <h2 class="text-base font-extrabold text-[#0F151D]">Dokumen yang Diunggah</h2>
        </div>

        <div class="divide-y divide-[#0F151D]/6">
            @forelse($pengajuan->berkas as $dok)
                <div class="p-6 flex flex-col lg:flex-row lg:items-center justify-between gap-4">
                    <div>
                        <div class="flex items-center gap-2">
                            <h3 class="font-bold text-[#0F151D] text-sm">{{ $dok->nama_dokumen }}</h3>
                            <span class="text-[10px] font-bold px-2.5 py-0.5 rounded-full {{ $dok->wajib ? 'bg-[#FFEAE3] text-[#B83209]' : 'bg-[#F1EBE9] text-[#5B6573]' }}">
                                {{ $dok->wajib ? 'Wajib' : 'Opsional' }}
                            </span>
                        </div>
                        <p class="text-xs font-mono text-[#5B6573] mt-1 tabular-nums">{{ $dok->file_size }} KB · {{ strtoupper($dok->file_type) }}</p>
                        @if($dok->catatan_verifikasi)
                            <p class="text-xs text-[#B83209] bg-[#FFEAE3] px-3 py-1.5 rounded-xl mt-2 font-medium">Catatan: {{ $dok->catatan_verifikasi }}</p>
                        @endif
                    </div>

                    <div class="flex flex-wrap items-center gap-2.5">
                        <a href="{{ asset('storage/' . $dok->file_path) }}" target="_blank" class="px-4 py-2 rounded-full bg-[#F1EBE9] hover:bg-[#E4EDFF] text-[#0F151D] text-xs font-bold transition">
                            Buka File
                        </a>

                        <form action="{{ route('admin.berkas.status', $dok->id) }}" method="POST" class="flex flex-wrap items-center gap-2">
                            @csrf
                            @method('PATCH')
                            <select name="status_verifikasi" aria-label="Status verifikasi berkas" class="text-xs font-semibold px-3 py-2 rounded-full border border-[#0F151D]/12 bg-white focus:outline-none">
                                <option value="valid" {{ $dok->status_verifikasi === 'valid' ? 'selected' : '' }}>Valid</option>
                                <option value="perlu_revisi" {{ $dok->status_verifikasi === 'perlu_revisi' ? 'selected' : '' }}>Perlu Revisi</option>
                                <option value="ditolak" {{ $dok->status_verifikasi === 'ditolak' ? 'selected' : '' }}>Tolak</option>
                            </select>
                            <input type="text" name="catatan_verifikasi" placeholder="Catatan revisi..." value="{{ $dok->catatan_verifikasi }}" class="text-xs px-3 py-2 rounded-full border border-[#0F151D]/12 bg-[#FFF9F6]/60 focus:bg-white focus:outline-none">
                            <button type="submit" data-motion="pill-press" class="px-4 py-2 rounded-full bg-[#0F151D] hover:bg-[#FF7448] text-white text-xs font-bold transition cursor-pointer">
                                Simpan
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="p-10 text-center text-xs text-[#5B6573]">
                    Mahasiswa belum mengunggah dokumen persyaratan.
                </div>
            @endforelse
        </div>
    </div>

    <!-- Penetapan Status Akhir -->
    <div data-motion="reveal" class="nomu-panel p-6 sm:p-7">
        <span class="nomu-label text-[#FF7448] block mb-1">Keputusan Tahap</span>
        <h3 class="text-base font-extrabold text-[#0F151D] mb-1">Penetapan Status Pendaftaran</h3>
        <p class="text-xs text-[#5B6573] mb-4">Kirim pelamar ke tahap seleksi SAW atau tetapkan status kelulusan akhir.</p>

        <form action="{{ route('admin.pengajuan.status', $pengajuan->id) }}" method="POST" class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3">
            @csrf
            @method('PATCH')

            <select name="status_tahap" class="px-4 py-3 rounded-full border border-[#0F151D]/12 bg-[#FFF9F6]/60 text-sm font-semibold focus:outline-none">
                <option value="seleksi_saw" {{ $pengajuan->status_tahap === 'seleksi_saw' ? 'selected' : '' }}>Kirim ke Seleksi SAW</option>
                <option value="diterima" {{ $pengajuan->status_tahap === 'diterima' ? 'selected' : '' }}>Diterima (Lolos Beasiswa)</option>
                <option value="ditolak" {{ $pengajuan->status_tahap === 'ditolak' ? 'selected' : '' }}>Tidak Lolos (Ditolak)</option>
            </select>

            <input type="text" name="catatan_admin" placeholder="Catatan pengumuman untuk mahasiswa..." value="{{ $pengajuan->catatan_admin }}" class="flex-1 px-4 py-3 rounded-full border border-[#0F151D]/12 bg-[#FFF9F6]/60 focus:bg-white text-sm focus:outline-none">

            <button type="submit" data-motion="pill-press" class="nomu-cta-btn px-6 py-3 rounded-full font-bold text-sm cursor-pointer shrink-0">
                Perbarui Status
            </button>
        </form>
    </div>
</div>
@endsection
