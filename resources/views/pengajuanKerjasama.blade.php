@extends('layouts.app')
@section('content')
@include('layouts.sidebar')
<div class="container pt-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Form Kerjasama Rekrutmen</div>

                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif
                    <div class="row justify-content-center">
                        <div class="mt-5">
                            <form method="POST" action="/pengajuanKerjasama/upload" id="form">
                                @csrf
                                {{ csrf_field() }}

                                <div class="form-group row mt-1">
                                    <div class="col-sm-4 ">
                                        <label for="jenisKerjasama" class="col-md col-form-label text-md-left">{{ __('Jenis Kerjasama') }}</label>
                                    </div>
                                    <div class="col-sm-8 ">
                                        <select class="custom-select" id="jenisKerjasama" name="jenisKerjasama">
                                            <option selected disabled>Pilih jenis kerjasama</option>
                                            <option value="Rekrutmen Dalam Kampus">Rekrutmen Dalam Kampus</option>
                                            <option value="Rekrutmen Luar Kampus">Rekrutmen Luar Kampus</option>
                                        </select>
                                        @error('jenisKerjasama')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row mt-1">
                                    <div class="col-sm-4 ">
                                        <label for="judul" class="col-md col-form-label text-md-left">{{ __('Judul') }}</label>
                                    </div>
                                    <div class="col-sm-8 ">
                                        <input id="judul" type="text" class="form-control @error('judul') is-invalid @enderror" name="judul" required autocomplete="judul">

                                        @error('judul')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row mt-1">
                                    <div class="col-sm-4 ">
                                        <label for="batasUsia" class="col-md col-form-label text-md-left">{{ __('Batas Usia Maksimal') }}</label>
                                    </div>
                                    <div class="col-sm-8 ">
                                        <select class="custom-select" id="batasUsia" name="batasUsia">
                                            <option selected disabled>Pilih batas usia maksimal</option>
                                            @for($i=17 ; $i<=35 ; $i++) <option value="{{$i}}">{{$i}}</option>
                                                @endfor
                                        </select>
                                        @error('batasUsia')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row mt-1">
                                    <div class="col-sm-4 ">
                                        <label for="jenisKelamin" class="col-md col-form-label text-md-left">{{ __('Jenis Kelamin yang dibutuhkan') }}</label>
                                    </div>
                                    <div class="col-sm-8 ">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="jenisKelaminLakiLaki" name="jenisKelaminLakiLaki" value="1">
                                            <label class="form-check-label" for="jenisKelaminLakiLaki">
                                                Laki-laki
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="jenisKelaminPerempuan" name="jenisKelaminPerempuan" value="1">
                                            <label class="form-check-label" for="jenisKelaminPerempuan">
                                                Perempuan
                                            </label>
                                        </div>
                                        @error('jenisKelamin')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row mt-1">
                                    <div class="col-sm-4 ">
                                        <label for="lulusanPelamar" class="col-md col-form-label text-md-left">{{ __('Lulusan yang dibutuhkan') }}</label>
                                    </div>
                                    <div class="col-sm-8 ">
                                        <input id="lulusanPelamar" type="text" class="form-control @error('lulusanPelamar') is-invalid @enderror" name="lulusanPelamar" required autocomplete="lulusanPelamar">

                                        @error('lulusanPelamar')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row mt-1">
                                    <div class="col-sm-4 ">
                                        <label for="posisi" class="col-md col-form-label text-md-left">{{ __('Posisi yang ditawarkan') }}</label>
                                    </div>
                                    <div class="col-sm-8 ">
                                        <input id="posisi" type="text" class="form-control @error('posisi') is-invalid @enderror" name="posisi" required autocomplete="posisi">

                                        @error('posisi')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row mt-1">
                                    <div class="col-sm-4 ">
                                        <label for="informasiPosisi" class="col-md col-form-label text-md-left">{{ __('Informasi posisi yang ditawarkan') }}</label>
                                    </div>
                                    <div class="col-sm-8 ">
                                        <textarea id="informasiPosisi" type="text" class="form-control @error('informasiPosisi') is-invalid @enderror" name="informasiPosisi" required autocomplete="informasiPosisi"></textarea>

                                        @error('informasiPosisi')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row mt-1">
                                    <div class="col-sm-4 ">
                                        <label for="gajiDitawarkan" class="col-md col-form-label text-md-left">{{ __('Gaji yang ditawarkan') }}</label>
                                    </div>
                                    <div class="col-sm-8 ">
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="basic-addon1">Rp</span>
                                            </div>
                                            <input id="gajiDitawarkan" type="text" class="form-control @error('gajiDitawarkan') is-invalid @enderror" name="gajiDitawarkan" required autocomplete="gajiDitawarkan">

                                        </div>
                                        @error('gajiDitawarkan')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row mt-3 float-right">
                                    <div class="col-md">
                                        <button type="submit" class="btn btn-primary">
                                            {{ __('Ajukan Kerjasama') }}
                                        </button>
                                    </div>
                                    <script>
                                        $(document).on('submit', '[id^=form]', function(e) {
                                            e.preventDefault();
                                            var data = $(this).serialize();
                                            swal("Apakah anda yakin akan mengajukan kerjasama ini?", {
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
        </div>
    </div>
</div>
@endsection