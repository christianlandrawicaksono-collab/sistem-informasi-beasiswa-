@extends('layouts.app')

@section('title', 'Masuk ke SCOLA')

@section('content')
<div class="max-w-md mx-auto my-8">
    <div class="bg-white rounded-3xl p-8 border border-slate-200 shadow-sm">
        <div class="text-center mb-6">
            <div class="w-12 h-12 rounded-2xl bg-gradient-to-tr from-amber-500 to-yellow-400 flex items-center justify-center text-white mx-auto mb-3 shadow-md shadow-amber-200">
                <i class="fa-solid fa-right-to-bracket text-xl"></i>
            </div>
            <h2 class="text-2xl font-extrabold text-slate-900">Masuk ke Akun Anda</h2>
            <p class="text-xs text-slate-500 mt-1">Gunakan Email atau NIM terdaftar Anda</p>
        </div>

        <form action="{{ route('login') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Email atau NIM</label>
                <input type="text" name="login" value="{{ old('login') }}" required placeholder="contoh: 24.N2.0003 atau email" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-amber-500 focus:ring-2 focus:ring-amber-200 text-sm">
                @error('login')
                    <p class="text-xs text-rose-500 mt-1 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Password</label>
                <input type="password" name="password" required placeholder="••••••••" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-amber-500 focus:ring-2 focus:ring-amber-200 text-sm">
                @error('password')
                    <p class="text-xs text-rose-500 mt-1 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-between text-xs">
                <label class="flex items-center space-x-2 text-slate-600">
                    <input type="checkbox" name="remember" class="rounded text-amber-500 focus:ring-amber-400">
                    <span>Ingat Saya</span>
                </label>
            </div>

            <button type="submit" class="w-full py-3 bg-amber-500 hover:bg-amber-600 text-white font-bold rounded-xl text-sm transition shadow-sm shadow-amber-200">
                Masuk
            </button>
        </form>

        <!-- Quick Fill Demo Login for Presentation / Testing -->
        <div class="mt-8 pt-6 border-t border-slate-100">
            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider text-center mb-3">Akun Demo (Klik untuk Otomatis Isi):</p>
            <div class="grid grid-cols-3 gap-2 text-xs">
                <button type="button" onclick="fillLogin('christian@student.unika.ac.id', 'password')" class="p-2 text-center rounded-lg bg-emerald-50 text-emerald-700 border border-emerald-200 hover:bg-emerald-100 transition font-medium">
                    Mahasiswa
                </button>
                <button type="button" onclick="fillLogin('admin@unika.ac.id', 'password')" class="p-2 text-center rounded-lg bg-purple-50 text-purple-700 border border-purple-200 hover:bg-purple-100 transition font-medium">
                    Admin
                </button>
                <button type="button" onclick="fillLogin('reviewer@unika.ac.id', 'password')" class="p-2 text-center rounded-lg bg-blue-50 text-blue-700 border border-blue-200 hover:bg-blue-100 transition font-medium">
                    Reviewer
                </button>
            </div>
        </div>

        <p class="text-center text-xs text-slate-500 mt-6">
            Belum punya akun mahasiswa? 
            <a href="{{ route('register') }}" class="font-bold text-amber-600 hover:underline">Daftar Sekarang</a>
        </p>
    </div>
</div>

<script>
    function fillLogin(email, pass) {
        document.querySelector('input[name="login"]').value = email;
        document.querySelector('input[name="password"]').value = pass;
    }
</script>
@endsection
