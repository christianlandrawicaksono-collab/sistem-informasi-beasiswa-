@extends('layouts.app')

@section('title', 'Tambah Program Beasiswa')

@section('content')
<div class="max-w-3xl mx-auto my-4">
    <div data-motion="hero-item" class="mb-6">
        <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-[#5B6573] hover:text-[#FF7448] transition mb-3">
            <svg class="size-3.5" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="m12 19-7-7 7-7"/><path d="M19 12H5"/></svg>
            <span>Kembali ke Dashboard Admin</span>
        </a>
        <span class="nomu-label text-[#FF7448] block">Publikasi Program</span>
        <h1 class="text-2xl sm:text-3xl font-extrabold text-[#0F151D]">Tambah Program Beasiswa Baru</h1>
        <p class="text-xs text-[#5B6573] mt-1">Program baru akan otomatis dilengkapi bobot standar kriteria SAW (IPK, Gaji, Tanggungan, Prestasi).</p>
    </div>

    <div data-motion="hero-item" class="nomu-panel p-6 sm:p-8">
        <form action="{{ route('admin.beasiswa.store') }}" method="POST" class="space-y-5">
            @csrf

            <div>
                <label for="b-nama" class="nomu-label text-[#0F151D] block mb-1.5">Nama Program Beasiswa</label>
                <input id="b-nama" type="text" name="nama_program" required placeholder="Contoh: Beasiswa Prestasi Akademik 2026" class="w-full px-4 py-3 rounded-2xl border border-[#0F151D]/12 bg-[#FFF9F6]/60 focus:bg-white focus:border-[#FF7448] text-sm focus:outline-none">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="b-kat" class="nomu-label text-[#0F151D] block mb-1.5">Kategori</label>
                    <select id="b-kat" name="kategori" required class="w-full px-4 py-3 rounded-2xl border border-[#0F151D]/12 bg-[#FFF9F6]/60 focus:bg-white text-sm focus:outline-none">
                        <option value="Prestasi Akademik">Prestasi Akademik</option>
                        <option value="Bantuan Ekonomi">Bantuan Ekonomi</option>
                        <option value="Eksternal">Beasiswa Eksternal</option>
                    </select>
                </div>
                <div>
                    <label for="b-penyelenggara" class="nomu-label text-[#0F151D] block mb-1.5">Instansi Penyelenggara</label>
                    <input id="b-penyelenggara" type="text" name="penyelenggara" required placeholder="UNIKA Soegijapranata / Djarum" class="w-full px-4 py-3 rounded-2xl border border-[#0F151D]/12 bg-[#FFF9F6]/60 focus:bg-white text-sm focus:outline-none">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label for="b-kuota" class="nomu-label text-[#0F151D] block mb-1.5">Kuota Penerima</label>
                    <input id="b-kuota" type="number" name="kuota" required min="1" value="10" class="w-full px-4 py-3 rounded-2xl border border-[#0F151D]/12 bg-[#FFF9F6]/60 text-sm font-mono focus:outline-none">
                </div>
                <div>
                    <label for="b-ipk" class="nomu-label text-[#0F151D] block mb-1.5">Minimal IPK</label>
                    <input id="b-ipk" type="number" step="0.01" name="ipk_minimal" required min="0" max="4.00" value="3.00" class="w-full px-4 py-3 rounded-2xl border border-[#0F151D]/12 bg-[#FFF9F6]/60 text-sm font-mono focus:outline-none">
                </div>
                <div>
                    <label for="b-tutup" class="nomu-label text-[#0F151D] block mb-1.5">Tanggal Tutup</label>
                    <input id="b-tutup" type="date" name="tgl_tutup" required value="{{ now()->addMonths(1)->toDateString() }}" class="w-full px-4 py-3 rounded-2xl border border-[#0F151D]/12 bg-[#FFF9F6]/60 text-sm font-mono focus:outline-none">
                    <input type="hidden" name="tgl_buka" value="{{ now()->toDateString() }}">
                </div>
            </div>

            <div>
                <label for="b-desc" class="nomu-label text-[#0F151D] block mb-1.5">Deskripsi Singkat</label>
                <textarea id="b-desc" name="deskripsi" rows="3" class="w-full px-4 py-3 rounded-2xl border border-[#0F151D]/12 bg-[#FFF9F6]/60 focus:bg-white text-sm focus:outline-none" placeholder="Jelaskan manfaat dan tujuan program beasiswa..."></textarea>
            </div>

            <div>
                <label for="b-syarat" class="nomu-label text-[#0F151D] block mb-1.5">Persyaratan &amp; Ketentuan Dokumen</label>
                <textarea id="b-syarat" name="persyaratan" rows="3" class="w-full px-4 py-3 rounded-2xl border border-[#0F151D]/12 bg-[#FFF9F6]/60 focus:bg-white text-sm focus:outline-none" placeholder="1. Mahasiswa aktif semester 2-6&#10;2. Melampirkan KHS dan slip gaji..."></textarea>
            </div>

            <div class="flex justify-end pt-4 border-t border-[#0F151D]/8">
                <button type="submit" data-motion="pill-press" class="nomu-cta-btn px-7 py-3 rounded-full font-bold text-sm cursor-pointer">
                    Simpan &amp; Terbitkan Beasiswa
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
