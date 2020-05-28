@extends('layouts.app')

@section('content')
<div class="container">
    @foreach($userDataSkill as $row)
        {{$row->skill}}
    @endforeach
    <div class="row">
        <div class="col-3">
            <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                <a class="nav-link active" id="v-pills-profile-tab" data-toggle="pill" href="#v-pills-profile" role="tab" aria-controls="v-pills-profile" aria-selected="false">Profile</a>
                <a class="nav-link" id="v-pills-change-email-tab" data-toggle="pill" href="#v-pills-change-email" role="tab" aria-controls="v-pills-change-email" aria-selected="false">Change Email</a>
                <a class="nav-link" id="v-pills-change-password-tab" data-toggle="pill" href="#v-pills-change-password" role="tab" aria-controls="v-pills-change-password" aria-selected="false">Change Password</a>
            </div>
        </div>
        <div class="col-9">
            <div class="tab-content" id="v-pills-tabContent">
                <div class="tab-pane fade show active" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">
                    <div class="row justify-content-center">
                        <div class="col-md">
                            <div class="card">
                                <div class="card-header">
                                    <b>Profile</b>
                                    <a href="/profile/edit/{{ Auth::user()->id }}">
                                        <button type="button" class="btn btn-link float-right">Edit Profile</button>
                                    </a>
                                </div>

                                <div class="card-body">
                                    @if (session('status'))
                                    <div class="alert alert-success" role="alert">
                                        {{ session('status') }}
                                    </div>
                                    @endif

                                    <img class="rounded mx-auto d-block" src="{{Auth::user()->getFirstMediaUrl('avatars', 'thumb')}}" alt="{{Auth::user()->getFirstMediaUrl('avatars', 'thumb')}}" height="86" width="86">

                                    <div class="mt-5">
                                        <div class="row">
                                            <div class="col-sm-4 ">
                                                <label for="name" class="col-md col-form-label text-md-left">{{ __('Nama') }}</label>
                                            </div>
                                            <div class="col-sm-8 ">
                                                <label for="name" class="col-md col-form-label text-md-left"><b>{{$userData->nama}}</b></label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-4 ">
                                                <label for="email" class="col-md col-form-label text-md-left">{{ __('Email') }}</label>
                                            </div>
                                            <div class="col-sm-8 ">
                                                <label for="email" class="col-md col-form-label text-md-left"><b>{{$userData->email}}</b></label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-4 ">
                                                <label for="noTel" class="col-md col-form-label text-md-left">{{ __('Nomor Telepon') }}</label>
                                            </div>
                                            <div class="col-sm-8 ">
                                                <label for="noTel" class="col-md col-form-label text-md-left"><b>{{$userData->no_telepon}}</b></label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-4 ">
                                                <label for="tglLahir" class="col-md col-form-label text-md-left">{{ __('Tanggal Lahir') }}</label>
                                            </div>
                                            <div class="col-sm-8 ">
                                                <label for="tglLahir" class="col-md col-form-label text-md-left"><b>{{$userData->tanggal_lahir}}</b></label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-4 ">
                                                <label for="jenisKelamin" class="col-md col-form-label text-md-left">{{ __('Jenis Kelamin') }}</label>
                                            </div>
                                            <div class="col-sm-8 ">
                                                <label for="jenisKelamin" class="col-md col-form-label text-md-left"><b>{{$userData->jenis_kelamin}}</b></label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-4 ">
                                                <label for="biografi" class="col-md col-form-label text-md-left">{{ __('Biografi') }}</label>
                                            </div>
                                            <div class="col-sm-8 ">
                                                <label for="biografi" class="col-md col-form-label text-md-left"><b>{{$userData->biografi}}</b></label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-4 ">
                                                <label for="lulusan" class="col-md col-form-label text-md-left">{{ __('Lulusan') }}</label>
                                            </div>
                                            <div class="col-sm-8 ">
                                                <label for="lulusan" class="col-md col-form-label text-md-left"><b>{{$userData->jurusan}}</b></label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-4 ">
                                                <label for="skill" class="col-md col-form-label text-md-left">{{ __('Keahlian') }}</label>
                                            </div>
                                            <div class="col-sm-8 ">
                                                @foreach($userDataSkill as $row)
                                                <label for="skill" class="col-md col-form-label text-md-left"><b>{{$row->skill}}</b></label>
                                                @endforeach
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-4 ">
                                                <label for="pencapaian" class="col-md col-form-label text-md-left">{{ __('Pencapaian') }}</label>
                                            </div>
                                            <div class="col-sm-8 ">
                                                @foreach($userDataPencapaian as $row)
                                                <label for="pencapaian" class="col-md col-form-label text-md-left"><b>{{$row->pencapaian}}</b></label>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="v-pills-change-email" role="tabpanel" aria-labelledby="v-pills-change-email-tab">

                </div>
                <div class="tab-pane fade" id="v-pills-change-password" role="tabpanel" aria-labelledby="v-pills-change-password-tab">

                </div>
            </div>
        </div>
    </div>

</div>
@endsection