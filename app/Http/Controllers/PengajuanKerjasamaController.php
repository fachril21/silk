<?php

namespace App\Http\Controllers;

use App\LowonganKerja;
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
        global $endpoint;
        $obj = new PengajuanKerjasamaController();
        $dataJurusan = $obj->endpoint->query(
            "
                PREFIX rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#>
                PREFIX silk: <http://www.silk.com#>

                SELECT ?jurusan
                WHERE {
                    ?instanceJurusan rdf:type silk:Jurusan . ?instanceJurusan silk:nama_jurusan ?jurusan .
                }
            "
        );

        $dataJabatan = $obj->endpoint->query(
            "
                PREFIX rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#>
                PREFIX silk: <http://www.silk.com#>

                SELECT ?jabatan
                WHERE {
                    ?instanceJabatan rdf:type silk:Jabatan . ?instanceJabatan silk:nama ?jabatan .
                }
            "
        );

        $dataKeahlian = $obj->endpoint->query(
            "
                PREFIX rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#>
                PREFIX silk: <http://www.silk.com#>

                SELECT ?skill
                WHERE {
                    ?instanceKeahlian rdf:type silk:Keahlian . ?instanceKeahlian silk:nama ?skill .
                }
            "
        );

        return view('/pengajuanKerjasama', compact('dataJurusan', 'dataJabatan', 'dataKeahlian'));
    }

    public function ajukanKerjasama(Request $request)
    {
        $username = Auth::user()->username;
        $pengajuanKerjasama = new PengajuanKerjasama;
        $pengajuanKerjasama->id_user = Auth::user()->id;
        $pengajuanKerjasama->jenis_kerjasama = $request->jenisKerjasama;
        $pengajuanKerjasama->nama_perusahaan = Auth::user()->name;
        $pengajuanKerjasama->judul = $request->judul;
        $pengajuanKerjasama->batas_usia = $request->batasUsia;

        if ($request->jenisKelaminLakiLaki == "1") {
            $lakiLaki = true;
        } else {
            $lakiLaki = false;
        }
        $pengajuanKerjasama->jenis_kelamin_laki_laki = $lakiLaki;

        if ($request->jenisKelaminPerempuan == "1") {
            $perempuan = true;
        } else {
            $perempuan = false;
        }
        $pengajuanKerjasama->jenis_kelamin_perempuan = $perempuan;
        $pengajuanKerjasama->status = "Diajukan";

        $pengajuanKerjasama->save();

        $id_kerjasama = $pengajuanKerjasama->id;

        global $endpoint;
        $obj = new PengajuanKerjasamaController();
        $result = $obj->endpoint->update(
            "
                PREFIX rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#>
                PREFIX silk: <http://www.silk.com#>
                
                INSERT DATA
                    { 
                    silk:$id_kerjasama rdf:type silk:Lowongan_Kerja .
                    <http://www.silk.com#$username> silk:mengadakan silk:$id_kerjasama .
                    silk:$id_kerjasama silk:id '$id_kerjasama' .
                    silk:$id_kerjasama silk:judul '$request->judul' .
                    silk:$id_kerjasama silk:gaji_jabatan '$request->gajiDitawarkan' .
                    silk:$id_kerjasama silk:batas_usia '$request->batasUsia' .
                    silk:$id_kerjasama silk:jabatan '$request->posisi' .
                    silk:$id_kerjasama silk:informasi_pekerjaan '$request->informasiPosisi' .       
                    }     
                "
        );

        // jenis kelamin
        if ($request->jenisKelaminLakiLaki == "1") {
            $result = $obj->endpoint->update(
                "
                    PREFIX rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#>
                    PREFIX silk: <http://www.silk.com#>
                    
                    INSERT DATA
                        { 
                        silk:$id_kerjasama silk:jenis_kelamin 'Laki-laki' .
                        }     
                    "
            );
        }

        if ($request->jenisKelaminPerempuan == "1") {
            $result = $obj->endpoint->update(
                "
                    PREFIX rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#>
                    PREFIX silk: <http://www.silk.com#>
                    
                    INSERT DATA
                        { 
                        silk:$id_kerjasama silk:jenis_kelamin 'Perempuan' .
                        }     
                    "
            );
        }

        // jurusan
        $jurusan = $request->lulusanPelamar;

        foreach ($jurusan as $row) {
            $instanceJurusan = str_replace(' ', '_', $row);
            $result = $obj->endpoint->update(
                "
                    PREFIX rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#>
                    PREFIX silk: <http://www.silk.com#>
                    
                    INSERT DATA
                        { 
                            silk:$id_kerjasama silk:membutuhkan silk:$instanceJurusan .
                        }     
                    "
            );
        }

        //keahlian
        $keahlian = $request->skill;

        foreach ($keahlian as $row) {
            $instanceKeahlian = str_replace(' ', '_', $row);
            $result = $obj->endpoint->update(
                "
                    PREFIX rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#>
                    PREFIX silk: <http://www.silk.com#>
                    
                    INSERT DATA
                        { 
                            silk:$id_kerjasama silk:membutuhkan silk:$instanceKeahlian .
                        }     
                    "
            );
        }

        return redirect()->route('kerjasamaRekrutmen', ['id' => Auth::user()->id]);
    }

    public function showKerjaSama($id)
    {
        $dataPengajuan = DB::table('pengajuan_kerjasamas')
            ->where('id_user', $id)
            ->get();
        return view('kerjasamaRekrutmen', compact('dataPengajuan'));
    }

    public function showKerjaSamaUpkk()
    {
        $dataPengajuan = DB::table('pengajuan_kerjasamas')
            ->get();
        return view('kerjasamaRekrutmen', compact('dataPengajuan'));
    }

    public function tolakKerjasama($id)
    {
        $dataPengajuan = PengajuanKerjasama::find($id);
        $dataPengajuan->status = "Ditolak";
        $dataPengajuan->save();

        global $endpoint;
        $obj = new PengajuanKerjasamaController();
        $result = $obj->endpoint->update(
            "
                PREFIX rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#>
                PREFIX silk: <http://www.silk.com#>
                
                INSERT DATA {
                    <http://www.silk.com#$id> silk:status '$dataPengajuan->status' .
                }
            "
        );

        return redirect()->route('detailKerjasama', ['id' => $id]);
    }

    public function usulanJadwal(Request $request, $id)
    {
        $dataPengajuan = PengajuanKerjasama::find($id);
        $dataPengajuan->status = "Menolak Jadwal Dari UPKK UB";
        $dataPengajuan->info_status = "Pihak Perusahaan telah mengirimkan jadwal usulan baru";
        $dataPengajuan->tgl_usulan = $request->tgl_usulan;
        $dataPengajuan->alasan_usulan = $request->alasan_usulan;
        $dataPengajuan->save();

        return redirect()->route('detailKerjasama', ['id' => $id]);
    }

    public function terimaKerjasama(Request $request, $id)
    {
        $dataPengajuan = PengajuanKerjasama::find($id);

        $dataPengajuan->tgl_tawaran = $request->tgl_tawaran;
        $dataPengajuan->waktu_tes = $request->waktu_tes;
        $dataPengajuan->lokasi = $request->lokasi;
        $dataPengajuan->status = "Diterima";
        $dataPengajuan->info_status = "Menunggu konfirmasi oleh pihak Perusahaan dari jadwal yang telah diajukan oleh UPKK UB";
        $dataPengajuan->save();

        return redirect()->route('detailKerjasama', ['id' => $id]);
    }

    public function terimaJadwal(Request $request, $id)
    {
        $dataPengajuan = PengajuanKerjasama::find($id);

        $dataPengajuan->status = "Diterima";
        $dataPengajuan->info_status = "Menunggu UPKK UB untuk mengunggah lowongan kerja sama";
        $dataPengajuan->tgl_tes_final = $dataPengajuan->tgl_tawaran;
        $dataPengajuan->save();

        $dataLowonganKerja = new LowonganKerja;
        $dataLowonganKerja->id = $dataPengajuan->id;
        $dataLowonganKerja->id_user_perusahaan = $dataPengajuan->id_user;
        $dataLowonganKerja->nama_perusahaan = $dataPengajuan->nama_perusahaan;
        $dataLowonganKerja->jenis_kerjasama = $dataPengajuan->jenis_kerjasama;
        $dataLowonganKerja->judul = $dataPengajuan->judul;
        $dataLowonganKerja->batas_usia = $dataPengajuan->batas_usia;
        $dataLowonganKerja->jenis_kelamin_laki_laki = $dataPengajuan->jenis_kelamin_laki_laki;
        $dataLowonganKerja->jenis_kelamin_perempuan = $dataPengajuan->jenis_kelamin_perempuan;
        $dataLowonganKerja->tgl_tes = $dataPengajuan->tgl_tes_final;
        $dataLowonganKerja->waktu_tes = $dataPengajuan->waktu_tes;
        $dataLowonganKerja->lokasi = $dataPengajuan->lokasi;
        $dataLowonganKerja->status = $dataPengajuan->status;
        $dataLowonganKerja->info_status = $dataPengajuan->info_status;
        $dataLowonganKerja->save();

        return redirect()->route('detailKerjasama', ['id' => $id]);
    }

    public function terimaUsulan($id)
    {
        $dataPengajuan = PengajuanKerjasama::find($id);

        $dataPengajuan->status = "Diterima";
        $dataPengajuan->info_status = "Menunggu UPKK UB untuk mengunggah lowongan kerja sama";
        $dataPengajuan->tgl_tes_final = $dataPengajuan->tgl_usulan;
        $dataPengajuan->save();

        $dataLowonganKerja = new LowonganKerja;
        $dataLowonganKerja->id = $dataPengajuan->id;
        $dataLowonganKerja->id_user_perusahaan = $dataPengajuan->id_user;
        $dataLowonganKerja->nama_perusahaan = $dataPengajuan->nama_perusahaan;
        $dataLowonganKerja->jenis_kerjasama = $dataPengajuan->jenis_kerjasama;
        $dataLowonganKerja->judul = $dataPengajuan->judul;
        $dataLowonganKerja->batas_usia = $dataPengajuan->batas_usia;
        $dataLowonganKerja->jenis_kelamin_laki_laki = $dataPengajuan->jenis_kelamin_laki_laki;
        $dataLowonganKerja->jenis_kelamin_perempuan = $dataPengajuan->jenis_kelamin_perempuan;
        $dataLowonganKerja->tgl_tes = $dataPengajuan->tgl_tes_final;
        $dataLowonganKerja->waktu_tes = $dataPengajuan->waktu_tes;
        $dataLowonganKerja->lokasi = $dataPengajuan->lokasi;
        $dataLowonganKerja->status = $dataPengajuan->status;
        $dataLowonganKerja->info_status = $dataPengajuan->info_status;
        $dataLowonganKerja->save();

        return redirect()->route('detailKerjasama', ['id' => $id]);
    }

    public function tolakUsulan($id)
    {
        $dataPengajuan = PengajuanKerjasama::find($id);

        $dataPengajuan->status = "Ditolak";
        $dataPengajuan->info_status = "Usulan Jadwal baru ditolak UPKK, kerjasama dibatalkan";
        $dataPengajuan->save();

        global $endpoint;
        $obj = new PengajuanKerjasamaController();
        $result = $obj->endpoint->update(
            "
                PREFIX rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#>
                PREFIX silk: <http://www.silk.com#>
                
                INSERT DATA {
                    <http://www.silk.com#$id> silk:status '$dataPengajuan->status' .
                }
            "
        );

        return redirect()->route('detailKerjasama', ['id' => $id]);
    }

    public function unggahLowonganKerja($id)
    {
        $dataPengajuan = PengajuanKerjasama::find($id);

        $dataPengajuan->status = "Berjalan";
        $dataPengajuan->info_status = "Lowongan kerja telah diunggah, menunggu pelamar untuk mendaftar";
        $dataPengajuan->save();

        $dataLowonganKerja = LowonganKerja::find($id);
        $dataLowonganKerja->status = $dataPengajuan->status;
        $dataLowonganKerja->info_status = $dataPengajuan->info_status;
        $dataLowonganKerja->save();

        return redirect()->route('detailKerjasama', ['id' => $id]);
    }
}
