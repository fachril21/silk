<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use EasyRdf_Sparql_Client;
use Illuminate\Support\Facades\Auth;
use App\PengajuanKerjasama;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class PengajuanKerjasamaController extends Controller
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
        return view('/pengajuanKerjasama');
    }

    public function ajukanKerjasama(Request $request){

        $pengajuanKerjasama = new PengajuanKerjasama;
        $pengajuanKerjasama->id_user = Auth::user()->id;
        $pengajuanKerjasama->jenis_kerjasama = $request->jenisKerjasama;
        $pengajuanKerjasama->judul = $request->judul;
        $pengajuanKerjasama->batas_usia = $request->batasUsia;

        if($request->jenisKelaminLakiLaki == "1"){
            $lakiLaki = true;
        }else{
            $lakiLaki = false;
        }
        $pengajuanKerjasama->jenis_kelamin_laki_laki = $lakiLaki;
        
        if($request->jenisKelaminPerempuan == "1"){
            $perempuan = true;
        }else{
            $perempuan = false;
        }
        $pengajuanKerjasama->jenis_kelamin_perempuan = $perempuan;
        $pengajuanKerjasama->lulusan_pelamar = $request->lulusanPelamar;
        $pengajuanKerjasama->posisi = $request->posisi;
        $pengajuanKerjasama->informasi_posisi = $request->informasiPosisi;
        $pengajuanKerjasama->gaji_ditawarkan = $request->gajiDitawarkan;
        $pengajuanKerjasama->status = "Diajukan";

        $pengajuanKerjasama->save();

        return redirect()->route('kerjasamaRekrutmen');
    }

    public function showKerjaSama($id){
        $dataPengajuan = DB::table('pengajuan_kerjasamas')
                            ->where('id_user', $id)
                            ->get();
        return view('kerjasamaRekrutmen', compact('dataPengajuan'));
    }


}
