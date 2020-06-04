<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use EasyRdf_Sparql_Client;

class DetailKerjasamaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->endpoint = new EasyRdf_Sparql_Client(
            'http://localhost:3030/silk/query',
            'http://localhost:3030/silk/update'
        );
    }

    public function index($id)
    {
        global $endpoint;
        $obj = new DetailKerjasamaController();
        $resultDataKerjasama = $obj->endpoint->query(
            "
                PREFIX rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#>
                PREFIX silk: <http://www.silk.com#>

                SELECT ?judul ?batas_usia ?jabatan ?gaji_jabatan ?informasi_pekerjaan
                WHERE {
                    ?instanceLoker rdf:type silk:Lowongan_Kerja . ?instanceLoker silk:id ?id .
                    ?instanceLoker silk:judul ?judul . ?instanceLoker silk:batas_usia ?batas_usia .
                    ?instanceLoker silk:jabatan ?jabatan . ?instanceLoker silk:gaji_jabatan ?gaji_jabatan .
                    ?instanceLoker silk:informasi_pekerjaan ?informasi_pekerjaan . 
                    FILTER regex(?id, '$id')
                }
            "
        );
        foreach ($resultDataKerjasama as $row) {
            $dataKerjasama = (object) [
                'judul' => $row->judul,
                'batas_usia' => $row->batas_usia,
                'jabatan' => $row->jabatan,
                'gaji_jabatan' => $row->gaji_jabatan,
                'informasi_pekerjaan' => $row->informasi_pekerjaan,
            ];
        }


        $dataJenisKelamin = $obj->endpoint->query(
            "
                PREFIX rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#>
                PREFIX silk: <http://www.silk.com#>

                SELECT ?jenis_kelamin
                WHERE {
                    ?instanceLoker rdf:type silk:Lowongan_Kerja . ?instanceLoker silk:id ?id . ?instanceLoker silk:jenis_kelamin ?jenis_kelamin . 
                    FILTER regex(?id, '$id')
                }
            "
        );

        $dataJurusan = $obj->endpoint->query(
            "
                PREFIX rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#>
                PREFIX silk: <http://www.silk.com#>

                SELECT ?jurusan
                WHERE {
                    ?instanceLoker rdf:type silk:Lowongan_Kerja . ?instanceLoker silk:id ?id . 
                    ?instanceLoker silk:membutuhkan ?instanceJurusan . ?instanceJurusan silk:nama_jurusan ?jurusan
                    FILTER regex(?id, '$id')
                }
            "
        );

        $dataKeahlian = $obj->endpoint->query(
            "
                PREFIX rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#>
                PREFIX silk: <http://www.silk.com#>

                SELECT ?keahlian
                WHERE {
                    ?instanceLoker rdf:type silk:Lowongan_Kerja . ?instanceLoker silk:id ?id . 
                    ?instanceLoker silk:membutuhkan ?instanceKeahlian . ?instanceKeahlian silk:nama ?keahlian
                    FILTER regex(?id, '$id')
                }
            "
        );

        $dataKerjasamaDB = DB::table('pengajuan_kerjasamas')
            ->where('id', $id)
            ->select(DB::raw('*, TIME_FORMAT(pengajuan_kerjasamas.waktu_tes, "%H : %i") as waktu_tes_format'))
            ->first();

        return view('detailKerjasama', compact('dataKerjasama', 'dataKerjasamaDB', 'dataJenisKelamin', 'dataJurusan', 'dataKeahlian'));
    }
}
