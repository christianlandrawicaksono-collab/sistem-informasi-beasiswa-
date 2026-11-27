@extends('layouts.app')

@section('title', 'Masuk ke SCOLA')

@section('content')
<div class="max-w-md mx-auto my-8 sm:my-12">
    <div data-motion="hero-item" class="nomu-panel p-2">
        <div class="bg-white rounded-[26px] p-6 sm:p-8 border border-[#0F151D]/6">
            <div class="text-center mb-7">
                <div class="size-12 rounded-2xl bg-linear-to-tr from-[#F13F07] to-[#FF7448] flex items-center justify-center text-white mx-auto mb-4 shadow-md">
                    <svg class="size-5" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/>
                        <polyline points="10 17 15 12 10 7"/>
                        <line x1="15" x2="3" y1="12" y2="12"/>
                    </svg>
                </div>
                <span class="nomu-label text-[#FF7448] block mb-1">Single Gate Access</span>
                <h1 class="text-2xl font-extrabold text-[#0F151D]">Masuk ke Akun Anda</h1>
                <p class="text-xs text-[#5B6573] mt-1">Gunakan Email institusi atau NIM terdaftar Anda</p>
            </div>

            <form action="{{ route('login') }}" method="POST" class="space-y-4">
                @csrf

                <div>
                    <label for="login-input" class="nomu-label text-[#0F151D] block mb-1.5">Email atau NIM</label>
                    <input id="login-input" type="text" name="login" value="{{ old('login') }}" required placeholder="24.N2.0003 atau email@unika.ac.id" class="w-full px-4 py-3 rounded-2xl border border-[#0F151D]/12 bg-[#FFF9F6]/60 focus:bg-white focus:border-[#FF7448] focus:ring-2 focus:ring-[#FF7448]/20 text-sm transition focus:outline-none">
                    @error('login')
                        <p class="text-xs text-[#B83209] mt-1.5 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password-input" class="nomu-label text-[#0F151D] block mb-1.5">Password</label>
                    <input id="password-input" type="password" name="password" required placeholder="••••••••" class="w-full px-4 py-3 rounded-2xl border border-[#0F151D]/12 bg-[#FFF9F6]/60 focus:bg-white focus:border-[#FF7448] focus:ring-2 focus:ring-[#FF7448]/20 text-sm transition focus:outline-none">
                    @error('password')
                        <p class="text-xs text-[#B83209] mt-1.5 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-between text-xs pt-1">
                    <label class="flex items-center gap-2 text-[#5B6573] cursor-pointer">
                        <input type="checkbox" name="remember" class="rounded border-[#0F151D]/20 text-[#FF7448] focus:ring-[#FF7448]">
                        <span>Ingat saya</span>
                    </label>
                </div>

                <button type="submit" data-motion="pill-press" class="w-full py-3.5 rounded-full nomu-cta-btn font-bold text-sm cursor-pointer mt-2">
                    Masuk ke Portal
                </button>
            </form>

            <!-- Quick Fill Demo Login -->
            <div class="mt-7 pt-6 border-t border-[#0F151D]/8">
                <p class="nomu-label text-[#5B6573] text-center mb-3">Akun Demo (1-Klik Isi Otomatis)</p>
                <div class="grid grid-cols-3 gap-2 text-xs">
                    <button type="button" onclick="fillLogin('christian@student.unika.ac.id', 'password')" class="py-2.5 px-2 text-center rounded-full bg-[#E5F3EE] text-[#237C65] hover:brightness-95 transition font-semibold cursor-pointer">
                        Mahasiswa
                    </button>
                    <button type="button" onclick="fillLogin('admin@unika.ac.id', 'password')" class="py-2.5 px-2 text-center rounded-full bg-[#E4EDFF] text-[#243C61] hover:brightness-95 transition font-semibold cursor-pointer">
                        Admin
                    </button>
                    <button type="button" onclick="fillLogin('reviewer@unika.ac.id', 'password')" class="py-2.5 px-2 text-center rounded-full bg-[#FFEAE3] text-[#B83209] hover:brightness-95 transition font-semibold cursor-pointer">
                        Reviewer
                    </button>
                </div>
            </div>

            <p class="text-center text-xs text-[#5B6573] mt-6">
                Belum punya akun mahasiswa?
                <a href="{{ route('register') }}" class="font-bold text-[#FF7448] hover:underline">Daftar Sekarang</a>
            </p>
        </div>
    </div>
</div>

<script>
    function fillLogin(email, pass) {
        document.getElementById('login-input').value = email;
        document.getElementById('password-input').value = pass;
    }
</script>
@endsection
