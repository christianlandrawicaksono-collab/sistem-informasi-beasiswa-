@extends('layouts.app')

@section('title', 'Registrasi Mahasiswa')

@section('content')
<div class="max-w-lg mx-auto my-8 sm:my-10">
    <div data-motion="hero-item" class="nomu-panel p-2">
        <div class="bg-white rounded-[26px] p-6 sm:p-8 border border-[#0F151D]/6">
            <div class="text-center mb-7">
                <span class="nomu-label text-[#FF7448] block mb-1">Akun Pendaftar Baru</span>
                <h1 class="text-2xl font-extrabold text-[#0F151D]">Registrasi Mahasiswa UNIKA</h1>
                <p class="text-xs text-[#5B6573] mt-1">Buat akun untuk mengajukan beasiswa dan mengunggah berkas</p>
            </div>

            <form action="{{ route('register') }}" method="POST" class="space-y-4">
                @csrf

                <div>
                    <label for="reg-name" class="nomu-label text-[#0F151D] block mb-1.5">Nama Lengkap</label>
                    <input id="reg-name" type="text" name="name" value="{{ old('name') }}" required placeholder="Nama lengkap sesuai KTM" class="w-full px-4 py-2.5 rounded-2xl border border-[#0F151D]/12 bg-[#FFF9F6]/60 focus:bg-white focus:border-[#FF7448] text-sm focus:outline-none">
                    @error('name') <p class="text-xs text-[#B83209] mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label for="reg-nim" class="nomu-label text-[#0F151D] block mb-1.5">NIM</label>
                        <input id="reg-nim" type="text" name="nim" value="{{ old('nim') }}" required placeholder="Contoh: 24.N2.0003" class="w-full px-4 py-2.5 rounded-2xl border border-[#0F151D]/12 bg-[#FFF9F6]/60 focus:bg-white focus:border-[#FF7448] text-sm font-mono focus:outline-none">
                        @error('nim') <p class="text-xs text-[#B83209] mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="reg-sem" class="nomu-label text-[#0F151D] block mb-1.5">Semester</label>
                        <input id="reg-sem" type="number" name="semester" value="{{ old('semester', 1) }}" min="1" max="14" class="w-full px-4 py-2.5 rounded-2xl border border-[#0F151D]/12 bg-[#FFF9F6]/60 focus:bg-white focus:border-[#FF7448] text-sm focus:outline-none">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label for="reg-fak" class="nomu-label text-[#0F151D] block mb-1.5">Fakultas</label>
                        <input id="reg-fak" type="text" name="fakultas" value="{{ old('fakultas', 'Ilmu Komputer') }}" class="w-full px-4 py-2.5 rounded-2xl border border-[#0F151D]/12 bg-[#FFF9F6]/60 focus:bg-white focus:border-[#FF7448] text-sm focus:outline-none">
                    </div>
                    <div>
                        <label for="reg-prodi" class="nomu-label text-[#0F151D] block mb-1.5">Program Studi</label>
                        <input id="reg-prodi" type="text" name="prodi" value="{{ old('prodi', 'Sistem Informasi') }}" class="w-full px-4 py-2.5 rounded-2xl border border-[#0F151D]/12 bg-[#FFF9F6]/60 focus:bg-white focus:border-[#FF7448] text-sm focus:outline-none">
                    </div>
                </div>

                <div>
                    <label for="reg-email" class="nomu-label text-[#0F151D] block mb-1.5">Email Mahasiswa</label>
                    <input id="reg-email" type="email" name="email" value="{{ old('email') }}" required placeholder="nim@student.unika.ac.id" class="w-full px-4 py-2.5 rounded-2xl border border-[#0F151D]/12 bg-[#FFF9F6]/60 focus:bg-white focus:border-[#FF7448] text-sm focus:outline-none">
                    @error('email') <p class="text-xs text-[#B83209] mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label for="reg-pass" class="nomu-label text-[#0F151D] block mb-1.5">Password</label>
                        <input id="reg-pass" type="password" name="password" required placeholder="Min. 6 karakter" class="w-full px-4 py-2.5 rounded-2xl border border-[#0F151D]/12 bg-[#FFF9F6]/60 focus:bg-white focus:border-[#FF7448] text-sm focus:outline-none">
                    </div>
                    <div>
                        <label for="reg-pass2" class="nomu-label text-[#0F151D] block mb-1.5">Konfirmasi</label>
                        <input id="reg-pass2" type="password" name="password_confirmation" required placeholder="Ulangi password" class="w-full px-4 py-2.5 rounded-2xl border border-[#0F151D]/12 bg-[#FFF9F6]/60 focus:bg-white focus:border-[#FF7448] text-sm focus:outline-none">
                    </div>
                </div>
                @error('password') <p class="text-xs text-[#B83209]">{{ $message }}</p> @enderror

                <button type="submit" data-motion="pill-press" class="w-full py-3.5 rounded-full nomu-cta-btn font-bold text-sm cursor-pointer mt-2">
                    Daftar Akun Mahasiswa
                </button>
            </form>

            <p class="text-center text-xs text-[#5B6573] mt-6">
                Sudah memiliki akun?
                <a href="{{ route('login') }}" class="font-bold text-[#FF7448] hover:underline">Masuk di sini</a>
            </p>
        </div>
    </div>
</div>
@endsection
