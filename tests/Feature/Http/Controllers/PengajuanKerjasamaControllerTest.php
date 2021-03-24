<?php

namespace Tests\Feature\Http\Controllers;

use App\LowonganKerja;
use App\PengajuanKerjasama;
use App\PesertaRekrutmen;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PengajuanKerjasamaControllerTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_usulanJadwal_integrasi()
    {
        $this->withoutExceptionHandling();
        $user = factory(User::class)->create([
            'username' => $this->faker->word(),
            'name' => $this->faker->company,
            'birth_date' => null,
            'status' => 'Perusahaan',
            'phone' => $this->faker->e164PhoneNumber,
            'email' => $this->faker->companyEmail,
            'password' => $this->faker->password,
        ]);
        $pengajuanKerjasamaFactory = factory(PengajuanKerjasama::class)->create([
            'id_user' => $user->id,
            'nama_perusahaan' => $user->name,
            'jenis_kerjasama' => 'Rekrutmen Dalam Kampus',
            'judul' => $this->faker->words(3, true),
            'batas_usia' => $this->faker->randomNumber(2),
            'jenis_kelamin_laki_laki' => $this->faker->boolean(),
            'jenis_kelamin_perempuan' => $this->faker->boolean(),
            'status' => 'Diajukan',
        ]);
        
        $checkDB = \App\Helper\Helper::instance()->checkDBConnection();
        $this->assertFalse($checkDB);
        $pengajuanKerjasama = PengajuanKerjasama::all()->first();
        $response = $this->actingAs($user)
            ->post(route('usulanJadwal', ['id' => $pengajuanKerjasama->id]), [
                'tgl_usulan' => $this->faker->date(),
                'alasan_usulan' => $this->faker->words(4, true),
            ]);

        $response->assertStatus(200);
    }

    public function test_konfirmasiKehadiran()
    {
        $this->withoutExceptionHandling();
        $userPerusahaan = factory(User::class)->create([
            'username' => $this->faker->word(),
            'name' => $this->faker->company,
            'birth_date' => null,
            'status' => 'Perusahaan',
            'phone' => $this->faker->e164PhoneNumber,
            'email' => $this->faker->companyEmail,
            'password' => $this->faker->password,
        ]);
        $userPelamar = factory(User::class)->create([
            'username' => $this->faker->word(),
            'name' => $this->faker->company,
            'birth_date' => $this->faker->date(),
            'status' => 'Pelamar',
            'phone' => $this->faker->e164PhoneNumber,
            'email' => $this->faker->companyEmail,
            'password' => $this->faker->password,
        ]);

        $lowonganFactory = factory(LowonganKerja::class)->create([
            'id_user_perusahaan' => $userPerusahaan->id,
            'nama_perusahaan' => $userPerusahaan->name,
            'jenis_kerjasama' => 'Rekrutmen Dalam Kampus',
            'judul' => $this->faker->words(3, true),
            'batas_usia' => $this->faker->randomNumber(2),
            'jenis_kelamin_laki_laki' => $this->faker->boolean(),
            'jenis_kelamin_perempuan' => $this->faker->boolean(),
            'tgl_tes' => $this->faker->date(),
            'waktu_tes' => $this->faker->time(),
            'lokasi' => $this->faker->streetAddress,
            'status' => 'Berjalan',
        ]);
        $pesertaRekrutmenFactory = factory(PesertaRekrutmen::class)->create([
            'id_user' => $userPelamar->id,
            'id_lowongan' => $lowonganFactory->id,
            'status' => 'Terdaftar',
        ]);
        
        $response = $this->actingAs($userPelamar)
            ->post(route('konfirmasiKehadiran', ['id' => $pesertaRekrutmenFactory->id]));

        $response->assertStatus(200);
    }

    public function test_ajukanKerjasama_jalur2()
    {
        $this->withoutExceptionHandling();
        $userPerusahaan = factory(User::class)->create([
            'username' => $this->faker->word(),
            'name' => $this->faker->company,
            'birth_date' => null,
            'status' => 'Perusahaan',
            'phone' => $this->faker->e164PhoneNumber,
            'email' => $this->faker->companyEmail,
            'password' => $this->faker->password,
        ]);

        $response = $this->actingAs($userPerusahaan)
            ->post('/pengajuanKerjasama/upload', [
                'id_user' => $userPerusahaan->id,
                'nama_perusahaan' => $userPerusahaan->name,
                'jenisKerjasama' => 'Rekrutmen Dalam Kampus',
                'judul' => $this->faker->words(3, true),
                'batasUsia' => $this->faker->randomNumber(2),
                'jenisKelaminLakiLaki' => 1,
                'jenisKelaminPerempuan' => 1,
                'posisi' => $this->faker->jobTitle,
                'informasiPosisi' => $this->faker->words(7, true),
                'gajiDitawarkan' => $this->faker->randomNumber(7),
                'skill' => ['PHP'],
                'lulusanPelamar' => ['Informatika'],
                'status' => 'Diajukan',
            ]);

        $response->assertStatus(200);
    }

    public function test_ajukanKerjasama_jalur3()
    {
        $this->withoutExceptionHandling();
        $userPerusahaan = factory(User::class)->create([
            'username' => $this->faker->word(),
            'name' => $this->faker->company,
            'birth_date' => null,
            'status' => 'Perusahaan',
            'phone' => $this->faker->e164PhoneNumber,
            'email' => $this->faker->companyEmail,
            'password' => $this->faker->password,
        ]);

        $response = $this->actingAs($userPerusahaan)
            ->post('/pengajuanKerjasama/upload', [
                'id_user' => $userPerusahaan->id,
                'nama_perusahaan' => $userPerusahaan->name,
                'jenisKerjasama' => 'Rekrutmen Dalam Kampus',
                'judul' => $this->faker->words(3, true),
                'batasUsia' => $this->faker->randomNumber(2),
                'jenisKelaminLakiLaki' => 0,
                'jenisKelaminPerempuan' => 1,
                'posisi' => $this->faker->jobTitle,
                'informasiPosisi' => $this->faker->words(7, true),
                'gajiDitawarkan' => $this->faker->randomNumber(7),
                'skill' => ['PHP'],
                'lulusanPelamar' => ['Informatika'],
                'status' => 'Diajukan',
            ]);

        $response->assertStatus(302);
    }

    public function test_ajukanKerjasama_jalur4()
    {
        $this->withoutExceptionHandling();
        $userPerusahaan = factory(User::class)->create([
            'username' => $this->faker->word(),
            'name' => $this->faker->company,
            'birth_date' => null,
            'status' => 'Perusahaan',
            'phone' => $this->faker->e164PhoneNumber,
            'email' => $this->faker->companyEmail,
            'password' => $this->faker->password,
        ]);

        $response = $this->actingAs($userPerusahaan)
            ->post('/pengajuanKerjasama/upload', [
                'id_user' => $userPerusahaan->id,
                'nama_perusahaan' => $userPerusahaan->name,
                'jenisKerjasama' => 'Rekrutmen Dalam Kampus',
                'judul' => $this->faker->words(3, true),
                'batasUsia' => $this->faker->randomNumber(2),
                'jenisKelaminLakiLaki' => 1,
                'jenisKelaminPerempuan' => 0,
                'posisi' => $this->faker->jobTitle,
                'informasiPosisi' => $this->faker->words(7, true),
                'gajiDitawarkan' => $this->faker->randomNumber(7),
                'skill' => ['PHP'],
                'lulusanPelamar' => ['Informatika'],
                'status' => 'Diajukan',
            ]);

        $response->assertStatus(302);
    }

    public function test_ajukanKerjasama_jalur5()
    {
        $this->withoutExceptionHandling();
        $userPerusahaan = factory(User::class)->create([
            'username' => $this->faker->word(),
            'name' => $this->faker->company,
            'birth_date' => null,
            'status' => 'Perusahaan',
            'phone' => $this->faker->e164PhoneNumber,
            'email' => $this->faker->companyEmail,
            'password' => $this->faker->password,
        ]);

        $response = $this->actingAs($userPerusahaan)
            ->post('/pengajuanKerjasama/upload', [
                'id_user' => $userPerusahaan->id,
                'nama_perusahaan' => $userPerusahaan->name,
                'jenisKerjasama' => 'Rekrutmen Dalam Kampus',
                'judul' => $this->faker->words(3, true),
                'batasUsia' => $this->faker->randomNumber(2),
                'jenisKelaminLakiLaki' => 0,
                'jenisKelaminPerempuan' => 0,
                'posisi' => $this->faker->jobTitle,
                'informasiPosisi' => $this->faker->words(7, true),
                'gajiDitawarkan' => $this->faker->randomNumber(7),
                'skill' => ['PHP'],
                'lulusanPelamar' => ['Informatika'],
                'status' => 'Diajukan',
            ]);

        $response->assertStatus(302);
    }

    public function test_ajukanKerjasama_jalur1()
    {
        $this->withoutExceptionHandling();
        $userPerusahaan = factory(User::class)->create([
            'username' => $this->faker->word(),
            'name' => $this->faker->company,
            'birth_date' => null,
            'status' => 'Perusahaan',
            'phone' => $this->faker->e164PhoneNumber,
            'email' => $this->faker->companyEmail,
            'password' => $this->faker->password,
        ]);

        $response = $this->actingAs($userPerusahaan)
            ->post('/pengajuanKerjasama/upload', [
                'id_user' => $userPerusahaan->id,
                'nama_perusahaan' => $userPerusahaan->name,
                'jenisKerjasama' => 'Rekrutmen Dalam Kampus',
                'judul' => $this->faker->words(3, true),
                'batasUsia' => $this->faker->randomNumber(2),
                'jenisKelaminLakiLaki' => 0,
                'jenisKelaminPerempuan' => 0,
                'posisi' => $this->faker->jobTitle,
                'informasiPosisi' => $this->faker->words(7, true),
                'gajiDitawarkan' => $this->faker->randomNumber(7),
                'skill' => ['PHP', 'Kotlin', 'Java'],
                'lulusanPelamar' => ['Informatika', 'Sistem Informasi', 'Teknik Komputer'],
                'status' => 'Diajukan',
            ]);

        $response->assertStatus(200);
    }
}
