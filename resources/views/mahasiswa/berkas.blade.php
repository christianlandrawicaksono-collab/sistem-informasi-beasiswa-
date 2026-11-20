@extends('layouts.app')

@section('title', 'Kelola Berkas Pengajuan')

@section('content')
<div class="max-w-4xl mx-auto my-6">
    <div class="mb-6 flex items-center justify-between">
        <div>
            <a href="{{ route('mahasiswa.dashboard') }}" class="text-xs font-bold text-amber-600 hover:underline flex items-center space-x-1 mb-2">
                <i class="fa-solid fa-arrow-left"></i>
                <span>Kembali ke Dashboard</span>
            </a>
            <h1 class="text-2xl font-extrabold text-slate-900">Kelengkapan Berkas Persyaratan</h1>
            <p class="text-xs text-slate-500">Program: <span class="font-bold text-slate-700">{{ $pengajuan->beasiswa->nama_program }}</span></p>
        </div>
        <div class="text-right">
            <span class="text-xs text-slate-400 block">Nomor Pendaftaran</span>
            <span class="font-mono font-bold text-sm text-slate-800">{{ $pengajuan->nomor_pendaftaran }}</span>
        </div>
    </div>

    <!-- Upload Form -->
    <div class="bg-white p-6 sm:p-8 rounded-3xl border border-slate-200 shadow-sm mb-8">
        <h2 class="text-base font-bold text-slate-900 mb-4">Unggah Dokumen Baru</h2>

        <form action="{{ route('mahasiswa.berkas.upload', $pengajuan->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Jenis Dokumen</label>
                    <select name="nama_dokumen" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-amber-500 focus:ring-2 focus:ring-amber-200 text-sm">
                        @foreach($dokumenWajib as $dok)
                            <option value="{{ $dok }}">{{ $dok }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Pilih File (PDF, JPG, PNG - Maks 3MB)</label>
                    <input type="file" name="file" required accept=".pdf,.jpg,.jpeg,.png" class="w-full px-3 py-2 rounded-xl border border-slate-200 text-sm file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-amber-50 file:text-amber-700 hover:file:bg-amber-100">
                </div>
            </div>

            <div class="flex justify-end pt-2">
                <button type="submit" class="px-6 py-2.5 bg-amber-500 hover:bg-amber-600 text-white font-bold rounded-xl text-sm transition shadow-sm shadow-amber-200 flex items-center space-x-1.5">
                    <i class="fa-solid fa-cloud-arrow-up"></i>
                    <span>Unggah Dokumen</span>
                </button>
            </div>
        </form>
    </div>

    <!-- Daftar Dokumen Terunggah -->
    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden mb-8">
        <div class="p-6 border-b border-slate-100">
            <h2 class="text-base font-bold text-slate-900">Dokumen yang Telah Diunggah</h2>
        </div>

        <div class="divide-y divide-slate-100">
            @forelse($pengajuan->berkas as $b)
                <div class="p-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div class="flex items-start space-x-3">
                        <div class="w-10 h-10 rounded-xl bg-rose-50 text-rose-500 flex items-center justify-center text-lg mt-0.5">
                            <i class="fa-regular fa-file-pdf"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-slate-900 text-sm">{{ $b->nama_dokumen }}</h4>
                            <p class="text-xs text-slate-400 mt-0.5">
                                Ukuran: {{ $b->file_size }} KB • Tipe: {{ strtoupper($b->file_type) }}
                            </p>
                            @if($b->catatan_verifikasi)
                                <p class="text-xs text-amber-700 mt-1 font-medium bg-amber-50 p-2 rounded-lg">
                                    Catatan Admin: {{ $b->catatan_verifikasi }}
                                </p>
                            @endif
                        </div>
                    </div>

                    <div class="flex items-center space-x-3">
                        @php
                            $bStatus = [
                                'pending' => ['bg' => 'bg-slate-100 text-slate-600', 'txt' => 'Menunggu Validasi'],
                                'valid' => ['bg' => 'bg-emerald-100 text-emerald-700', 'txt' => 'Valid'],
                                'perlu_revisi' => ['bg' => 'bg-amber-100 text-amber-700', 'txt' => 'Perlu Revisi'],
                                'ditolak' => ['bg' => 'bg-rose-100 text-rose-700', 'txt' => 'Ditolak'],
                            ];
                            $bs = $bStatus[$b->status_verifikasi] ?? ['bg' => 'bg-slate-100 text-slate-600', 'txt' => '-'];
                        @endphp
                        <span class="text-xs font-semibold px-3 py-1 rounded-full {{ $bs['bg'] }}">
                            {{ $bs['txt'] }}
                        </span>

                        <a href="{{ asset('storage/' . $b->file_path) }}" target="_blank" class="text-xs font-bold text-slate-700 hover:text-amber-600 px-3 py-1.5 border border-slate-200 rounded-lg hover:bg-slate-50">
                            Lihat File
                        </a>
                    </div>
                </div>
            @empty
                <div class="p-8 text-center text-xs text-slate-400">
                    Belum ada berkas yang diunggah. Silakan pilih jenis dokumen dan unggah file di atas.
                </div>
            @endforelse
        </div>
    </div>

    <!-- Final Submit Action -->
    @if($pengajuan->status_tahap === 'draft')
        <div class="bg-amber-50 p-6 rounded-3xl border border-amber-200 flex flex-col sm:flex-row items-center justify-between gap-4">
            <div>
                <h4 class="font-bold text-slate-900 text-sm">Kirim Pengajuan Beasiswa</h4>
                <p class="text-xs text-slate-600">Pastikan seluruh berkas wajib telah diunggah dengan benar sebelum melakukan kirim final.</p>
            </div>
            <form action="{{ route('mahasiswa.submit', $pengajuan->id) }}" method="POST">
                @csrf
                <button type="submit" onclick="return confirm('Apakah Anda yakin seluruh berkas sudah lengkap?')" class="px-6 py-2.5 bg-slate-900 hover:bg-amber-600 text-white font-bold rounded-xl text-sm transition shadow-sm">
                    Kirim Pengajuan (Submit)
                </button>
            </form>
        </div>
    @endif
</div>
@endsection
