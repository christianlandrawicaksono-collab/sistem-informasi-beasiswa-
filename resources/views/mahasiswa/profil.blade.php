@extends('layouts.app')

@section('title', 'Profil & Data Akademik')

@section('content')
<div class="max-w-3xl mx-auto my-6">
    <div class="mb-6 flex items-center justify-between">
        <div>
            <a href="{{ route('mahasiswa.dashboard') }}" class="text-xs font-bold text-amber-600 hover:underline flex items-center space-x-1 mb-2">
                <i class="fa-solid fa-arrow-left"></i>
                <span>Kembali ke Dashboard</span>
            </a>
            <h1 class="text-2xl font-extrabold text-slate-900">Kelola Profil & Data Akademik</h1>
            <p class="text-xs text-slate-500">Data ini digunakan untuk penilaian kriteria Simple Additive Weighting (SAW).</p>
        </div>
    </div>

    <div class="bg-white p-6 sm:p-8 rounded-3xl border border-slate-200 shadow-sm">
        <form action="{{ route('mahasiswa.profil.update') }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Bagian 1: Identitas Mahasiswa -->
            <div>
                <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-4 pb-2 border-b border-slate-100 flex items-center space-x-1.5">
                    <i class="fa-solid fa-id-card text-amber-500"></i>
                    <span>Identitas Mahasiswa</span>
                </h3>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Nama Lengkap</label>
                        <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap', $profil->nama_lengkap) }}" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">NIM (Tidak dapat diubah)</label>
                        <input type="text" value="{{ $profil->nim }}" disabled class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-100 text-slate-500 text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Fakultas</label>
                        <input type="text" name="fakultas" value="{{ old('fakultas', $profil->fakultas) }}" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Program Studi</label>
                        <input type="text" name="prodi" value="{{ old('prodi', $profil->prodi) }}" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm">
                    </div>
                </div>
            </div>

            <!-- Bagian 2: Kriteria Penilaian SAW -->
            <div>
                <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-4 pb-2 border-b border-slate-100 flex items-center space-x-1.5">
                    <i class="fa-solid fa-chart-pie text-amber-500"></i>
                    <span>Parameter Kriteria Seleksi (SAW)</span>
                </h3>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                            IPK Terakhir (C1 - 40%)
                        </label>
                        <input type="number" step="0.01" min="0" max="4.00" name="ipk" value="{{ old('ipk', $profil->ipk) }}" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm">
                        <p class="text-[11px] text-slate-400 mt-1">Skala 0.00 - 4.00 sesuai KHS</p>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                            Penghasilan Orang Tua (C2 - 30%)
                        </label>
                        <input type="number" step="1000" name="penghasilan_ortu" value="{{ old('penghasilan_ortu', (int)$profil->penghasilan_ortu) }}" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm">
                        <p class="text-[11px] text-slate-400 mt-1">Total penghasilan per bulan (Rp)</p>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                            Jumlah Tanggungan (C3 - 20%)
                        </label>
                        <input type="number" name="jumlah_tanggungan" value="{{ old('jumlah_tanggungan', $profil->jumlah_tanggungan) }}" required min="0" max="15" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm">
                        <p class="text-[11px] text-slate-400 mt-1">Jumlah anggota keluarga tanggungan</p>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                            Skor Prestasi (C4 - 10%)
                        </label>
                        <input type="number" step="1" min="0" max="100" name="skor_prestasi" value="{{ old('skor_prestasi', (int)$profil->skor_prestasi) }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm">
                        <p class="text-[11px] text-slate-400 mt-1">Skor bobot sertifikat prestasi (0-100)</p>
                    </div>
                </div>
            </div>

            <!-- Bagian 3: Kontak & Alamat -->
            <div>
                <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-4 pb-2 border-b border-slate-100 flex items-center space-x-1.5">
                    <i class="fa-solid fa-address-book text-amber-500"></i>
                    <span>Kontak & Alamat</span>
                </h3>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Nomor WhatsApp / HP</label>
                        <input type="text" name="no_hp" value="{{ old('no_hp', $profil->no_hp) }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Semester</label>
                        <input type="number" name="semester" value="{{ old('semester', $profil->semester) }}" min="1" max="14" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm">
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Alamat Domisili</label>
                        <textarea name="alamat" rows="2" class="w-full px-4 py-2 rounded-xl border border-slate-200 text-sm">{{ old('alamat', $profil->alamat) }}</textarea>
                    </div>
                </div>
            </div>

            <div class="flex justify-end pt-4 border-t border-slate-100">
                <button type="submit" class="px-6 py-2.5 bg-amber-500 hover:bg-amber-600 text-white font-bold rounded-xl text-sm transition shadow-sm shadow-amber-200">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
