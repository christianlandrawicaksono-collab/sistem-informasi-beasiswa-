@extends('layouts.app')

@section('title', 'Registrasi Mahasiswa')

@section('content')
<div class="max-w-lg mx-auto my-8">
    <div class="bg-white rounded-3xl p-8 border border-slate-200 shadow-sm">
        <div class="text-center mb-6">
            <div class="w-12 h-12 rounded-2xl bg-gradient-to-tr from-amber-500 to-yellow-400 flex items-center justify-center text-white mx-auto mb-3 shadow-md shadow-amber-200">
                <i class="fa-solid fa-user-plus text-xl"></i>
            </div>
            <h2 class="text-2xl font-extrabold text-slate-900">Registrasi Mahasiswa</h2>
            <p class="text-xs text-slate-500 mt-1">Daftarkan akun untuk mengajukan beasiswa UNIKA</p>
        </div>

        <form action="{{ route('register') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Nama Lengkap</label>
                <input type="text" name="name" value="{{ old('name') }}" required placeholder="Nama lengkap sesuai KTM" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-amber-500 focus:ring-2 focus:ring-amber-200 text-sm">
                @error('name') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">NIM</label>
                    <input type="text" name="nim" value="{{ old('nim') }}" required placeholder="Contoh: 24.N2.0003" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-amber-500 focus:ring-2 focus:ring-amber-200 text-sm">
                    @error('nim') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Semester</label>
                    <input type="number" name="semester" value="{{ old('semester', 1) }}" min="1" max="14" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-amber-500 focus:ring-2 focus:ring-amber-200 text-sm">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Fakultas</label>
                    <input type="text" name="fakultas" value="{{ old('fakultas', 'Ilmu Komputer') }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-amber-500 focus:ring-2 focus:ring-amber-200 text-sm">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Program Studi</label>
                    <input type="text" name="prodi" value="{{ old('prodi', 'Sistem Informasi') }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-amber-500 focus:ring-2 focus:ring-amber-200 text-sm">
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Email Mahasiswa</label>
                <input type="email" name="email" value="{{ old('email') }}" required placeholder="nim@student.unika.ac.id" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-amber-500 focus:ring-2 focus:ring-amber-200 text-sm">
                @error('email') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Password</label>
                    <input type="password" name="password" required placeholder="Minimal 6 karakter" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-amber-500 focus:ring-2 focus:ring-amber-200 text-sm">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" required placeholder="Ulangi password" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-amber-500 focus:ring-2 focus:ring-amber-200 text-sm">
                </div>
            </div>
            @error('password') <p class="text-xs text-rose-500">{{ $message }}</p> @enderror

            <button type="submit" class="w-full py-3 bg-amber-500 hover:bg-amber-600 text-white font-bold rounded-xl text-sm transition shadow-sm shadow-amber-200 mt-2">
                Daftar Akun Mahasiswa
            </button>
        </form>

        <p class="text-center text-xs text-slate-500 mt-6">
            Sudah memiliki akun? 
            <a href="{{ route('login') }}" class="font-bold text-amber-600 hover:underline">Masuk di sini</a>
        </p>
    </div>
</div>
@endsection
