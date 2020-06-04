@extends('layouts.app')
@section('content')
@include('layouts.sidebar')
<div class="container pt-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            @if(Auth::user()->status == "Perusahaan" || Auth::user()->status == "UPKK")
            @if($dataKerjasamaDB->status == "Diterima")
            <div class="alert alert-info" role="alert">
                @elseif($dataKerjasamaDB->status == "Diajukan")
                <div class="alert alert-secondary" role="alert">
                    @elseif($dataKerjasamaDB->status == "Ditolak" || $dataKerjasamaDB->status == "Menolak Jadwal Dari UPKK UB")
                    <div class="alert alert-warning" role="alert">
                        @elseif($dataKerjasamaDB->status == "Berjalan")
                        <div class="alert alert-success" role="alert">
                            @elseif($dataKerjasamaDB->status == "Selesai")
                            <div class="alert alert-dark" role="alert">
                                @endif
                                @endif
                                <div class="row mt-1">
                                    <div class="col-sm-4 ">
                                        <label for="status" class="col-md col-form-label text-md-left">{{ __('Status Kerjasama') }}</label>
                                    </div>
                                    <div class="col-sm-8 ">
                                        <label for="status" class="col-md col-form-label text-md-left"><b>{{$dataKerjasamaDB->status}}</b></label>
                                        <label for="status" class="col-md col-form-label text-md-left"><span>{{$dataKerjasamaDB->info_status}}</span></label>

                                    </div>
                                </div>

                            </div>


                            <div class="card">
                                <div class="card-header">
                                    <span>Detail Kerjasama Rekrutmen</span>

                                </div>

                                <div class="card-body">
                                    @if (session('status'))
                                    <div class="alert alert-success" role="alert">
                                        {{ session('status') }}
                                    </div>
                                    @endif

                                    @if(Auth::user()->status == "Perusahaan")
                                    <div class="mt-3">
                                        <div class="row">
                                            <div class="col-sm ">
                                                <label for="judul" style="font-size: 20px;" class="col-md col-form-label text-md-left"><b>{{$dataKerjasama->judul}}</b></label>
                                            </div>
                                        </div>
                                        <div class="row mt-5">
                                            <div class="col-sm-4 ">
                                                <label for="batas_usia" class="col-md col-form-label text-md-left">{{ __('Batas usia maksimal') }}</label>
                                            </div>
                                            <div class="col-sm-8 ">
                                                <label for="batas_usia" class="col-md col-form-label text-md-left"><b>{{$dataKerjasama->batas_usia}} tahun</b></label>
                                            </div>
                                        </div>
                                        <div class="row mt-1">
                                            <div class="col-sm-4 ">
                                                <label for="jenis_kelamin" class="col-md col-form-label text-md-left">{{ __('Jenis Kelamin yang dibutuhkan') }}</label>
                                            </div>
                                            <div class="col-sm-8 ">
                                                @foreach($dataJenisKelamin as $row)
                                                <label for="jenis_kelamin" class="col-md col-form-label text-md-left"><b>{{$row->jenis_kelamin}}</b></label>
                                                @endforeach
                                            </div>
                                        </div>
                                        <div class="row mt-1">
                                            <div class="col-sm-4 ">
                                                <label for="jabatan" class="col-md col-form-label text-md-left">{{ __('Posisi yang ditawarkan') }}</label>
                                            </div>
                                            <div class="col-sm-8 ">
                                                <label for="jabatan" class="col-md col-form-label text-md-left"><b>{{$dataKerjasama->jabatan}}</b></label>
                                            </div>
                                        </div>
                                        <div class="row mt-1">
                                            <div class="col-sm-4 ">
                                                <label for="jurusan" class="col-md col-form-label text-md-left">{{ __('Jurusan yang dibutuhkan') }}</label>
                                            </div>
                                            <div class="col-sm-8 ">
                                                @foreach($dataJurusan as $row)
                                                <label for="jurusan" class="col-md col-form-label text-md-left"><b>{{$row->jurusan}}</b></label>
                                                @endforeach
                                            </div>
                                        </div>
                                        <div class="row mt-1">
                                            <div class="col-sm-4 ">
                                                <label for="keahlian" class="col-md col-form-label text-md-left">{{ __('Keahlian yang dibutuhkan') }}</label>
                                            </div>
                                            <div class="col-sm-8 ">
                                                @foreach($dataKeahlian as $row)
                                                <label for="keahlian" class="col-md col-form-label text-md-left"><b>{{$row->keahlian}}</b></label>
                                                @endforeach
                                            </div>
                                        </div>
                                        <div class="row mt-1">
                                            <div class="col-sm-4 ">
                                                <label for="informasi_pekerjaan" class="col-md col-form-label text-md-left">{{ __('Informasi posisi yang ditawarkan') }}</label>
                                            </div>
                                            <div class="col-sm-8 ">
                                                <label for="informasi_pekerjaan" class="col-md col-form-label text-md-left"><b>{{$dataKerjasama->informasi_pekerjaan}}</b></label>
                                            </div>
                                        </div>
                                        <div class="row mt-1">
                                            <div class="col-sm-4 ">
                                                <label for="gaji" class="col-md col-form-label text-md-left">{{ __('Gaji yang ditawarkan') }}</label>
                                            </div>
                                            <div class="col-sm-8 ">
                                                <label for="gaji" class="col-md col-form-label text-md-left"><b>Rp {{$dataKerjasama->gaji_jabatan}}</b></label>
                                            </div>
                                        </div>

                                    </div>
                                    @elseif(Auth::user()->status == "UPKK")
                                    <div class="mt-3">
                                        <div class="row">
                                            <div class="col-sm-8 ">
                                                <label for="judul" style="font-size: 20px;" class="col-md col-form-label text-md-left"><b>{{$dataKerjasama->judul}}</b></label>
                                            </div>
                                            @if(Auth::user()->status == "UPKK" && $dataKerjasamaDB->info_status == "Menunggu UPKK UB untuk mengunggah lowongan kerja sama")
                                            <form class="col-sm-4" id="unggahLowonganKerja" action="{{route('unggahLowonganKerja', ['id' => $dataKerjasamaDB->id])}}" method="post">
                                                {{csrf_field()}}
                                                <button type="button" class="btn btn-success btn-sm float-right" onclick="unggahLowonganKerja()">Unggah Lowongan Kerja</button>
                                            </form>
                                            @endif
                                        </div>
                                        <div class="row mt-5">
                                            <div class="col-sm-4 ">
                                                <label for="batas_usia" class="col-md col-form-label text-md-left">{{ __('Batas usia maksimal') }}</label>
                                            </div>
                                            <div class="col-sm-8 ">
                                                <label for="batas_usia" class="col-md col-form-label text-md-left"><b>{{$dataKerjasama->batas_usia}} tahun</b></label>
                                            </div>
                                        </div>
                                        <div class="row mt-1">
                                            <div class="col-sm-4 ">
                                                <label for="jenis_kelamin" class="col-md col-form-label text-md-left">{{ __('Jenis Kelamin yang dibutuhkan') }}</label>
                                            </div>
                                            <div class="col-sm-8 ">
                                                @foreach($dataJenisKelamin as $row)
                                                <label for="jenis_kelamin" class="col-md col-form-label text-md-left"><b>{{$row->jenis_kelamin}}</b></label>
                                                @endforeach
                                            </div>
                                        </div>
                                        <div class="row mt-1">
                                            <div class="col-sm-4 ">
                                                <label for="jabatan" class="col-md col-form-label text-md-left">{{ __('Posisi yang ditawarkan') }}</label>
                                            </div>
                                            <div class="col-sm-8 ">
                                                <label for="jabatan" class="col-md col-form-label text-md-left"><b>{{$dataKerjasama->jabatan}}</b></label>
                                            </div>
                                        </div>
                                        <div class="row mt-1">
                                            <div class="col-sm-4 ">
                                                <label for="jurusan" class="col-md col-form-label text-md-left">{{ __('Jurusan yang dibutuhkan') }}</label>
                                            </div>
                                            <div class="col-sm-8 ">
                                                @foreach($dataJurusan as $row)
                                                <label for="jurusan" class="col-md col-form-label text-md-left"><b>{{$row->jurusan}}</b></label>
                                                @endforeach
                                            </div>
                                        </div>
                                        <div class="row mt-1">
                                            <div class="col-sm-4 ">
                                                <label for="keahlian" class="col-md col-form-label text-md-left">{{ __('Keahlian yang dibutuhkan') }}</label>
                                            </div>
                                            <div class="col-sm-8 ">
                                                @foreach($dataKeahlian as $row)
                                                <label for="keahlian" class="col-md col-form-label text-md-left"><b>{{$row->keahlian}}</b></label>
                                                @endforeach
                                            </div>
                                        </div>
                                        <div class="row mt-1">
                                            <div class="col-sm-4 ">
                                                <label for="informasi_pekerjaan" class="col-md col-form-label text-md-left">{{ __('Informasi posisi yang ditawarkan') }}</label>
                                            </div>
                                            <div class="col-sm-8 ">
                                                <label for="informasi_pekerjaan" class="col-md col-form-label text-md-left"><b>{{$dataKerjasama->informasi_pekerjaan}}</b></label>
                                            </div>
                                        </div>
                                        <div class="row mt-1">
                                            <div class="col-sm-4 ">
                                                <label for="gaji" class="col-md col-form-label text-md-left">{{ __('Gaji yang ditawarkan') }}</label>
                                            </div>
                                            <div class="col-sm-8 ">
                                                <label for="gaji" class="col-md col-form-label text-md-left"><b>Rp {{$dataKerjasama->gaji_jabatan}}</b></label>
                                            </div>
                                        </div>

                                        @if($dataKerjasamaDB->status == "Diajukan")
                                        <div class="row mt-3 float-right">
                                            <div class="col-sm-4 mx-2">
                                                <form id="tolakKerjasama" action="{{route('tolakKerjasama', ['id' => $dataKerjasamaDB->id])}}" method="post">
                                                    {{csrf_field()}}
                                                    <button type="button" class="btn btn-outline-danger btn-sm" style="width: 100px;" onclick="tolakKerjasama()">Tolak</button>
                                                </form>
                                            </div>
                                            <div class="col-sm-4 mx-2">
                                                <button type="button" class="btn btn-success btn-sm" style="width: 100px;" data-toggle="modal" data-target="#terimaKerjasamaModal">Terima</button>
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                    @endif
                                </div>
                            </div>
                            @if((Auth::user()->status == "Perusahaan" || Auth::user()->status == "UPKK") && ($dataKerjasamaDB->status == "Diterima" || $dataKerjasamaDB->status == "Menolak Jadwal Dari UPKK UB" || $dataKerjasamaDB->status == "Berjalan"))
                            <div class="card my-2">
                                <div class="card-header">Jadwal yang ditawarkan pihak UPKK UB</div>

                                <div class="card-body">
                                    @if (session('status'))
                                    <div class="alert alert-success" role="alert">
                                        {{ session('status') }}
                                    </div>
                                    @endif

                                    <div class="mt-3">
                                        <div class="row mt-5">
                                            <div class="col-sm-4 ">
                                                <label for="tgl_tawaran" class="col-md col-form-label text-md-left">{{ __('Jadwal yang ditawarkan') }}</label>
                                            </div>
                                            <div class="col-sm-8 ">
                                                <label for="tgl_tawaran" class="col-md col-form-label text-md-left"><b>{{$dataKerjasamaDB->tgl_tawaran}}</b></label>
                                            </div>
                                        </div>
                                        <div class="row mt-1">
                                            <div class="col-sm-4 ">
                                                <label for="waktu_tes" class="col-md col-form-label text-md-left">{{ __('Waktu Tes Rekrutmen') }}</label>
                                            </div>
                                            <div class="col-sm-8 ">
                                                <label for="waktu_tes" class="col-md col-form-label text-md-left"><b>{{$dataKerjasamaDB->waktu_tes_format}}</b></label>
                                            </div>
                                        </div>
                                        <div class="row mt-1">
                                            <div class="col-sm-4 ">
                                                <label for="lokasi" class="col-md col-form-label text-md-left">{{ __('Lokasi Tes Rekrutmen') }}</label>
                                            </div>
                                            <div class="col-sm-8 ">
                                                <label for="lokasi" class="col-md col-form-label text-md-left"><b>{{$dataKerjasamaDB->lokasi}}</b></label>
                                            </div>
                                        </div>

                                        @if(Auth::user()->status == "Perusahaan" && $dataKerjasamaDB->info_status == "Menunggu konfirmasi oleh pihak Perusahaan dari jadwal yang telah diajukan oleh UPKK UB")
                                        <div class="row mt-3 float-right">
                                            <div class="col-sm-4 mx-2">
                                                <button type="button" class="btn btn-outline-danger  btn-sm" style="width: 100px;" data-toggle="modal" data-target="#tolakJadwalModal">Tolak Jadwal</button>
                                            </div>
                                            <div class="col-sm-4 mx-2">
                                                <form id="terimaJadwal" action="{{route('terimaJadwal', ['id' => $dataKerjasamaDB->id])}}" method="post">
                                                    {{csrf_field()}}
                                                    <button type="button" class="btn btn-success btn-sm" style="width: 100px;" onclick="terimaJadwal()">Terima Jadwal</button>
                                                </form>
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @endif
                            @if((Auth::user()->status == "Perusahaan" || Auth::user()->status == "UPKK") && ($dataKerjasamaDB->status == "Menolak Jadwal Dari UPKK UB" || $dataKerjasamaDB->info_status == "Menunggu UPKK UB untuk mengunggah lowongan kerja sama" || $dataKerjasamaDB->status == "Berjalan"))
                            <div class="card my-2">
                                <div class="card-header">Jadwal yang diusulkan kembali oleh pihak Perusahaan</div>

                                <div class="card-body">
                                    @if (session('status'))
                                    <div class="alert alert-success" role="alert">
                                        {{ session('status') }}
                                    </div>
                                    @endif

                                    <div class="mt-3">
                                        <div class="row mt-5">
                                            <div class="col-sm-4 ">
                                                <label for="tgl_usulan" class="col-md col-form-label text-md-left">{{ __('Jadwal yang diusulkan') }}</label>
                                            </div>
                                            <div class="col-sm-8 ">
                                                <label for="tgl_usulan" class="col-md col-form-label text-md-left"><b>{{$dataKerjasamaDB->tgl_usulan}}</b></label>
                                            </div>
                                        </div>
                                        <div class="row mt-1">
                                            <div class="col-sm-4 ">
                                                <label for="alasan_usulan" class="col-md col-form-label text-md-left">{{ __('Alasan menolak jadwal dari UPKK UB') }}</label>
                                            </div>
                                            <div class="col-sm-8 ">
                                                <label for="alasan_usulan" class="col-md col-form-label text-md-left"><b>{{$dataKerjasamaDB->alasan_usulan}}</b></label>
                                            </div>
                                        </div>

                                        @if(Auth::user()->status == "UPKK" && $dataKerjasamaDB->status == "Menolak Jadwal Dari UPKK UB")
                                        <div class="row mt-3 float-right">
                                            <div class="col-sm-4 mx-2">
                                                <form id="tolakUsulan" action="{{route('tolakUsulan', ['id' => $dataKerjasamaDB->id])}}" method="post">
                                                    {{csrf_field()}}
                                                    <button type="button" class="btn btn-outline-danger btn-sm" style="width: 100px;" onclick="tolakUsulan()">Tolak Usulan</button>
                                                </form>
                                            </div>
                                            <div class="col-sm-4 mx-2">
                                                <form id="terimaUsulan" action="{{route('terimaUsulan', ['id' => $dataKerjasamaDB->id])}}" method="post">
                                                    {{csrf_field()}}
                                                    <button type="button" class="btn btn-success btn-sm" style="width: 100px;" onclick="terimaUsulan()">Terima Usulan</button>
                                                </form>
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="terimaKerjasamaModal" tabindex="-1" role="dialog" aria-labelledby="terimaKerjasamaModal" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Terima Kerjasama Rekrutmen</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="row mx-3">
                                    <p>Mohon untuk mengisikan jadwal dan lokasi tes rekrutmen untuk diajukan kembali kepada pihak perusahaan</p>
                                </div>
                                <form method="POST" action="{{route('terimaKerjasama', ['id' => $dataKerjasamaDB->id])}}" id="form">
                                    @csrf
                                    {{ csrf_field() }}

                                    <div class="form-group row mt-1">
                                        <div class="col-sm-4 ">
                                            <label for="tgl_tawaran" class="col-md col-form-label text-md-left">{{ __('Ajukan Tanggal') }}</label>
                                        </div>
                                        <div class="col-sm-8 ">
                                            <input id="tgl_tawaran" type="text" class="form-control datepicker" name="tgl_tawaran" value="{{ old('tgl_tawaran') }}" required autocomplete="tgl_tawaran">
                                            <!-- <input type="text" id="birth_date" name="birth_date"> -->
                                            <script>
                                                $("#tgl_tawaran").datepicker({
                                                    dateFormat: "yy-mm-dd",
                                                    changeMonth: true,
                                                    changeYear: true
                                                });
                                            </script>
                                            @error('date')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row mt-1">
                                        <div class="col-sm-4 ">
                                            <label for="waktu_tes" class="col-md col-form-label text-md-left">{{ __('Waktu Mulai Tes') }}</label>
                                        </div>
                                        <div class="col-sm-8 ">
                                            <input id="waktu_tes" type="time" class="form-control" name="waktu_tes" value="{{ old('waktu_tes') }}" required autocomplete="waktu_tes">
                                            <!-- <input type="text" id="birth_date" name="birth_date"> -->

                                            @error('waktu_tes')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row mt-1">
                                        <div class="col-sm-4 ">
                                            <label for="lokasi" class="col-md col-form-label text-md-left">{{ __('Lokasi Tes Rekrutmen') }}</label>
                                        </div>
                                        <div class="col-sm-8 ">
                                            <textarea id="lokasi" type="text" class="form-control @error('lokasi') is-invalid @enderror" name="lokasi" required autocomplete="lokasi"></textarea>

                                            @error('lokasi')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row mt-3 float-right">
                                        <div class="col-md">
                                            <button type="submit" class="btn btn-primary">
                                                {{ __('Ajukan Jadwal') }}
                                            </button>
                                        </div>
                                        <script>
                                            $(document).on('submit', '[id^=form]', function(e) {
                                                e.preventDefault();
                                                var data = $(this).serialize();
                                                swal("Apakah anda yakin akan mengajukan jadwal tes rekrutmen ini?", {
                                                        icon: "info",
                                                        buttons: {
                                                            cancel: "Tidak",
                                                            confirm: {
                                                                text: "Ajukan",
                                                                value: "ajukan",
                                                            },
                                                        },
                                                    })
                                                    .then((value) => {
                                                        switch (value) {

                                                            case "ajukan":
                                                                // swal("Pengajuan diajukan");
                                                                $('#form').submit();
                                                                break;

                                                            default:
                                                                swal("Pengajuan dibatalkan");
                                                        }
                                                    });
                                                return false;
                                            });
                                        </script>
                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="modal fade" id="tolakJadwalModal" tabindex="-1" role="dialog" aria-labelledby="tolakJadwalModal" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Usulkan Jadwal Baru Rekrutmen</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="row mx-3">
                                    <p>Mohon untuk mengisikan jadwal usulan baru dan alasan menolak jadwal yang telah ditawarkan oleh UPKK UB</p>
                                </div>
                                <form method="POST" action="{{route('usulanJadwal', ['id' => $dataKerjasamaDB->id])}}" id="formJadwalBaru">
                                    @csrf
                                    {{ csrf_field() }}

                                    <div class="form-group row mt-1">
                                        <div class="col-sm-4 ">
                                            <label for="tgl_usulan" class="col-md col-form-label text-md-left">{{ __('Ajukan Tanggal Baru') }}</label>
                                        </div>
                                        <div class="col-sm-8 ">
                                            <input id="tgl_usulan" type="text" class="form-control datepicker" name="tgl_usulan" value="{{ old('tgl_usulan') }}" required autocomplete="tgl_usulan">
                                            <!-- <input type="text" id="birth_date" name="birth_date"> -->
                                            <script>
                                                $("#tgl_usulan").datepicker({
                                                    dateFormat: "yy-mm-dd",
                                                    changeMonth: true,
                                                    changeYear: true
                                                });
                                            </script>
                                            @error('date')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row mt-1">
                                        <div class="col-sm-4 ">
                                            <label for="alasan_usulan" class="col-md col-form-label text-md-left">{{ __('Alasan menolak jadwal dari UPKK UB') }}</label>
                                        </div>
                                        <div class="col-sm-8 ">
                                            <textarea id="alasan_usulan" type="text" class="form-control @error('alasan_usulan') is-invalid @enderror" name="alasan_usulan" required autocomplete="alasan_usulan"></textarea>

                                            @error('alasan_usulan')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row mt-3 float-right">
                                        <div class="col-md">
                                            <button type="submit" class="btn btn-primary">
                                                {{ __('Ajukan Jadwal Baru') }}
                                            </button>
                                        </div>
                                        <script>
                                            $(document).on('submit', '[id^=formJadwalBaru]', function(e) {
                                                e.preventDefault();
                                                var data = $(this).serialize();
                                                swal("Apakah anda yakin akan mengajukan jadwal tes rekrutmen ini?", {
                                                        icon: "info",
                                                        buttons: {
                                                            cancel: "Tidak",
                                                            confirm: {
                                                                text: "Ajukan",
                                                                value: "ajukan",
                                                            },
                                                        },
                                                    })
                                                    .then((value) => {
                                                        switch (value) {

                                                            case "ajukan":
                                                                // swal("Pengajuan diajukan");
                                                                $('#formJadwalBaru').submit();
                                                                break;

                                                            default:
                                                                swal("Pengajuan dibatalkan");
                                                        }
                                                    });
                                                return false;
                                            });
                                        </script>
                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>
                <script>
                    function tolakKerjasama() {
                        swal({
                                title: "Konfirmasi Persetujuan Kerjasama Rekrutmen",
                                text: "Apakah Anda yakin menolak kerjasama rekrutmen ini?",
                                icon: "warning",
                                buttons: true,
                                dangerMode: true,
                            })
                            .then((willDelete) => {
                                if (willDelete) {
                                    $('#tolakKerjasama').submit();
                                }
                            });
                    }

                    function terimaJadwal() {
                        swal({
                                title: "Konfirmasi Jadwal Tes Rekrutmen",
                                text: "Apakah Anda yakin menerima jadwal ini?",
                                icon: "warning",
                                buttons: true,
                                dangerMode: false,
                            })
                            .then((willDelete) => {
                                if (willDelete) {
                                    $('#terimaJadwal').submit();
                                }
                            });
                    }

                    function terimaUsulan() {
                        swal({
                                title: "Konfirmasi Usulan Jadwal Tes Rekrutmen",
                                text: "Apakah Anda yakin menerima usulan jadwal ini?",
                                icon: "warning",
                                buttons: true,
                                dangerMode: false,
                            })
                            .then((willDelete) => {
                                if (willDelete) {
                                    $('#terimaUsulan').submit();
                                }
                            });
                    }

                    function tolakUsulan() {
                        swal({
                                title: "Konfirmasi Usulan Jadwal Tes Rekrutmen",
                                text: "Apakah Anda yakin menolak usulan jadwal ini?",
                                icon: "warning",
                                buttons: true,
                                dangerMode: true,
                            })
                            .then((willDelete) => {
                                if (willDelete) {
                                    $('#tolakUsulan').submit();
                                }
                            });
                    }

                    function unggahLowonganKerja() {
                        swal({
                                title: "Konfirmasi Unggah Lowongan Kerja",
                                text: "Apakah Anda yakin ingin mengunggah lowongan kerja ini?",
                                icon: "warning",
                                buttons: true,
                                dangerMode: false,
                            })
                            .then((willDelete) => {
                                if (willDelete) {
                                    $('#unggahLowonganKerja').submit();
                                }
                            });
                    }
                </script>
                @endsection