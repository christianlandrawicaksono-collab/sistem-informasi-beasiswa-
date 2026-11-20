@extends('layouts.app')

@section('title', 'Verifikasi Berkas Pelamar')

@section('content')
<div class="max-w-4xl mx-auto my-6">
    <div class="mb-6 flex items-center justify-between">
        <div>
            <a href="{{ route('admin.dashboard') }}" class="text-xs font-bold text-amber-600 hover:underline flex items-center space-x-1 mb-2">
                <i class="fa-solid fa-arrow-left"></i>
                <span>Kembali ke Dashboard Admin</span>
            </a>
            <h1 class="text-2xl font-extrabold text-slate-900">Verifikasi Berkas Mahasiswa</h1>
            <p class="text-xs text-slate-500">Periksa keabsahan dokumen persyaratan dan tentukan status kelulusan</p>
        </div>
        <div class="text-right">
            <span class="text-xs text-slate-400 block">No. Pendaftaran:</span>
            <span class="font-mono font-bold text-sm text-slate-800">{{ $pengajuan->nomor_pendaftaran }}</span>
        </div>
    </div>

    <!-- Info Mahasiswa -->
    <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm mb-6 grid grid-cols-2 sm:grid-cols-4 gap-4 text-xs">
        <div>
            <span class="text-slate-400 block mb-0.5">Nama Mahasiswa:</span>
            <span class="font-bold text-slate-800 text-sm">{{ $pengajuan->profil->nama_lengkap }}</span>
        </div>
        <div>
            <span class="text-slate-400 block mb-0.5">NIM:</span>
            <span class="font-bold text-slate-800 text-sm">{{ $pengajuan->profil->nim }}</span>
        </div>
        <div>
            <span class="text-slate-400 block mb-0.5">Prodi / Fakultas:</span>
            <span class="font-bold text-slate-800">{{ $pengajuan->profil->prodi }}</span>
        </div>
        <div>
            <span class="text-slate-400 block mb-0.5">IPK:</span>
            <span class="font-bold text-amber-600 text-sm">{{ number_format($pengajuan->profil->ipk, 2) }}</span>
        </div>
    </div>

    <!-- Daftar Dokumen yang Diperiksa -->
    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden mb-6">
        <div class="p-6 border-b border-slate-100">
            <h2 class="text-base font-bold text-slate-900">Dokumen yang Diunggah</h2>
        </div>

        <div class="divide-y divide-slate-100">
            @forelse($pengajuan->berkas as $dok)
                <div class="p-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div>
                        <h4 class="font-bold text-slate-900 text-sm flex items-center space-x-2">
                            <span>{{ $dok->nama_dokumen }}</span>
                            <span class="text-[10px] font-bold px-2 py-0.5 rounded {{ $dok->wajib ? 'bg-amber-100 text-amber-800' : 'bg-slate-100 text-slate-600' }}">
                                {{ $dok->wajib ? 'Wajib' : 'Opsional' }}
                            </span>
                        </h4>
                        <p class="text-xs text-slate-400 mt-1">Ukuran: {{ $dok->file_size }} KB • Tipe: {{ strtoupper($dok->file_type) }}</p>
                        @if($dok->catatan_verifikasi)
                            <p class="text-xs text-amber-700 bg-amber-50 p-2 rounded-lg mt-2 font-medium">Catatan: {{ $dok->catatan_verifikasi }}</p>
                        @endif
                    </div>

                    <div class="flex flex-col sm:flex-row items-end sm:items-center gap-3">
                        <a href="{{ asset('storage/' . $dok->file_path) }}" target="_blank" class="px-3 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold rounded-lg transition">
                            <i class="fa-solid fa-eye mr-1"></i> Buka File
                        </a>

                        <!-- Form Update Status Dokumen -->
                        <form action="{{ route('admin.berkas.status', $dok->id) }}" method="POST" class="flex items-center space-x-2">
                            @csrf
                            @method('PATCH')
                            <select name="status_verifikasi" class="text-xs font-semibold px-2 py-1.5 rounded-lg border border-slate-200 bg-white">
                                <option value="valid" {{ $dok->status_verifikasi === 'valid' ? 'selected' : '' }}>Valid</option>
                                <option value="perlu_revisi" {{ $dok->status_verifikasi === 'perlu_revisi' ? 'selected' : '' }}>Perlu Revisi</option>
                                <option value="ditolak" {{ $dok->status_verifikasi === 'ditolak' ? 'selected' : '' }}>Tolak</option>
                            </select>
                            <input type="text" name="catatan_verifikasi" placeholder="Catatan jika revisi..." value="{{ $dok->catatan_verifikasi }}" class="text-xs px-2 py-1.5 rounded-lg border border-slate-200">
                            <button type="submit" class="px-3 py-1.5 bg-slate-900 hover:bg-amber-600 text-white text-xs font-bold rounded-lg transition">
                                Simpan
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="p-8 text-center text-xs text-slate-400">
                    Mahasiswa belum mengunggah dokumen persyaratan.
                </div>
            @endforelse
        </div>
    </div>

    <!-- Penetapan Status Akhir Pelamar -->
    <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm">
        <h3 class="text-base font-bold text-slate-900 mb-2">Penetapan Status Tahap Pendaftaran</h3>
        <p class="text-xs text-slate-500 mb-4">Ubah status pelamar untuk mengikutsertakan ke tahap seleksi SAW atau menetapkan penerimaan.</p>

        <form action="{{ route('admin.pengajuan.status', $pengajuan->id) }}" method="POST" class="flex flex-col sm:flex-row items-center gap-3">
            @csrf
            @method('PATCH')

            <select name="status_tahap" class="w-full sm:w-auto px-4 py-2.5 rounded-xl border border-slate-200 text-sm font-semibold">
                <option value="seleksi_saw" {{ $pengajuan->status_tahap === 'seleksi_saw' ? 'selected' : '' }}>Kirim ke Seleksi SAW</option>
                <option value="diterima" {{ $pengajuan->status_tahap === 'diterima' ? 'selected' : '' }}>Diterima (Lolos Beasiswa)</option>
                <option value="ditolak" {{ $pengajuan->status_tahap === 'ditolak' ? 'selected' : '' }}>Tidak Lolos (Ditolak)</option>
            </select>

            <input type="text" name="catatan_admin" placeholder="Catatan pengumuman untuk mahasiswa..." value="{{ $pengajuan->catatan_admin }}" class="w-full sm:flex-1 px-4 py-2.5 rounded-xl border border-slate-200 text-sm">

            <button type="submit" class="w-full sm:w-auto px-6 py-2.5 bg-amber-500 hover:bg-amber-600 text-white font-bold rounded-xl text-sm transition shadow-sm">
                Perbarui Status
            </button>
        </form>
    </div>
</div>
@endsection
