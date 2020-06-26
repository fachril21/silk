<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use EasyRdf_Sparql_Client;
use RealRashid\SweetAlert\Facades\Alert;
use App\PesertaRekrutmen;
use Illuminate\Support\Facades\DB;

class PesertaRekrutmenController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->endpoint = new EasyRdf_Sparql_Client(
            'http://localhost:3030/silk/query',
            'http://localhost:3030/silk/update'
        );
    }

    public function daftarRekrutmen($id_user, $id_lowongan)
    {
        $pesertaRekrutmen = new PesertaRekrutmen;
        $pesertaRekrutmen->id_user = $id_user;
        $pesertaRekrutmen->id_lowongan = $id_lowongan;
        $pesertaRekrutmen->status = "Terdaftar";
        $pesertaRekrutmen->info_status = "Menunggu tes rekrutmen, mohon untuk konfirmasi kehadiran tes rekrutmen saat menjelang tes dimulai";

        $usernamePesertaObj = DB::table('users')->where('id', $id_user)->first();
        $usernamePeserta = $usernamePesertaObj->username;


        global $endpoint;
        $obj = new PesertaRekrutmenController();
        $result = $obj->endpoint->update(
            "
                PREFIX rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#>
                PREFIX silk: <http://www.silk.com#>
                
                INSERT DATA
                    { 
                        silk:$usernamePeserta silk:mendaftar silk:$id_lowongan .                         
                    }     
                "
        );
        $pesertaRekrutmen->save();
        
        Alert::toast('Berhasil Terdaftar', 'Mohon untuk konfirmasi kehadiran tes rekrutmen saat menjelang tes dimulai');
        return redirect()->route('detailLowonganKerja', ['id' => $id_lowongan]);
    }
}
