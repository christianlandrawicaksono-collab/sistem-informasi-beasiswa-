@extends('layouts.app')

@section('title', 'Kelola Berkas Pengajuan')

@section('content')
<div class="max-w-4xl mx-auto my-4">
    <div data-motion="hero-item" class="mb-6 flex flex-col sm:flex-row sm:items-end justify-between gap-4">
        <div>
            <a href="{{ route('mahasiswa.dashboard') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-[#5B6573] hover:text-[#FF7448] transition mb-3">
                <svg class="size-3.5" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m12 19-7-7 7-7"/><path d="M19 12H5"/></svg>
                <span>Kembali ke Portal Mahasiswa</span>
            </a>
            <span class="nomu-label text-[#FF7448] block">Unggah Dokumen</span>
            <h1 class="text-2xl font-extrabold text-[#0F151D]">Kelengkapan Berkas Persyaratan</h1>
            <p class="text-xs text-[#5B6573] mt-1">Program: <strong class="text-[#0F151D]">{{ $pengajuan->beasiswa->nama_program }}</strong></p>
        </div>
        <div class="px-4 py-2 rounded-2xl bg-white border border-[#0F151D]/8">
            <span class="nomu-label text-[#5B6573] block">Nomor Pendaftaran</span>
            <span class="font-mono font-bold text-sm text-[#0F151D]">{{ $pengajuan->nomor_pendaftaran }}</span>
        </div>
    </div>

    <!-- Upload Form -->
    <div data-motion="hero-item" class="nomu-panel p-6 sm:p-8 mb-8">
        <h2 class="text-base font-extrabold text-[#0F151D] mb-4">Unggah Dokumen Baru</h2>

        <form action="{{ route('mahasiswa.berkas.upload', $pengajuan->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="doc-type" class="nomu-label text-[#0F151D] block mb-1.5">Jenis Dokumen</label>
                    <select id="doc-type" name="nama_dokumen" required class="w-full px-4 py-3 rounded-2xl border border-[#0F151D]/12 bg-[#FFF9F6]/60 focus:bg-white text-sm focus:outline-none">
                        @foreach($dokumenWajib as $dok)
                            <option value="{{ $dok }}">{{ $dok }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="doc-file" class="nomu-label text-[#0F151D] block mb-1.5">Pilih File (PDF, JPG, PNG · Maks 3MB)</label>
                    <input id="doc-file" type="file" name="file" required accept=".pdf,.jpg,.jpeg,.png" class="w-full px-3 py-2 rounded-2xl border border-[#0F151D]/12 bg-[#FFF9F6]/60 text-sm file:mr-3 file:py-1.5 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-bold file:bg-[#FFEAE3] file:text-[#B83209] hover:file:brightness-95 cursor-pointer">
                </div>
            </div>

            <div class="flex justify-end pt-2">
                <button type="submit" data-motion="pill-press" class="nomu-cta-btn px-6 py-3 rounded-full font-bold text-xs cursor-pointer inline-flex items-center gap-2">
                    <svg class="size-4" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" x2="12" y1="3" y2="15"/></svg>
                    <span>Unggah Dokumen</span>
                </button>
            </div>
        </form>
    </div>

    <!-- Uploaded List -->
    <div data-motion="reveal" class="nomu-panel overflow-hidden mb-8">
        <div class="p-6 border-b border-[#0F151D]/8">
            <h2 class="text-base font-extrabold text-[#0F151D]">Dokumen yang Telah Diunggah</h2>
        </div>

        <div class="divide-y divide-[#0F151D]/6">
            @forelse($pengajuan->berkas as $b)
                <div class="p-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4 hover:bg-[#FFF9F6]/50 transition">
                    <div class="flex items-start gap-3.5">
                        <div class="size-10 rounded-2xl bg-[#FFEAE3] text-[#B83209] flex items-center justify-center shrink-0">
                            <svg class="size-5" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"/><polyline points="14 2 14 8 20 8"/></svg>
                        </div>
                        <div>
                            <h3 class="font-bold text-[#0F151D] text-sm">{{ $b->nama_dokumen }}</h3>
                            <p class="text-xs font-mono text-[#5B6573] mt-0.5 tabular-nums">{{ $b->file_size }} KB · {{ strtoupper($b->file_type) }}</p>
                            @if($b->catatan_verifikasi)
                                <p class="text-xs text-[#B83209] mt-2 font-medium bg-[#FFEAE3] px-3 py-1.5 rounded-xl">
                                    Catatan Admin: {{ $b->catatan_verifikasi }}
                                </p>
                            @endif
                        </div>
                    </div>

                    <div class="flex items-center gap-3">
                        @php
                            $bStatus = [
                                'pending' => ['bg' => 'bg-[#F1EBE9] text-[#5B6573]', 'txt' => 'Menunggu Validasi'],
                                'valid' => ['bg' => 'bg-[#E5F3EE] text-[#237C65]', 'txt' => 'Valid'],
                                'perlu_revisi' => ['bg' => 'bg-[#FFEAE3] text-[#B83209]', 'txt' => 'Perlu Revisi'],
                                'ditolak' => ['bg' => 'bg-[#FFEAE3] text-[#B83209]', 'txt' => 'Ditolak'],
                            ];
                            $bs = $bStatus[$b->status_verifikasi] ?? ['bg' => 'bg-[#F1EBE9] text-[#5B6573]', 'txt' => '-'];
                        @endphp
                        <span class="text-xs font-semibold px-3 py-1 rounded-full {{ $bs['bg'] }}">
                            {{ $bs['txt'] }}
                        </span>

                        <a href="{{ asset('storage/' . $b->file_path) }}" target="_blank" class="text-xs font-bold text-[#0F151D] hover:text-[#FF7448] px-3.5 py-2 border border-[#0F151D]/12 rounded-full bg-white transition">
                            Lihat File
                        </a>
                    </div>
                </div>
            @empty
                <div class="p-10 text-center text-xs text-[#5B6573]">
                    Belum ada berkas yang diunggah. Silakan pilih jenis dokumen dan unggah file di atas.
                </div>
            @endforelse
        </div>
    </div>

    @if($pengajuan->status_tahap === 'draft')
        <div data-motion="reveal" class="p-6 rounded-[28px] bg-[#E4EDFF] border border-[#526991]/20 flex flex-col sm:flex-row items-center justify-between gap-4">
            <div>
                <h3 class="font-extrabold text-[#0F151D] text-base">Kirim Pengajuan Beasiswa</h3>
                <p class="text-xs text-[#243C61] mt-0.5">Pastikan seluruh berkas wajib telah diunggah dengan benar sebelum melakukan kirim final.</p>
            </div>
            <form action="{{ route('mahasiswa.submit', $pengajuan->id) }}" method="POST">
                @csrf
                <button type="submit" data-motion="pill-press" onclick="return confirm('Apakah Anda yakin seluruh berkas sudah lengkap?')" class="px-6 py-3 rounded-full bg-[#0F151D] hover:bg-[#1B232E] text-white font-bold text-xs cursor-pointer transition shrink-0">
                    Kirim Pengajuan (Submit)
                </button>
            </form>
        </div>
    @endif
</div>
@endsection
