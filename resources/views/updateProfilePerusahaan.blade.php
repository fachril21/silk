@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    Edite Profile
                    <a href="/profilePerusahaan/{{Auth::user()->username}}">
                        <button type="button" class="btn btn-link float-right">Back to Profile</button>
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
                        <form method="POST" action="/profilePerusahaan/update">
                            @csrf
                            {{ csrf_field() }}
                            
                            <div class="form-group row mt-1">
                                <div class="col-sm-4 ">
                                    <label for="name" class="col-md col-form-label text-md-left">{{ __('Nama') }}</label>
                                </div>
                                <div class="col-sm-8 ">
                                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', $userData->nama) }}" required autocomplete="name">

                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row mt-1">
                                <div class="col-sm-4 ">
                                    <label for="newPhone" class="col-md col-form-label text-md-left">{{ __('Nomor Telepon') }}</label>
                                </div>
                                <div class="col-sm-8 ">
                                    <input id="newPhone" type="tel" class="form-control @error('phone') is-invalid @enderror" name="newPhone" value="{{$userData->no_telepon}}" required autocomplete="newPhone">

                                    @error('phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="form-group row mt-1">
                                <div class="col-sm-4 ">
                                    <label for="newInformasi" class="col-md col-form-label text-md-left">{{ __('Informasi') }}</label>
                                </div>
                                <div class="col-sm-8 ">
                                    <textarea id="newInformasi" type="text" class="form-control @error('informasi') is-invalid @enderror" name="newInformasi" required autocomplete="newBiography">{{$userData->informasi}}</textarea>

                                    @error('informasi')
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
    </div>
</div>
@endsection