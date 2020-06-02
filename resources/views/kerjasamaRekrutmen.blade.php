@extends('layouts.app')
@section('content')
@include('layouts.sidebar')
<div class="container pt-4">
    <div class="row">
        <div class="col-md ml-5">
            <div class="card">
                <div class="card-header">Pengajuan Kerjasama Rekrutmen</div>

                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif
                    @if(Auth::user()->status == "Perusahaan")
                    <div class='row'>
                        <div class='col'>
                            <a class='float-right' href="{{route('pengajuanKerjasama')}}"><button type="button" class="btn btn-success"><span class="fa fa-plus mr-3"></span>Ajukan Kerjasama</button></a>
                        </div>
                    </div>
                    @endif
                    @if(Auth::user()->status == "Perusahaan")
                    <div class='row mx-2 mt-5'>
                        @if(count($dataPengajuan) == 0)
                        <div class="col-md">
                            <p class="text-center">Anda belum melakukan pengajuan</p> 
                        </div>
                        @else
                        <div class='col-md'>
                            @foreach($dataPengajuan as $row)
                            <div class="card shadow p-3 mb-5 bg-white rounded-lg border-0">
                                <div class="card-body">
                                    <div class='row'>
                                        <div class='col-sm-1 '>
                                            <span class="material-icons" style="font-size: 50px;">
                                                work_outline
                                            </span>
                                        </div>
                                        <div class='col-sm-6  pl-5'>
                                            <div class='row'>
                                                <h5><b>{{$row->judul}}</b></h5>
                                            </div>
                                            <div class='row'>
                                                <span>{{$row->jenis_kerjasama}}</span>
                                            </div>
                                        </div>
                                        <div class='col-sm-2 '>
                                            <h5>{{$row->status}}</h5>
                                        </div>
                                        <div class='col-sm-3 '>
                                            <a href="{{route('detailKerjasama', ['id' => $row->id])}}"><button type="button" class="btn btn-success btn-sm float-right"><span class="fa fa-eye mr-3"></span>Lihat Detail</button></a>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            @endforeach
                        </div>
                        @endif
                    </div>
                    @elseif(Auth::user()->status == "UPKK")
                    <div class='row mx-2 mt-5'>
                        @if(count($dataPengajuan) == 0)
                        <div class="col-md">
                            <p class="text-center">Tidak ada pengajuan Kerjasama</p> 
                        </div>
                        @else
                        <div class='col-md'>
                            @foreach($dataPengajuan as $row)
                            <div class="card shadow p-3 mb-5 bg-white rounded-lg border-0">
                                <div class="card-body">
                                    <div class='row'>
                                        <div class='col-sm-1 '>
                                            <span class="material-icons" style="font-size: 50px;">
                                                work_outline
                                            </span>
                                        </div>
                                        <div class='col-sm-6  pl-5'>
                                            <div class='row'>
                                                <h5><b>{{$row->judul}}</b></h5>
                                            </div>
                                            <div class='row'>
                                                <span>{{$row->jenis_kerjasama}}</span>
                                            </div>
                                        </div>
                                        <div class='col-sm-2 '>
                                            <h5>{{$row->status}}</h5>
                                        </div>
                                        <div class='col-sm-3 '>
                                            <a href="{{route('detailKerjasama', ['id' => $row->id])}}"><button type="button" class="btn btn-success btn-sm float-right"><span class="fa fa-eye mr-3"></span>Lihat Detail</button></a>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            @endforeach
                        </div>
                        @endif
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection