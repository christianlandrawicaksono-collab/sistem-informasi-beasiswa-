<?php

namespace App\Http\Controllers;

use App\Models\ProfilMahasiswa;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function showLogin(): View
    {
        return view('auth.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'login' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        // Cek apakah login menggunakan email atau username/NIM
        $fieldType = filter_var($credentials['login'], FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        if (Auth::attempt([$fieldType => $credentials['login'], 'password' => $credentials['password']], $request->boolean('remember'))) {
            $request->session()->regenerate();

            $user = Auth::user();

            return match ($user->role) {
                'admin' => redirect()->intended(route('admin.dashboard'))->with('success', 'Selamat datang kembali, Admin Kemahasiswaan!'),
                'reviewer' => redirect()->intended(route('reviewer.dashboard'))->with('success', 'Selamat datang, Tim Penyeleksi Beasiswa!'),
                default => redirect()->intended(route('mahasiswa.dashboard'))->with('success', 'Selamat datang di Portal Mahasiswa SCOLA!'),
            };
        }

        return back()->withErrors([
            'login' => 'Email/NIM atau password yang Anda masukkan salah.',
        ])->onlyInput('login');
    }

    public function showRegister(): View
    {
        return view('auth.register');
    }

    public function register(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'nim' => ['required', 'string', 'max:20', 'unique:users,username', 'unique:profil_mahasiswas,nim'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
            'fakultas' => ['nullable', 'string', 'max:100'],
            'prodi' => ['nullable', 'string', 'max:100'],
            'semester' => ['nullable', 'integer', 'min:1', 'max:14'],
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'username' => $validated['nim'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'mahasiswa',
        ]);

        ProfilMahasiswa::create([
            'user_id' => $user->id,
            'nim' => $validated['nim'],
            'nama_lengkap' => $validated['name'],
            'fakultas' => $validated['fakultas'] ?? 'Ilmu Komputer',
            'prodi' => $validated['prodi'] ?? 'Sistem Informasi',
            'semester' => $validated['semester'] ?? 1,
            'ipk' => 0.00,
            'penghasilan_ortu' => 0,
            'jumlah_tanggungan' => 0,
            'skor_prestasi' => 0,
        ]);

        Auth::login($user);

        return redirect()->route('mahasiswa.dashboard')->with('success', 'Registrasi berhasil! Silakan lengkapi profil dan data akademik Anda.');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('landing')->with('success', 'Anda telah berhasil keluar.');
    }
}
