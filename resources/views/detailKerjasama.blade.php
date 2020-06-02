@extends('layouts.app')
@section('content')
@include('layouts.sidebar')
<div class="container pt-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Detail Kerjasama Rekrutmen</div>

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
                    @elseif(Auth::user()->status == "UPKK")
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
                        <div class="row mt-1">
                            <div class="col-sm-4 ">
                                <label for="status" class="col-md col-form-label text-md-left">{{ __('Status Kerjasama') }}</label>
                            </div>
                            <div class="col-sm-8 ">
                                <label for="status" class="col-md col-form-label text-md-left"><b>{{$dataKerjasamaDB->status}}</b></label>
                                <label for="status" class="col-md col-form-label text-md-left"><span>{{$dataKerjasamaDB->info_status}}</span></label>
                                
                                
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
</script>
@endsection