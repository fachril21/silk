<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use EasyRdf_Sparql_Client;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LowonganKerjaController extends Controller
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
        //
        // BELUM DITAMBAH FILTER SESUAI PROFILE PELAMAR
        //
        global $endpoint;
        $obj = new PengajuanKerjasamaController();
        $dataLowonganKerja = $obj->endpoint->query(
            "
                PREFIX rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#>
                PREFIX silk: <http://www.silk.com#>

                SELECT ?id ?judul ?nama_perusahaan ?jabatan ?gaji_jabatan
                WHERE {
  					?instanceLowonganKerja rdf:type silk:Lowongan_Kerja . ?instanceLowonganKerja silk:judul ?judul .
  					?instanceLowonganKerja silk:id ?id .
                    ?instancePerusahaan rdf:type silk:Perusahaan . ?instancePerusahaan silk:mengadakan ?instanceLowonganKerja . 
  					?instancePerusahaan silk:nama_perusahaan ?nama_perusahaan . 
                    ?instanceLowonganKerja silk:jabatan ?jabatan . ?instanceLowonganKerja silk:gaji_jabatan ?gaji_jabatan . 
                }
            "
        );
        $dataStatus = DB::table('pengajuan_kerjasamas')
            // ->where('status', 'Berjalan')
            ->get();

        $dataLowonganKerjaView = array();

        foreach ($dataStatus as $rowStatus) {
            foreach ($dataLowonganKerja as $rowData) {
                $id_rdf = $rowData->id->getValue();
                if ($rowStatus->id == $id_rdf) {
                    $dataLowonganKerjaObj = (object) [
                        'id' => $rowStatus->id,
                        'judul' => $rowData->judul->getValue(),
                        'status' => $rowStatus->status,
                        'nama_perusahaan' => $rowData->nama_perusahaan->getValue(),
                        'jabatan' => $rowData->jabatan->getValue(),
                        'gaji_jabatan' => $rowData->gaji_jabatan->getValue(),
                    ];
                    $dataLowonganKerjaView[] = $dataLowonganKerjaObj;
                }
            }
        }



        return view('daftarLowonganKerja', compact('dataLowonganKerjaView'));
    }

    public function detailLowonganKerja($id)
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
            ->first();

        $dataPendaftaran = DB::table('peserta_rekrutmens')
            ->where('id_user', Auth::user()->id)
            ->where('id_lowongan', $id)
            ->first();
        return view('detailLowonganKerja', compact('dataKerjasama', 'dataKerjasamaDB', 'dataJenisKelamin', 'dataJurusan', 'dataKeahlian', 'dataPendaftaran'));

    }
}
