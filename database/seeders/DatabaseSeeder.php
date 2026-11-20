<?php

namespace Database\Seeders;

use App\Models\Beasiswa;
use App\Models\KriteriaPenilaian;
use App\Models\PengajuanBeasiswa;
use App\Models\ProfilMahasiswa;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Akun Admin
        User::create([
            'name' => 'Admin Kemahasiswaan UNIKA',
            'username' => 'admin_kemahasiswaan',
            'email' => 'admin@unika.ac.id',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'phone' => '081234567890',
        ]);

        // 2. Akun Reviewer (Tim Penyeleksi)
        User::create([
            'name' => 'Dr. Reviewer Beasiswa UNIKA',
            'username' => 'reviewer_beasiswa',
            'email' => 'reviewer@unika.ac.id',
            'password' => Hash::make('password'),
            'role' => 'reviewer',
            'phone' => '081234567891',
        ]);

        // 3. Akun Mahasiswa
        $mahasiswaList = [
            [
                'name' => 'Christian Landra Wicaksono',
                'nim' => '24.N2.0003',
                'email' => 'christian@student.unika.ac.id',
                'fakultas' => 'Ilmu Komputer',
                'prodi' => 'Sistem Informasi',
                'semester' => 3,
                'ipk' => 3.85,
                'penghasilan_ortu' => 3000000,
                'jumlah_tanggungan' => 3,
                'skor_prestasi' => 85,
                'no_hp' => '081298765431',
            ],
            [
                'name' => 'Anachasi Nathaniel Budi Widoyo',
                'nim' => '24.N2.0002',
                'email' => 'anachasi@student.unika.ac.id',
                'fakultas' => 'Ilmu Komputer',
                'prodi' => 'Sistem Informasi',
                'semester' => 3,
                'ipk' => 3.75,
                'penghasilan_ortu' => 2500000,
                'jumlah_tanggungan' => 4,
                'skor_prestasi' => 80,
                'no_hp' => '081298765432',
            ],
            [
                'name' => 'William Wijaya Handoyo',
                'nim' => '24.N2.0004',
                'email' => 'william@student.unika.ac.id',
                'fakultas' => 'Ilmu Komputer',
                'prodi' => 'Sistem Informasi',
                'semester' => 3,
                'ipk' => 3.90,
                'penghasilan_ortu' => 4000000,
                'jumlah_tanggungan' => 2,
                'skor_prestasi' => 90,
                'no_hp' => '081298765433',
            ],
        ];

        $profils = [];
        foreach ($mahasiswaList as $mhs) {
            $user = User::create([
                'name' => $mhs['name'],
                'username' => $mhs['nim'],
                'email' => $mhs['email'],
                'password' => Hash::make('password'),
                'role' => 'mahasiswa',
                'phone' => $mhs['no_hp'],
            ]);

            $profil = ProfilMahasiswa::create([
                'user_id' => $user->id,
                'nim' => $mhs['nim'],
                'nama_lengkap' => $mhs['name'],
                'fakultas' => $mhs['fakultas'],
                'prodi' => $mhs['prodi'],
                'semester' => $mhs['semester'],
                'ipk' => $mhs['ipk'],
                'penghasilan_ortu' => $mhs['penghasilan_ortu'],
                'jumlah_tanggungan' => $mhs['jumlah_tanggungan'],
                'skor_prestasi' => $mhs['skor_prestasi'],
                'alamat' => 'Semarang, Jawa Tengah',
                'no_hp' => $mhs['no_hp'],
            ]);

            $profils[] = $profil;
        }

        // 4. Sample Program Beasiswa
        $b1 = Beasiswa::create([
            'nama_program' => 'Beasiswa Prestasi Akademik UNIKA 2026',
            'kategori' => 'Prestasi Akademik',
            'penyelenggara' => 'Universitas Katolik Soegijapranata',
            'kuota' => 10,
            'tgl_buka' => now()->toDateString(),
            'tgl_tutup' => now()->addMonths(1)->toDateString(),
            'deskripsi' => 'Program beasiswa penuh/parsial untuk mahasiswa berprestasi akademik dan aktif berorganisasi di lingkungan UNIKA.',
            'persyaratan' => "1. Mahasiswa aktif UNIKA minimal semester 2.\n2. IPK minimal 3.50.\n3. Mengunggah KHS, KTM, dan Surat Rekomendasi Fakultas.",
            'ipk_minimal' => 3.50,
            'status' => 'buka',
        ]);

        $b2 = Beasiswa::create([
            'nama_program' => 'Beasiswa Bantuan Ekonomi Mahasiswa',
            'kategori' => 'Bantuan Ekonomi',
            'penyelenggara' => 'Yayasan Sandjojo UNIKA',
            'kuota' => 15,
            'tgl_buka' => now()->toDateString(),
            'tgl_tutup' => now()->addDays(20)->toDateString(),
            'deskripsi' => 'Bantuan keringanan biaya kuliah (UKT) bagi mahasiswa yang mengalami kendala ekonomi.',
            'persyaratan' => "1. Terdaftar aktif sebagai mahasiswa UNIKA.\n2. Mengunggah Slip Gaji/SKTM dan Kartu Keluarga.\n3. IPK minimal 3.00.",
            'ipk_minimal' => 3.00,
            'status' => 'buka',
        ]);

        $b3 = Beasiswa::create([
            'nama_program' => 'Beasiswa Djarum Beasiswa Plus',
            'kategori' => 'Eksternal',
            'penyelenggara' => 'Djarum Foundation',
            'kuota' => 5,
            'tgl_buka' => now()->toDateString(),
            'tgl_tutup' => now()->addMonths(2)->toDateString(),
            'deskripsi' => 'Beasiswa prestasi eksternal plus pelatihan soft skills tingkat nasional.',
            'persyaratan' => "1. Mahasiswa semester 4.\n2. IPK minimal 3.20.",
            'ipk_minimal' => 3.20,
            'status' => 'buka',
        ]);

        // 5. Kriteria Penilaian SAW untuk Beasiswa Prestasi Akademik
        $kriterias = [
            ['kode' => 'C1', 'nama' => 'IPK', 'bobot' => 40.00, 'sifat' => 'benefit'],
            ['kode' => 'C2', 'nama' => 'Penghasilan Orang Tua', 'bobot' => 30.00, 'sifat' => 'cost'],
            ['kode' => 'C3', 'nama' => 'Jumlah Tanggungan', 'bobot' => 20.00, 'sifat' => 'benefit'],
            ['kode' => 'C4', 'nama' => 'Skor Prestasi', 'bobot' => 10.00, 'sifat' => 'benefit'],
        ];

        foreach ($kriterias as $k) {
            KriteriaPenilaian::create([
                'beasiswa_id' => $b1->id,
                'kode_kriteria' => $k['kode'],
                'nama_kriteria' => $k['nama'],
                'bobot' => $k['bobot'],
                'sifat' => $k['sifat'],
            ]);
        }

        // 6. Dummy Pendaftaran untuk Mahasiswa pertama (Christian)
        PengajuanBeasiswa::create([
            'profil_id' => $profils[0]->id,
            'beasiswa_id' => $b1->id,
            'nomor_pendaftaran' => 'SCL-2026-0001',
            'status_tahap' => 'submitted',
            'tgl_pengajuan' => now(),
        ]);
    }
}
