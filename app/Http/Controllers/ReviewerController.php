<?php

namespace App\Http\Controllers;

use App\Models\Beasiswa;
use App\Models\PengajuanBeasiswa;
use App\Models\PenilaianSaw;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ReviewerController extends Controller
{
    public function dashboard(): View
    {
        $beasiswas = Beasiswa::with('kriteria')->where('status', 'buka')->get();
        $beasiswaDipilih = $beasiswas->first();

        $ranking = [];
        if ($beasiswaDipilih) {
            $ranking = PengajuanBeasiswa::with(['profil.user', 'penilaianSaw.kriteria'])
                ->where('beasiswa_id', $beasiswaDipilih->id)
                ->whereNotNull('total_skor_saw')
                ->orderBy('total_skor_saw', 'desc')
                ->get();
        }

        return view('reviewer.dashboard', compact('beasiswas', 'beasiswaDipilih', 'ranking'));
    }

    /**
     * Algoritma Perangkingan Simple Additive Weighting (SAW)
     */
    public function hitungSaw(Beasiswa $beasiswa): RedirectResponse
    {
        $beasiswa->load('kriteria');
        $kriterias = $beasiswa->kriteria;

        // Ambil semua pelamar yang minimal sudah diverifikasi berkasnya atau sedang diseleksi
        $pelamars = PengajuanBeasiswa::with('profil')
            ->where('beasiswa_id', $beasiswa->id)
            ->whereIn('status_tahap', ['submitted', 'verifikasi_berkas', 'seleksi_saw'])
            ->get();

        if ($pelamars->isEmpty()) {
            return back()->with('error', 'Belum ada data pelamar yang siap dihitung untuk beasiswa ini.');
        }

        // 1. Siapkan Nilai Asli (Matriks Keputusan X)
        $matrixX = [];
        foreach ($pelamars as $pelamar) {
            $profil = $pelamar->profil;
            $matrixX[$pelamar->id] = [
                'C1' => (float) ($profil->ipk ?: 0),
                'C2' => (float) ($profil->penghasilan_ortu ?: 1), // hindari div by zero
                'C3' => (float) ($profil->jumlah_tanggungan ?: 0),
                'C4' => (float) ($profil->skor_prestasi ?: 0),
            ];
        }

        // 2. Cari Nilai Max dan Min per Kriteria
        $maxValues = [];
        $minValues = [];
        foreach ($kriterias as $k) {
            $kode = $k->kode_kriteria;
            $columnValues = array_column($matrixX, $kode);
            $maxValues[$kode] = !empty($columnValues) ? max($columnValues) : 1;
            $minValues[$kode] = !empty($columnValues) ? min(array_filter($columnValues) ?: [1]) : 1;
        }

        // 3. Normalisasi Matriks R dan Hitung Preferensi V
        foreach ($pelamars as $pelamar) {
            $totalSkor = 0;

            foreach ($kriterias as $k) {
                $kode = $k->kode_kriteria;
                $x_ij = $matrixX[$pelamar->id][$kode];
                $bobotPersen = $k->bobot / 100; // e.g. 40% -> 0.40

                // Normalisasi SAW: Benefit = x_ij / max, Cost = min / x_ij
                if ($k->sifat === 'cost') {
                    $r_ij = $x_ij > 0 ? ($minValues[$kode] / $x_ij) : 1;
                } else {
                    $r_ij = $maxValues[$kode] > 0 ? ($x_ij / $maxValues[$kode]) : 0;
                }

                $nilaiTerbobot = $bobotPersen * $r_ij;
                $totalSkor += $nilaiTerbobot;

                // Simpan detail per kriteria
                PenilaianSaw::updateOrCreate(
                    [
                        'pengajuan_id' => $pelamar->id,
                        'kriteria_id' => $k->id,
                    ],
                    [
                        'nilai_asli' => $x_ij,
                        'nilai_normalisasi' => $r_ij,
                        'nilai_terbobot' => $nilaiTerbobot,
                    ]
                );
            }

            $pelamar->update([
                'total_skor_saw' => $totalSkor,
                'status_tahap' => 'seleksi_saw',
            ]);
        }

        // 4. Urutkan dan Berikan Peringkat
        $sortedPelamars = PengajuanBeasiswa::where('beasiswa_id', $beasiswa->id)
            ->whereNotNull('total_skor_saw')
            ->orderBy('total_skor_saw', 'desc')
            ->get();

        $rank = 1;
        foreach ($sortedPelamars as $item) {
            $item->update(['peringkat' => $rank++]);
        }

        return back()->with('success', 'Perhitungan algoritma Simple Additive Weighting (SAW) berhasil! ' . count($pelamars) . ' pelamar telah dirangking secara objektif.');
    }
}
