<?php

namespace App\Http\Controllers;

use App\PesertaRekrutmen as AppPesertaRekrutmen;
use Illuminate\Http\Request;
use EasyRdf_Sparql_Client;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PesertaRekrutmen;
use RealRashid\SweetAlert\Facades\Alert;

class ProgresPesertaRekrutmenController extends Controller
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
            ->select('peserta_rekrutmens.id as id', 
                        'peserta_rekrutmens.id_user as id_user', 
                        'peserta_rekrutmens.id_lowongan as id_lowongan',
                        'pengajuan_kerjasamas.judul as judul', 
                        'pengajuan_kerjasamas.nama_perusahaan as nama_perusahaan', 
                        'pengajuan_kerjasamas.lokasi as lokasi', 
                        'pengajuan_kerjasamas.tgl_tes_final as tgl_tes_final', 
                        DB::raw('TIME_FORMAT(pengajuan_kerjasamas.waktu_tes, "%H : %i") as waktu_tes'), 
                        'peserta_rekrutmens.status as status', 
                        'peserta_rekrutmens.info_status as info_status')
            ->where('peserta_rekrutmens.id_user', Auth::user()->id)
            ->get();

        // $test = DB::table('peserta_rekrutmens')
        //     ->join('pengajuan_kerjasamas', 'peserta_rekrutmens.id_lowongan', '=', 'pengajuan_kerjasamas.id')
        //     ->where('peserta_rekrutmens.id_user', Auth::user()->id)
        //     ->get();

        return view('progresPesertaRekrutmen', compact('progresRekrutmen'));
    }

    public function detailProgresPeserta($id)
    {
        $detailProgresRekrutmen = DB::table('peserta_rekrutmens')
            ->join('pengajuan_kerjasamas', 'peserta_rekrutmens.id_lowongan', '=', 'pengajuan_kerjasamas.id')
            ->join('users', 'peserta_rekrutmens.id_user', '=', 'users.id')
            ->select('peserta_rekrutmens.id as id', 
                        'peserta_rekrutmens.id_user as id_user', 
                        'peserta_rekrutmens.id_lowongan as id_lowongan',
                        'pengajuan_kerjasamas.judul as judul', 
                        'pengajuan_kerjasamas.lokasi as lokasi', 
                        'pengajuan_kerjasamas.nama_perusahaan as nama_perusahaan', 
                        'pengajuan_kerjasamas.tgl_tes_final as tgl_tes_final', 
                        DB::raw('TIME_FORMAT(pengajuan_kerjasamas.waktu_tes, "%H : %i") as waktu_tes'), 
                        'peserta_rekrutmens.status as status', 
                        'peserta_rekrutmens.info_status as info_status')
            ->where('peserta_rekrutmens.id', $id)
            ->first();
        
        return view('detailProgresPeserta', compact('detailProgresRekrutmen'));
    }

    public function konfirmasiKehadiran($id)
    {
        $progresPeserta = AppPesertaRekrutmen::find($id);
        $progresPeserta->status = "Akan Hadir Tes Rekrumen";
        $progresPeserta->info_status = "Dimohon hadir pada lokasi tes 30 menit sebelum tes dimulai";
        $progresPeserta->save();

        Alert::toast('Berhasil Konfirmasi Kehadiran Tes Rekrutmen', 'Dimohon hadir pada lokasi tes 30 menit sebelum tes dimulai');

        return redirect()->route('detailProgresPeserta', ['id' => $id]);

    }
}
