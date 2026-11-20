<?php

namespace App\Http\Controllers;

use App\Models\Beasiswa;
use App\Models\BerkasSyarat;
use App\Models\PengajuanBeasiswa;
use App\Models\ProfilMahasiswa;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class MahasiswaController extends Controller
{
    public function dashboard(): View
    {
        $user = Auth::user();
        $profil = $user->profilMahasiswa ?? ProfilMahasiswa::firstOrCreate(
            ['user_id' => $user->id],
            [
                'nim' => $user->username ?? '24.N2.0001',
                'nama_lengkap' => $user->name,
                'fakultas' => 'Ilmu Komputer',
                'prodi' => 'Sistem Informasi',
                'semester' => 1,
            ]
        );

        $pengajuanAktif = PengajuanBeasiswa::with(['beasiswa', 'berkas'])
            ->where('profil_id', $profil->id)
            ->latest()
            ->first();

        // Rekomendasi beasiswa berdasarkan IPK dan prodi
        $rekomendasi = Beasiswa::where('status', 'buka')
            ->where('ipk_minimal', '<=', $profil->ipk ?: 0)
            ->take(3)
            ->get();

        $semuaPengajuan = PengajuanBeasiswa::with('beasiswa')
            ->where('profil_id', $profil->id)
            ->latest()
            ->get();

        return view('mahasiswa.dashboard', compact('user', 'profil', 'pengajuanAktif', 'rekomendasi', 'semuaPengajuan'));
    }

    public function profil(): View
    {
        $user = Auth::user();
        $profil = $user->profilMahasiswa;

        return view('mahasiswa.profil', compact('user', 'profil'));
    }

    public function updateProfil(Request $request): RedirectResponse
    {
        $user = Auth::user();
        $profil = $user->profilMahasiswa;

        $validated = $request->validate([
            'nama_lengkap' => ['required', 'string', 'max:255'],
            'fakultas' => ['required', 'string', 'max:100'],
            'prodi' => ['required', 'string', 'max:100'],
            'semester' => ['required', 'integer', 'min:1', 'max:14'],
            'ipk' => ['required', 'numeric', 'min:0.00', 'max:4.00'],
            'penghasilan_ortu' => ['required', 'numeric', 'min:0'],
            'jumlah_tanggungan' => ['required', 'integer', 'min:0'],
            'skor_prestasi' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'alamat' => ['nullable', 'string'],
            'no_hp' => ['nullable', 'string', 'max:20'],
        ]);

        $profil->update($validated);
        $user->update(['name' => $validated['nama_lengkap']]);

        return back()->with('success', 'Profil dan data akademik berhasil diperbarui!');
    }

    public function ajukan(Beasiswa $beasiswa): RedirectResponse
    {
        $user = Auth::user();
        $profil = $user->profilMahasiswa;

        // Cek apakah sudah pernah mengajukan
        $sudahAda = PengajuanBeasiswa::where('profil_id', $profil->id)
            ->where('beasiswa_id', $beasiswa->id)
            ->exists();

        if ($sudahAda) {
            return back()->with('error', 'Anda sudah mengajukan pendaftaran untuk program beasiswa ini.');
        }

        $pengajuan = PengajuanBeasiswa::create([
            'profil_id' => $profil->id,
            'beasiswa_id' => $beasiswa->id,
            'nomor_pendaftaran' => 'SCL-' . date('Y') . '-' . strtoupper(Str::random(5)),
            'status_tahap' => 'draft',
            'tgl_pengajuan' => now(),
        ]);

        return redirect()->route('mahasiswa.berkas', $pengajuan->id)->with('success', 'Formulir pengajuan dibuat! Silakan unggah dokumen persyaratan.');
    }

    public function berkas(PengajuanBeasiswa $pengajuan): View
    {
        $this->authorizeAccess($pengajuan);
        $pengajuan->load(['beasiswa', 'berkas']);

        $dokumenWajib = [
            'Transkrip Nilai (KHS)',
            'Kartu Keluarga (KK)',
            'Slip Gaji Orang Tua / SKTM',
            'KTM / KTP',
            'Sertifikat Prestasi (Opsional)',
        ];

        return view('mahasiswa.berkas', compact('pengajuan', 'dokumenWajib'));
    }

    public function uploadBerkas(Request $request, PengajuanBeasiswa $pengajuan): RedirectResponse
    {
        $this->authorizeAccess($pengajuan);

        $request->validate([
            'nama_dokumen' => ['required', 'string'],
            'file' => ['required', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:3072'], // Max 3MB
        ]);

        $file = $request->file('file');
        $fileName = time() . '_' . Str::slug($request->nama_dokumen) . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs('berkas_beasiswa/' . $pengajuan->id, $fileName, 'public');

        // Update or create berkas
        BerkasSyarat::updateOrCreate(
            [
                'pengajuan_id' => $pengajuan->id,
                'nama_dokumen' => $request->nama_dokumen,
            ],
            [
                'file_path' => $path,
                'file_type' => $file->getClientOriginalExtension(),
                'file_size' => round($file->getSize() / 1024),
                'wajib' => !str_contains(strtolower($request->nama_dokumen), 'opsional'),
                'status_verifikasi' => 'pending',
                'catatan_verifikasi' => null,
            ]
        );

        return back()->with('success', 'Dokumen ' . $request->nama_dokumen . ' berhasil diunggah!');
    }

    public function submitFinal(PengajuanBeasiswa $pengajuan): RedirectResponse
    {
        $this->authorizeAccess($pengajuan);

        $pengajuan->update([
            'status_tahap' => 'submitted',
            'tgl_pengajuan' => now(),
        ]);

        return redirect()->route('mahasiswa.dashboard')->with('success', 'Pengajuan beasiswa berhasil dikirim! Berkas Anda akan segera diverifikasi tim.');
    }

    private function authorizeAccess(PengajuanBeasiswa $pengajuan): void
    {
        $profil = Auth::user()->profilMahasiswa;
        if ($pengajuan->profil_id !== $profil->id) {
            abort(403, 'Akses tidak sah ke berkas pengajuan ini.');
        }
    }
}
