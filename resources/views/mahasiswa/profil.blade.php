@extends('layouts.app')

@section('title', 'Profil & Data Akademik')

@section('content')
<div class="max-w-3xl mx-auto my-4">
    <div data-motion="hero-item" class="mb-6">
        <a href="{{ route('mahasiswa.dashboard') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-[#5B6573] hover:text-[#FF7448] transition mb-3">
            <svg class="size-3.5" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m12 19-7-7 7-7"/><path d="M19 12H5"/></svg>
            <span>Kembali ke Portal Mahasiswa</span>
        </a>
        <span class="nomu-label text-[#FF7448] block">Biodata &amp; Kriteria SAW</span>
        <h1 class="text-2xl sm:text-3xl font-extrabold text-[#0F151D]">Kelola Profil &amp; Data Akademik</h1>
        <p class="text-xs text-[#5B6573] mt-1">Data akademik dan kondisi ekonomi di bawah digunakan langsung sebagai parameter perhitungan SAW.</p>
    </div>

    <div data-motion="hero-item" class="nomu-panel p-6 sm:p-8">
        <form action="{{ route('mahasiswa.profil.update') }}" method="POST" class="space-y-7">
            @csrf
            @method('PUT')

            <div>
                <h2 class="nomu-label text-[#5B6573] mb-4 pb-2 border-b border-[#0F151D]/8">01 · Identitas Mahasiswa</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="prof-nama" class="block text-xs font-bold text-[#0F151D] mb-1.5">Nama Lengkap</label>
                        <input id="prof-nama" type="text" name="nama_lengkap" value="{{ old('nama_lengkap', $profil->nama_lengkap) }}" required class="w-full px-4 py-2.5 rounded-2xl border border-[#0F151D]/12 bg-[#FFF9F6]/60 focus:bg-white focus:border-[#FF7448] text-sm focus:outline-none">
                    </div>
                    <div>
                        <label for="prof-nim" class="block text-xs font-bold text-[#0F151D] mb-1.5">NIM</label>
                        <input id="prof-nim" type="text" value="{{ $profil->nim }}" disabled class="w-full px-4 py-2.5 rounded-2xl border border-[#0F151D]/8 bg-[#F1EBE9] text-[#5B6573] text-sm font-mono">
                    </div>
                    <div>
                        <label for="prof-fak" class="block text-xs font-bold text-[#0F151D] mb-1.5">Fakultas</label>
                        <input id="prof-fak" type="text" name="fakultas" value="{{ old('fakultas', $profil->fakultas) }}" required class="w-full px-4 py-2.5 rounded-2xl border border-[#0F151D]/12 bg-[#FFF9F6]/60 focus:bg-white focus:border-[#FF7448] text-sm focus:outline-none">
                    </div>
                    <div>
                        <label for="prof-prodi" class="block text-xs font-bold text-[#0F151D] mb-1.5">Program Studi</label>
                        <input id="prof-prodi" type="text" name="prodi" value="{{ old('prodi', $profil->prodi) }}" required class="w-full px-4 py-2.5 rounded-2xl border border-[#0F151D]/12 bg-[#FFF9F6]/60 focus:bg-white focus:border-[#FF7448] text-sm focus:outline-none">
                    </div>
                </div>
            </div>

            <div class="p-5 rounded-[22px] bg-[#E4EDFF]/45 border border-[#526991]/15">
                <h2 class="nomu-label text-[#243C61] mb-4 pb-2 border-b border-[#526991]/15">02 · Parameter Kriteria Seleksi (SAW)</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="prof-ipk" class="block text-xs font-bold text-[#0F151D] mb-1.5">IPK Terakhir (C1 · 40%)</label>
                        <input id="prof-ipk" type="number" step="0.01" min="0" max="4.00" name="ipk" value="{{ old('ipk', $profil->ipk) }}" required class="w-full px-4 py-2.5 rounded-2xl border border-[#0F151D]/12 bg-white text-sm font-mono focus:border-[#FF7448] focus:outline-none">
                        <p class="text-[11px] text-[#5B6573] mt-1">Skala 0.00 – 4.00 sesuai KHS</p>
                    </div>
                    <div>
                        <label for="prof-gaji" class="block text-xs font-bold text-[#0F151D] mb-1.5">Penghasilan Orang Tua (C2 · 30%)</label>
                        <input id="prof-gaji" type="number" step="1000" name="penghasilan_ortu" value="{{ old('penghasilan_ortu', (int)$profil->penghasilan_ortu) }}" required class="w-full px-4 py-2.5 rounded-2xl border border-[#0F151D]/12 bg-white text-sm font-mono focus:border-[#FF7448] focus:outline-none">
                        <p class="text-[11px] text-[#5B6573] mt-1">Total pendapatan bulanan (Rp)</p>
                    </div>
                    <div>
                        <label for="prof-tanggungan" class="block text-xs font-bold text-[#0F151D] mb-1.5">Jumlah Tanggungan (C3 · 20%)</label>
                        <input id="prof-tanggungan" type="number" name="jumlah_tanggungan" value="{{ old('jumlah_tanggungan', $profil->jumlah_tanggungan) }}" required min="0" max="15" class="w-full px-4 py-2.5 rounded-2xl border border-[#0F151D]/12 bg-white text-sm font-mono focus:border-[#FF7448] focus:outline-none">
                    </div>
                    <div>
                        <label for="prof-prestasi" class="block text-xs font-bold text-[#0F151D] mb-1.5">Skor Prestasi (C4 · 10%)</label>
                        <input id="prof-prestasi" type="number" step="1" min="0" max="100" name="skor_prestasi" value="{{ old('skor_prestasi', (int)$profil->skor_prestasi) }}" class="w-full px-4 py-2.5 rounded-2xl border border-[#0F151D]/12 bg-white text-sm font-mono focus:border-[#FF7448] focus:outline-none">
                    </div>
                </div>
            </div>

            <div>
                <h2 class="nomu-label text-[#5B6573] mb-4 pb-2 border-b border-[#0F151D]/8">03 · Kontak &amp; Domisili</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="prof-hp" class="block text-xs font-bold text-[#0F151D] mb-1.5">Nomor WhatsApp / HP</label>
                        <input id="prof-hp" type="text" name="no_hp" value="{{ old('no_hp', $profil->no_hp) }}" class="w-full px-4 py-2.5 rounded-2xl border border-[#0F151D]/12 bg-[#FFF9F6]/60 focus:bg-white text-sm focus:outline-none">
                    </div>
                    <div>
                        <label for="prof-sem" class="block text-xs font-bold text-[#0F151D] mb-1.5">Semester</label>
                        <input id="prof-sem" type="number" name="semester" value="{{ old('semester', $profil->semester) }}" min="1" max="14" class="w-full px-4 py-2.5 rounded-2xl border border-[#0F151D]/12 bg-[#FFF9F6]/60 focus:bg-white text-sm focus:outline-none">
                    </div>
                    <div class="sm:col-span-2">
                        <label for="prof-alamat" class="block text-xs font-bold text-[#0F151D] mb-1.5">Alamat Domisili</label>
                        <textarea id="prof-alamat" name="alamat" rows="2" class="w-full px-4 py-2.5 rounded-2xl border border-[#0F151D]/12 bg-[#FFF9F6]/60 focus:bg-white text-sm focus:outline-none">{{ old('alamat', $profil->alamat) }}</textarea>
                    </div>
                </div>
            </div>

            <div class="flex justify-end pt-4 border-t border-[#0F151D]/8">
                <button type="submit" data-motion="pill-press" class="nomu-cta-btn px-7 py-3 rounded-full font-bold text-sm cursor-pointer">
                    Simpan Perubahan Profil
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
