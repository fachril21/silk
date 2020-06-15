@extends('layouts.app')
@section('content')
@include('layouts.sidebar')
<div class="container pt-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            @if($detailProgresRekrutmen->status == "Terdaftar")
            <div class="alert alert-secondary" role="alert">
                @elseif($detailProgresRekrutmen->status == "Akan Hadir Tes Rekrumen")
                <div class="alert alert-primary" role="alert">
                    @elseif($detailProgresRekrutmen->status == "Telah Menjalani Tes Rekrutmen")
                    <div class="alert alert-primary" role="alert">
                        @elseif($detailProgresRekrutmen->status == "Diterima")
                        <div class="alert alert-success" role="alert">
                            @elseif($detailProgresRekrutmen->status == "Ditolak" || $detailProgresRekrutmen->status == "Tidak Hadir Tes")
                            <div class="alert alert-danger" role="alert">
                                @endif
                                <div class="row mt-1">
                                    <div class="col-sm-4 ">
                                        <label for="status" class="col-md col-form-label text-md-left">{{ __('Progres Rekrutmen Anda') }}</label>
                                    </div>
                                    <div class="col-sm-8 ">
                                        <label for="status" class="col-md col-form-label text-md-left"><b>{{$detailProgresRekrutmen->status}}</b></label>
                                        <label for="status" class="col-md col-form-label text-md-left"><span>{{$detailProgresRekrutmen->info_status}}</span></label>

                                    </div>
                                </div>
                            </div>
                            <div class="card shadow p-3 mb-5 bg-white rounded border-0">
                                <div class="card-body">
                                    <div class="row mx-3">
                                        <div class="col-sm-8 px-0">
                                            <span style="font-size: 20px;"><b>{{$detailProgresRekrutmen->judul}}</b></span>
                                        </div>
                                        @if($detailProgresRekrutmen->status == "Akan Hadir Tes Rekrumen")
                                        <div class="col-sm-4">
                                            <span class="text-success">Anda telah melakukan konfirmasi untuk hadir pada tes rekrutmen</span>
                                        </div>
                                        @elseif($detailProgresRekrutmen->status == "Terdaftar")
                                        <div class="col-sm-4">
                                            <form id="konfirmasiKehadiran" action="{{route('konfirmasiKehadiran', ['id' => $detailProgresRekrutmen->id])}}" method="post">
                                                {{csrf_field()}}
                                                <button type="button" class="btn btn-primary btn-sm float-right" onclick="konfirmasiKehadiran()">Konfirmasi Kehadiran Tes</button>
                                            </form>
                                        </div>
                                        @endif
                                    </div>
                                    <div class="mt-3">
                                        <div class="row mt-1">
                                            <div class="col-sm-4 ">
                                                <label for="tgl_tes_final" class="col-md col-form-label text-md-left">{{ __('Tanggal Tes Rekrutmen') }}</label>
                                            </div>
                                            <div class="col-sm-8 ">
                                                <label for="tgl_tes_final" class="col-md col-form-label text-md-left"><b>{{$detailProgresRekrutmen->tgl_tes_final}}</b></label>
                                            </div>
                                        </div>
                                        <div class="row mt-1">
                                            <div class="col-sm-4 ">
                                                <label for="tgl_tes_final" class="col-md col-form-label text-md-left">{{ __('Waktu Tes Rekrutmen') }}</label>
                                            </div>
                                            <div class="col-sm-8 ">
                                                <label for="tgl_tes_final" class="col-md col-form-label text-md-left"><b>{{$detailProgresRekrutmen->waktu_tes}} WIB</b></label>
                                            </div>
                                        </div>
                                        <div class="row mt-1">
                                            <div class="col-sm-4 ">
                                                <label for="lokasi" class="col-md col-form-label text-md-left">{{ __('Lokasi Tes Rekrutmen') }}</label>
                                            </div>
                                            <div class="col-sm-8 ">
                                                <label for="lokasi" class="col-md col-form-label text-md-left"><b>{{$detailProgresRekrutmen->lokasi}} WIB</b></label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <script>
                    function konfirmasiKehadiran() {
                        swal({
                                title: "Konfirmasi Kehadiran Tes Rekrutmen",
                                text: "Apakah Anda yakin akan hadir pada tes rekrutmen ini?",
                                icon: "warning",
                                buttons: true,
                                dangerMode: false,
                            })
                            .then((willDelete) => {
                                if (willDelete) {
                                    $('#konfirmasiKehadiran').submit();
                                }
                            });
                    }
                </script>
                @endsection