@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    Edite Profile
                    <a href="/profile/{{Auth::user()->username}}">
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
                        <form method="POST" action="/profile/update">
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
                                    <label for="tglLahir" class="col-md col-form-label text-md-left">{{ __('Tanggal Lahir') }}</label>
                                </div>
                                <div class="col-sm-8 ">
                                    <label for="tglLahir" class="col-md col-form-label text-md-left"><b>{{$userData->tanggal_lahir}}</b></label>
                                </div>
                            </div>
                            <div class="form-group row mt-1">
                                <div class="col-sm-4 ">
                                    <label for="jenisKelamin" class="col-md col-form-label text-md-left">{{ __('Jenis Kelamin') }}</label>
                                </div>
                                <div class="col-sm-8 ">
                                    <label for="jenisKelamin" class="col-md col-form-label text-md-left"><b>{{$userData->jenis_kelamin}}</b></label>
                                </div>
                            </div>
                            <div class="form-group row mt-1">
                                <div class="col-sm-4 ">
                                    <label for="newBiography" class="col-md col-form-label text-md-left">{{ __('Biografi') }}</label>
                                </div>
                                <div class="col-sm-8 ">
                                    <textarea id="newBiography" type="text" class="form-control @error('name') is-invalid @enderror" name="newBiography" required autocomplete="newBiography">{{$userData->biografi}}</textarea>

                                    @error('biography')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row mt-1">
                                <div class="col-sm-4 ">
                                    <label for="newMajor" class="col-md col-form-label text-md-left">{{ __('Lulusan') }}</label>
                                </div>
                                <div class="col-sm-8 ">
                                    <input id="newMajor" type="text" class="form-control @error('major') is-invalid @enderror" name="newMajor" value="{{$userData->jurusan}}" required autocomplete="newMajor">

                                    @error('major')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row mt-1">
                                <div class="col-sm-4 ">
                                    <label for="newSkill" class="col-md col-form-label text-md-left">{{ __('Keahlian') }}</label>
                                </div>
                                <div class="col-sm-8 ">
                                    <div class="wrapper_updateSkill">
                                        @foreach($userDataSkill as $row)
                                        <div><input id="newSkill" type="text" class="form-control @error('skill') is-invalid @enderror" name="newSkill[]" value="{{$row->skill}}" required autocomplete="newSkill" /><a href="javascript:void(0);" class="remove_field">Remove</a></div>
                                        @endforeach
                                    </div>
                                    <p><button class="add_fields_updateSkill">Add More Fields</button></p>
                                </div>
                            </div>
                            <div class="form-group row mt-1">
                                <div class="col-sm-4 ">
                                    <label for="newAchievment" class="col-md col-form-label text-md-left">{{ __('Pencapaian') }}</label>
                                </div>
                                <div class="col-sm-8 ">
                                    <div class="wrapper_updateAch">
                                        @foreach($userDataPencapaian as $row)
                                        <div><input id="newAchievment" type="text" class="form-control @error('skill') is-invalid @enderror" name="newAchievment[]" value="{{$row->pencapaian}}" required autocomplete="newAchievment" /><a href="javascript:void(0);" class="remove_field">Remove</a></div>
                                        @endforeach
                                    </div>
                                    <p><button class="add_fields_updateAch">Add More Fields</button></p>
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