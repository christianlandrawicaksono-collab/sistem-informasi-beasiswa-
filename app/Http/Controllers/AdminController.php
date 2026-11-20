<?php

namespace App\Http\Controllers;

use App\Models\Beasiswa;
use App\Models\BerkasSyarat;
use App\Models\KriteriaPenilaian;
use App\Models\PengajuanBeasiswa;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminController extends Controller
{
    public function dashboard(): View
    {
        $totalPelamar = PengajuanBeasiswa::count();
        $perluVerifikasi = BerkasSyarat::where('status_verifikasi', 'pending')->count();
        $terverifikasi = PengajuanBeasiswa::whereIn('status_tahap', ['verifikasi_berkas', 'seleksi_saw', 'diterima'])->count();
        $totalKuota = Beasiswa::where('status', 'buka')->sum('kuota');

        $pelamars = PengajuanBeasiswa::with(['profil.user', 'beasiswa', 'berkas'])
            ->latest()
            ->paginate(10);

        $beasiswas = Beasiswa::withCount('pengajuan')->get();

        return view('admin.dashboard', compact('totalPelamar', 'perluVerifikasi', 'terverifikasi', 'totalKuota', 'pelamars', 'beasiswas'));
    }

    public function beasiswaIndex(): View
    {
        $beasiswas = Beasiswa::with('kriteria')->withCount('pengajuan')->latest()->paginate(10);
        return view('admin.beasiswa.index', compact('beasiswas'));
    }

    public function beasiswaCreate(): View
    {
        return view('admin.beasiswa.create');
    }

    public function beasiswaStore(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nama_program' => ['required', 'string', 'max:255'],
            'kategori' => ['required', 'string'],
            'penyelenggara' => ['required', 'string'],
            'kuota' => ['required', 'integer', 'min:1'],
            'tgl_buka' => ['required', 'date'],
            'tgl_tutup' => ['required', 'date', 'after_or_equal:tgl_buka'],
            'ipk_minimal' => ['required', 'numeric', 'min:0', 'max:4'],
            'deskripsi' => ['nullable', 'string'],
            'persyaratan' => ['nullable', 'string'],
        ]);

        $beasiswa = Beasiswa::create($validated);

        // Standar default kriteria SAW untuk beasiswa baru
        $defaultKriteria = [
            ['kode' => 'C1', 'nama' => 'IPK', 'bobot' => 40.00, 'sifat' => 'benefit'],
            ['kode' => 'C2', 'nama' => 'Penghasilan Orang Tua', 'bobot' => 30.00, 'sifat' => 'cost'],
            ['kode' => 'C3', 'nama' => 'Jumlah Tanggungan', 'bobot' => 20.00, 'sifat' => 'benefit'],
            ['kode' => 'C4', 'nama' => 'Skor Prestasi', 'bobot' => 10.00, 'sifat' => 'benefit'],
        ];

        foreach ($defaultKriteria as $k) {
            KriteriaPenilaian::create([
                'beasiswa_id' => $beasiswa->id,
                'kode_kriteria' => $k['kode'],
                'nama_kriteria' => $k['nama'],
                'bobot' => $k['bobot'],
                'sifat' => $k['sifat'],
            ]);
        }

        return redirect()->route('admin.beasiswa.index')->with('success', 'Program beasiswa berhasil ditambahkan!');
    }

    public function verifikasiBerkas(PengajuanBeasiswa $pengajuan): View
    {
        $pengajuan->load(['profil.user', 'beasiswa', 'berkas']);
        return view('admin.verifikasi', compact('pengajuan'));
    }

    public function updateStatusBerkas(Request $request, BerkasSyarat $berkas): RedirectResponse
    {
        $request->validate([
            'status_verifikasi' => ['required', 'in:valid,perlu_revisi,ditolak'],
            'catatan_verifikasi' => ['nullable', 'string'],
        ]);

        $berkas->update([
            'status_verifikasi' => $request->status_verifikasi,
            'catatan_verifikasi' => $request->catatan_verifikasi,
        ]);

        // Cek kelengkapan pengajuan: jika semua berkas wajib valid, naikkan status pengajuan ke 'verifikasi_berkas'
        $pengajuan = $berkas->pengajuan;
        $semuaWajib = $pengajuan->berkas()->where('wajib', true)->get();
        $semuaValid = $semuaWajib->count() > 0 && $semuaWajib->every(fn($b) => $b->status_verifikasi === 'valid');

        if ($semuaValid) {
            $pengajuan->update(['status_tahap' => 'verifikasi_berkas']);
        }

        return back()->with('success', 'Status berkas ' . $berkas->nama_dokumen . ' berhasil diperbarui!');
    }

    public function tetapkanStatus(Request $request, PengajuanBeasiswa $pengajuan): RedirectResponse
    {
        $request->validate([
            'status_tahap' => ['required', 'in:diterima,ditolak,seleksi_saw'],
            'catatan_admin' => ['nullable', 'string'],
        ]);

        $pengajuan->update([
            'status_tahap' => $request->status_tahap,
            'catatan_admin' => $request->catatan_admin,
        ]);

        return back()->with('success', 'Status kelulusan pelamar berhasil diperbarui menjadi: ' . strtoupper($request->status_tahap));
    }
}
