<?php

namespace Tests\Feature;

use App\Models\Beasiswa;
use App\Models\PengajuanBeasiswa;
use App\Models\ProfilMahasiswa;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ScolaRedesignTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
    }

    public function test_public_pages_render_with_nomu_vite_assets(): void
    {
        $beasiswa = Beasiswa::firstOrFail();

        foreach (['/', '/login', '/register', "/beasiswa/{$beasiswa->id}"] as $uri) {
            $response = $this->get($uri);
            $response->assertStatus(200);
            $response->assertSee('build/assets/app-', false);
        }
    }

    public function test_mahasiswa_portal_pages_render_properly(): void
    {
        $mahasiswa = User::where('role', 'mahasiswa')->firstOrFail();
        $pengajuan = PengajuanBeasiswa::firstOrFail();

        $this->actingAs($mahasiswa)->get('/mahasiswa/dashboard')->assertStatus(200);
        $this->actingAs($mahasiswa)->get('/mahasiswa/profil')->assertStatus(200);
        $this->actingAs($mahasiswa)->get("/mahasiswa/pengajuan/{$pengajuan->id}/berkas")->assertStatus(200);
    }

    public function test_admin_portal_pages_render_properly(): void
    {
        $admin = User::where('role', 'admin')->firstOrFail();
        $pengajuan = PengajuanBeasiswa::firstOrFail();

        $this->actingAs($admin)->get('/admin/dashboard')->assertStatus(200);
        $this->actingAs($admin)->get('/admin/beasiswa')->assertStatus(200);
        $this->actingAs($admin)->get('/admin/beasiswa/create')->assertStatus(200);
        $this->actingAs($admin)->get("/admin/verifikasi/{$pengajuan->id}")->assertStatus(200);
    }

    public function test_reviewer_saw_dashboard_and_calculation_work(): void
    {
        $reviewer = User::where('role', 'reviewer')->firstOrFail();
        $beasiswa = Beasiswa::firstOrFail();

        foreach (ProfilMahasiswa::all() as $profil) {
            PengajuanBeasiswa::firstOrCreate(
                ['profil_id' => $profil->id, 'beasiswa_id' => $beasiswa->id],
                [
                    'nomor_pendaftaran' => 'SCL-TEST-' . $profil->id,
                    'status_tahap' => 'submitted',
                    'tgl_pengajuan' => now(),
                ]
            );
        }

        $this->actingAs($reviewer)
            ->post("/reviewer/beasiswa/{$beasiswa->id}/hitung-saw")
            ->assertRedirect();

        $this->actingAs($reviewer)
            ->get('/reviewer/dashboard')
            ->assertStatus(200)
            ->assertSee('0.9735');
    }
}
