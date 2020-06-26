<?php

namespace App\Http\Controllers;

use App\LowonganKerja;
use App\PengajuanKerjasama;
use App\PesertaRekrutmen;
use Illuminate\Http\Request;
use EasyRdf_Sparql_Client;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class ProgresKerjasamaRekrutmenController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->endpoint = new EasyRdf_Sparql_Client(
            'http://localhost:3030/silk/query',
            'http://localhost:3030/silk/update'
        );
    }


    public function index()
    {
        $progresRekrutmen = DB::table('peserta_rekrutmens')
            ->join('pengajuan_kerjasamas', 'peserta_rekrutmens.id_lowongan', '=', 'pengajuan_kerjasamas.id')
            ->join('users', 'peserta_rekrutmens.id_user', '=', 'users.id')
            ->join(DB::raw('(SELECT * FROM users WHERE users.status = "Perusahaan") AS users_perusahaan'), 'pengajuan_kerjasamas.id_user', '=', 'users_perusahaan.id')
            ->select(
                'peserta_rekrutmens.id as id',
                'peserta_rekrutmens.id_user as id_user',
                'peserta_rekrutmens.id_lowongan as id_lowongan',
                'pengajuan_kerjasamas.judul as judul',
                'pengajuan_kerjasamas.nama_perusahaan as nama_perusahaan',
                'pengajuan_kerjasamas.lokasi as lokasi',
                'pengajuan_kerjasamas.tgl_tes_final as tgl_tes_final',
                DB::raw('TIME_FORMAT(pengajuan_kerjasamas.waktu_tes, "%H : %i") as waktu_tes'),
                'peserta_rekrutmens.status as status',
                'peserta_rekrutmens.info_status as info_status',
                'users_perusahaan.username as username_perusahaan'
            )
            ->where('pengajuan_kerjasamas.id_user', Auth::user()->id)
            ->get();

        return view('progresKerjasamaRekrutmen', compact('progresRekrutmen'));
    }

    public function indexUpkk()
    {
        $progresRekrutmen = DB::table('peserta_rekrutmens')
            ->join('pengajuan_kerjasamas', 'peserta_rekrutmens.id_lowongan', '=', 'pengajuan_kerjasamas.id')
            ->join('users', 'peserta_rekrutmens.id_user', '=', 'users.id')
            ->join(DB::raw('(SELECT * FROM users WHERE users.status = "Perusahaan") AS users_perusahaan'), 'pengajuan_kerjasamas.id_user', '=', 'users_perusahaan.id')
            ->select(
                'peserta_rekrutmens.id as id',
                'peserta_rekrutmens.id_user as id_user',
                'peserta_rekrutmens.id_lowongan as id_lowongan',
                'pengajuan_kerjasamas.judul as judul',
                'pengajuan_kerjasamas.nama_perusahaan as nama_perusahaan',
                'pengajuan_kerjasamas.lokasi as lokasi',
                'pengajuan_kerjasamas.tgl_tes_final as tgl_tes_final',
                DB::raw('TIME_FORMAT(pengajuan_kerjasamas.waktu_tes, "%H : %i") as waktu_tes'),
                'peserta_rekrutmens.status as status',
                'peserta_rekrutmens.info_status as info_status',
                'users_perusahaan.username as username_perusahaan'
            )

            ->get();

        return view('progresKerjasamaRekrutmen', compact('progresRekrutmen'));
    }

    public function detailProgresKerjasama($id)
    {
        $detailProgresRekrutmen = DB::table('peserta_rekrutmens')
            ->join('pengajuan_kerjasamas', 'peserta_rekrutmens.id_lowongan', '=', 'pengajuan_kerjasamas.id')
            ->join('users', 'peserta_rekrutmens.id_user', '=', 'users.id')
            ->select(
                'peserta_rekrutmens.id as id',
                'peserta_rekrutmens.id_user as id_user',
                'peserta_rekrutmens.id_lowongan as id_lowongan',
                'pengajuan_kerjasamas.judul as judul',
                'pengajuan_kerjasamas.lokasi as lokasi',
                'pengajuan_kerjasamas.nama_perusahaan as nama_perusahaan',
                'pengajuan_kerjasamas.tgl_tes_final as tgl_tes_final',
                DB::raw('TIME_FORMAT(pengajuan_kerjasamas.waktu_tes, "%H : %i") as waktu_tes'),
                'pengajuan_kerjasamas.status as status',
                'pengajuan_kerjasamas.info_status as info_status'
            )
            ->where('peserta_rekrutmens.id_lowongan', $id)
            ->first();

        $daftarPeserta = DB::table('peserta_rekrutmens')
            ->join('users', 'peserta_rekrutmens.id_user', '=', 'users.id')
            ->select('peserta_rekrutmens.id as id', 'users.username as username_peserta', 'users.name as nama_peserta', 'users.phone as no_telepon', 'users.email as email', 'peserta_rekrutmens.status as status')
            ->where('peserta_rekrutmens.id_lowongan', $id)
            ->get();

        return view('detailProgresKerjasama', compact('detailProgresRekrutmen', 'daftarPeserta'));
    }

    public function konfirmasiKehadiranTes($id)
    {
        $peserta = PesertaRekrutmen::find($id);
        $peserta->status = "Telah Menjalani Tes Rekrutmen";
        $peserta->info_status = "Mohon menunggu hasil seleksi tes dari perusahaan";
        $peserta->save();

        Alert::toast('Berhasil melakukan konfirmasi kehadiran');
        return redirect()->route('detailProgresKerjasama', ['id' => $peserta->id_lowongan]);
    }

    public function konfirmasiTesSelesai($id)
    {
        $kerjasama = PengajuanKerjasama::find($id);
        $kerjasama->status = "Menunggu Hasil Seleksi";
        $kerjasama->info_status = "Menunggu hasil seleksi yang dilakukan oleh pihak perusahaan";

        $dataLowonganKerja = LowonganKerja::find($id);
        $dataLowonganKerja->status = $kerjasama->status;
        $dataLowonganKerja->info_status = $kerjasama->info_status;
        $dataLowonganKerja->save();

        $daftarPeserta = DB::table('peserta_rekrutmens')
            ->where('peserta_rekrutmens.status', 'Akan Hadir Tes Rekrumen')
            ->orWhere('peserta_rekrutmens.status', 'Terdaftar')
            ->update(['status' => 'Tidak Hadir Tes', 'info_status' => 'Gagal mengikuti tes rekrutmen']);

        $kerjasama->save();

        Alert::toast('Tes Rekrutmen telah selesai, menunggu hasil seleksi');
        return redirect()->route('detailProgresKerjasama', ['id' => $id]);
    }

    public function terimaPeserta($id)
    {
        $peserta = PesertaRekrutmen::find($id);
        $id_user = $peserta->id_user;


        $usernamePesertaObj = DB::table('users')->where('id', $id_user)->first();
        $usernamePerusahaanObj = DB::table('peserta_rekrutmens')
            ->join('lowongan_kerjas', 'peserta_rekrutmens.id_lowongan', '=', 'lowongan_kerjas.id')
            ->join('users', 'lowongan_kerjas.id_user_perusahaan', '=', 'users.id')
            ->where('peserta_rekrutmens.id_lowongan', $peserta->id_lowongan)
            ->select('users.username as username')
            ->first();

        $usernamePeserta = $usernamePesertaObj->username;
        $usernamePerusahaan = $usernamePerusahaanObj->username;


        global $endpoint;
        $obj = new ProgresKerjasamaRekrutmenController();
        $result = $obj->endpoint->update(
            "
                PREFIX rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#>
                PREFIX silk: <http://www.silk.com#>
                
                INSERT DATA
                    { 
                        silk:$usernamePerusahaan silk:merekrut silk:$usernamePeserta .                         
                    }     
                "
        );

        $peserta->status = "Diterima";
        $peserta->info_status = "Selamat Anda diterima pada proses rekrutmen ini. Anda akan dihubungi oleh pihak perusahaan";
        $peserta->save();

        return redirect()->route('detailProgresKerjasama', ['id' => $peserta->id_lowongan]);
    }

    public function tolakPeserta($id)
    {
        $peserta = PesertaRekrutmen::find($id);
        $peserta->status = "Ditolak";
        $peserta->info_status = "Maaf Anda ditolak pada proses rekrutmen ini.";
        $peserta->save();

        return redirect()->route('detailProgresKerjasama', ['id' => $peserta->id_lowongan]);
    }
}
