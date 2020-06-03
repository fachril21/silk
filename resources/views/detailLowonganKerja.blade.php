@extends('layouts.app')
@section('content')
@include('layouts.sidebar')
<div class="container pt-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow p-3 mb-5 bg-white rounded border-0">
                <div class="card-body">
                    <div class="row mx-3">
                        <div class="col-sm-8 px-0">
                            <span style="font-size: 20px;"><b>{{$dataKerjasama->judul}}</b></span>
                        </div>
                        <div class="col-sm-4">
                            <a href="#"><button type="button" class="btn btn-primary btn-sm float-right waves-effect waves-light">Daftarkan Diri</button></a>
                        </div>
                    </div>
                    <div class="mt-3">
                        <div class="row">
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
                </div>
            </div>

        </div>
    </div>
</div>
@endsection