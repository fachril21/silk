@extends('layouts.app')

@section('content')
<div class="container">
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
                <div class="tab-pane{{old('tab') == 'v-pills-profile' ? ' active' : null}} fade show active" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">
                    <div class="row justify-content-center">
                        <div class="col-md">
                            <div class="card">
                                <div class="card-header">
                                    <b>Profile</b>
                                    <a href="/profilePerusahaan/edit/{{ Auth::user()->id }}">
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
                                                <label for="informasi" class="col-md col-form-label text-md-left">{{ __('Informasi') }}</label>
                                            </div>
                                            <div class="col-sm-8 ">
                                                <label for="informasi" class="col-md col-form-label text-md-left"><b>{{$userData->informasi}}</b></label>
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane{{old('tab') == 'v-pills-change-email' ? ' active' : null}} fade" id="v-pills-change-email" role="tabpanel" aria-labelledby="v-pills-change-email-tab">
                    <div class="card">
                        <div class="card-header">
                            Ubah Email
                        </div>

                        <div class="card-body">
                            @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                            @endif
                            <div class="mt-5">
                                <form method="POST" action="/profilePerusahaan/updateEmail">
                                    @csrf
                                    {{ csrf_field() }}

                                    <div class="form-group row mt-1">
                                        <div class="col-sm-4 ">
                                            <label for="email" class="col-md col-form-label text-md-left">{{ __('Ubah Email') }}</label>
                                        </div>
                                        <div class="col-sm-8 ">
                                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email', $userData->email) }}" required autocomplete="email">

                                            @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row mt-3 float-right">
                                        <div class="col-md-6">
                                            <button type="submit" class="btn btn-primary">
                                                {{ __('Simpan') }}
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane{{old('tab') == 'v-pills-change-password' ? ' active' : null}} fade" id="v-pills-change-password" role="tabpanel" aria-labelledby="v-pills-change-password-tab">
                    <div class="card">
                        <div class="card-header">
                            Ubah Password
                        </div>

                        <div class="card-body">
                            @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                            @endif
                            <div class="mt-5">
                                <form method="POST" action="{{ route('perusahaan.password.update') }}">
                                    @method('patch')
                                    @csrf
                                    <div class="form-group row">
                                        <label for="current_password" class="col-md-4 col-form-label text-md-right">{{ __('Current Password') }}</label>

                                        <div class="col-md-6">
                                            <input id="current_password" type="password" class="form-control @error('current_password') is-invalid @enderror" name="current_password" required autocomplete="current_password">

                                            @error('current_password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                                        <div class="col-md-6">
                                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                            @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                                        <div class="col-md-6">
                                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                                        </div>
                                    </div>

                                    <div class="form-group row mb-0">
                                        <div class="col-md-6 offset-md-4">
                                            <button type="submit" class="btn btn-primary">
                                                Update Password
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    //redirect to specific tab
    $(document).ready(function() {
        $('#v-pills-tab a[href="#{{ old('tab') }}"]').tab('show')
    });
</script>
@endsection