@extends('layouts.app')
@section('content')
@include('layouts.sidebar')
<div class="container pt-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            @if($detailProgresRekrutmen->status == "Diterima")
            <div class="alert alert-info" role="alert">
                @elseif($detailProgresRekrutmen->status == "Diajukan")
                <div class="alert alert-secondary" role="alert">
                    @elseif($detailProgresRekrutmen->status == "Ditolak" || $detailProgresRekrutmen->status == "Menolak Jadwal Dari UPKK UB")
                    <div class="alert alert-warning" role="alert">
                        @elseif($detailProgresRekrutmen->status == "Berjalan" || $detailProgresRekrutmen->status == "Menunggu Hasil Seleksi")
                        <div class="alert alert-success" role="alert">
                            @elseif($detailProgresRekrutmen->status == "Selesai")
                            <div class="alert alert-dark" role="alert">
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
                            @if($detailProgresRekrutmen->status == "Berjalan" && Auth::user()->status == "UPKK")
                            <div class="alert alert-warning" role="alert">
                                Mohon untuk melakukan konfirmasi kehadiran peserta saat tes rekrutmen berlangsung pada data peserta di halaman ini
                            </div>
                            @endif
                            @if($detailProgresRekrutmen->status == "Berjalan" && Auth::user()->status == "Perusahaan")
                            <div class="card shadow p-3 mb-5 bg-white rounded border-0">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-8">
                                            <b><span>Konfirmasi tes rekrutmen telah dilakukan</span></b>
                                        </div>
                                        <div class="col-sm-4">
                                            <form id="konfirmasiTesSelesai" action="{{route('konfirmasiTesSelesai', ['id' => $detailProgresRekrutmen->id_lowongan])}}" method="post">
                                                {{csrf_field()}}
                                                <button type="button" class="btn btn-primary btn-sm float-right" onclick="konfirmasiTesSelesai()">Konfirmasi Tes Selesai</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif
                            <div class="card shadow p-3 mb-5 bg-white rounded border-0">
                                <div class="card-body">
                                    <div class="row mx-3">
                                        <div class="col-sm-8 px-0">
                                            <span style="font-size: 20px;"><b>{{$detailProgresRekrutmen->judul}}</b></span>
                                        </div>
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

                            <div class="card shadow p-3 mb-5 bg-white rounded border-0">
                                <div class="card-body">
                                    <table id="daftarPeserta" class="stripe" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>Nama Peserta</th>
                                                <th>Nomor Telepon</th>
                                                <th>Email</th>
                                                <th>Status Peserta</th>
                                                @if($detailProgresRekrutmen->status == "Menunggu Hasil Seleksi")
                                                <th>Action</th>
                                                @endif
                                                @if(Auth::user()->status == "UPKK")
                                                <th>Konfirmasi Kehadiran Peserta</th>
                                                @endif
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($daftarPeserta as $row)
                                            <tr>
                                                <td><a href="{{route('profile', ['username' => $row->username_peserta])}}"><b>{{$row->nama_peserta}}</b></a></td>
                                                <td>{{$row->no_telepon}}</td>
                                                <td>{{$row->email}}</td>
                                                <td>{{$row->status}}</td>
                                                @if($detailProgresRekrutmen->status == "Menunggu Hasil Seleksi")
                                                <td>
                                                    @if($row->status == "Telah Menjalani Tes Rekrutmen")
                                                    <div class="row justify-content-center">
                                                        <form id="tolakPeserta" action="{{route('tolakPeserta', ['id' => $row->id])}}" method="post">
                                                            {{csrf_field()}}
                                                            <button type="button" style="width: 100px;" class="btn btn-danger btn-sm float-right" onclick="tolakPeserta()">Tolak</button>
                                                        </form>
                                                    </div>
                                                    <div class="row mt-1 justify-content-center">
                                                        <form id="terimaPeserta" action="{{route('terimaPeserta', ['id' => $row->id])}}" method="post">
                                                            {{csrf_field()}}
                                                            <button type="button" style="width: 100px;" class="btn btn-primary btn-sm float-right" onclick="terimaPeserta()">Terima</button>
                                                        </form>
                                                    </div>
                                                    @endif
                                                </td>
                                                @endif
                                                @if(Auth::user()->status == "UPKK")
                                                <td>
                                                    <div class="row justify-content-center">
                                                        @if($row->status != "Telah Menjalani Tes Rekrutmen" && $row->status != "Diterima" && $row->status != "Ditolak")
                                                        <form id="konfirmasiKehadiranPeserta" action="{{route('konfirmasiKehadiranTes', ['id' => $row->id])}}" method="post">
                                                            {{csrf_field()}}
                                                            <button type="button" class="btn btn-primary btn-sm float-right" onclick="konfirmasiKehadiranPeserta()">Konfirmasi Kehadiran Tes</button>
                                                        </form>
                                                        @else
                                                        Telah dikonfirmasi
                                                        @endif
                                                    </div>
                                                </td>
                                                @endif
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <script>
                                        $(document).ready(function() {
                                            $('#daftarPeserta').DataTable();


                                        });
                                        konfirmasiTesSelesai

                                        function konfirmasiTesSelesai() {
                                            swal({
                                                    title: "Konfirmasi Tes Selesai Dilaksanakan",
                                                    text: "Apakah Anda yakin ingin melakukan konfirmasi untuk menyelesaikan tes rekrutmen ini?",
                                                    icon: "warning",
                                                    buttons: true,
                                                    dangerMode: false,
                                                })
                                                .then((willDelete) => {
                                                    if (willDelete) {
                                                        $('#konfirmasiTesSelesai').submit();
                                                    }
                                                });
                                        }

                                        function konfirmasiKehadiranPeserta() {
                                            swal({
                                                    title: "Konfirmasi Kehadiran Peserta Tes",
                                                    text: "Apakah Anda yakin ingin melakukan konfirmasi pada peserta rekrutmen ini?",
                                                    icon: "warning",
                                                    buttons: true,
                                                    dangerMode: false,
                                                })
                                                .then((willDelete) => {
                                                    if (willDelete) {
                                                        $('#konfirmasiKehadiranPeserta').submit();
                                                    }
                                                });
                                        }

                                        function tolakPeserta() {
                                            swal({
                                                    title: "Konfirmasi Untuk Menolak Pelamar",
                                                    text: "Apakah Anda yakin ingin menolak pelamar pada rekrutmen ini?",
                                                    icon: "warning",
                                                    buttons: true,
                                                    dangerMode: false,
                                                })
                                                .then((willDelete) => {
                                                    if (willDelete) {
                                                        $('#tolakPeserta').submit();
                                                    }
                                                });
                                        }

                                        function terimaPeserta() {
                                            swal({
                                                    title: "Konfirmasi Untuk Menerima Pelamar",
                                                    text: "Apakah Anda yakin ingin menerima pelamar pada rekrutmen ini?",
                                                    icon: "warning",
                                                    buttons: true,
                                                    dangerMode: false,
                                                })
                                                .then((willDelete) => {
                                                    if (willDelete) {
                                                        $('#terimaPeserta').submit();
                                                    }
                                                });
                                        }
                                    </script>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                @endsection