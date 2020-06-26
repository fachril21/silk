@extends('layouts.app')
@section('content')
@include('layouts.sidebar')
<div class="container pt-4">
    <div class="row">
        <div class="col-md ml-5">
            
            <div class="col-md-8">
                @foreach($progresRekrutmen as $row)
                <div class="card shadow p-3 mb-5 bg-white rounded border-0 card-lowongan-kerja">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-8">
                                <div class="row">
                                    <span style="font-size: 16px;"><b>{{$row->judul}}</b></span>
                                </div>
                                <div class="row">
                                    <a href="{{route('profile.perusahaan', ['username' => $row->username_perusahaan])}}"><span>{{$row->nama_perusahaan}}</span></a>
                                </div>
                                <div class="row">
                                    <span>{{$row->tgl_tes_final}}</span>
                                </div>
                                <div class="row">
                                    <span>{{$row->waktu_tes}}</span>
                                </div>
                                <div class="row">
                                    <span>{{$row->lokasi}}</span>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <a href="{{route('detailProgresKerjasama', ['id' => $row->id_lowongan])}}" class="float-right text-primary">Lihat Detail</a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection