@extends('layouts.app')

@section('title', 'Tambah Program Beasiswa')

@section('content')
<div class="max-w-3xl mx-auto my-6">
    <div class="mb-6">
        <a href="{{ route('admin.dashboard') }}" class="text-xs font-bold text-amber-600 hover:underline flex items-center space-x-1 mb-2">
            <i class="fa-solid fa-arrow-left"></i>
            <span>Kembali ke Dashboard Admin</span>
        </a>
        <h1 class="text-2xl font-extrabold text-slate-900">Tambah Program Beasiswa Baru</h1>
        <p class="text-xs text-slate-500">Publikasikan beasiswa internal atau eksternal untuk mahasiswa UNIKA.</p>
    </div>

    <div class="bg-white p-6 sm:p-8 rounded-3xl border border-slate-200 shadow-sm">
        <form action="{{ route('admin.beasiswa.store') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Nama Program Beasiswa</label>
                <input type="text" name="nama_program" required placeholder="Contoh: Beasiswa Prestasi Akademik 2026" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Kategori</label>
                    <select name="kategori" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm">
                        <option value="Prestasi Akademik">Prestasi Akademik</option>
                        <option value="Bantuan Ekonomi">Bantuan Ekonomi</option>
                        <option value="Eksternal">Beasiswa Eksternal</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Instansi Penyelenggara</label>
                    <input type="text" name="penyelenggara" required placeholder="Contoh: UNIKA Soegijapranata / Djarum" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Kuota Penerima</label>
                    <input type="number" name="kuota" required min="1" value="10" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Minimal IPK</label>
                    <input type="number" step="0.01" name="ipk_minimal" required min="0" max="4.00" value="3.00" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Tanggal Tutup</label>
                    <input type="date" name="tgl_tutup" required value="{{ now()->addMonths(1)->toDateString() }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm">
                    <input type="hidden" name="tgl_buka" value="{{ now()->toDateString() }}">
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Deskripsi Singkat</label>
                <textarea name="deskripsi" rows="3" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm" placeholder="Jelaskan manfaat dan tujuan beasiswa..."></textarea>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Persyaratan & Ketentuan Dokumen</label>
                <textarea name="persyaratan" rows="3" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm" placeholder="1. Mahasiswa aktif semester 2-6&#10;2. Melampirkan KHS dan slip gaji..."></textarea>
            </div>

            <div class="flex justify-end pt-4 border-t border-slate-100">
                <button type="submit" class="px-6 py-2.5 bg-amber-500 hover:bg-amber-600 text-white font-bold rounded-xl text-sm transition shadow-sm shadow-amber-200">
                    Simpan & Terbitkan Beasiswa
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
