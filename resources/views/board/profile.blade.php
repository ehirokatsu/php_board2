@extends('board/layout')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('ユーザー情報') }}</div>

                <div class="card-body">
                    <form method="POST" action="/board/profile" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $user->name }}" autocomplete="name" autofocus>
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $user->email }}" autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" autocomplete="new-password">
                            </div>
                        </div>

                        <div class="row mb-3" style="padding:15px;">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('profile image') }}</label>
                            <div class="col-md-6">
                                <div class="imagePreviewPre">
                                </div>
                                <div class="imagePreviewEdit">
                                @if(Storage::disk('local')->exists('public/profile/' . $user->id . '.jpg'))
                                        <figure>
                                        <img src="/storage/profile/{{$user-> id}}.jpg" width="400px">
                                        </figure>
                                    @endif
                                </div>
                            </div>
                            <div class="">
                            <div class="col-3 col-lg-3  offset-lg-3 d-flex align-items-center justify-content-center">
                                <label class="input-group-btn">
                                    <span class="btn btn-info">
                                            画像<input type="file" name="image" style="display:none" class="uploadFile">
                                    </span>
                                </label>
                            </div>
                            </div>
                        </div>
                        <div class="row mb-0">
                            <div class="col-md-3 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('更新') }}
                                </button>
                            </div>
                            </form>
                            <div class="col-md-3">
                                <form method="POST" action="/board/{{ $user->id }}/profile" enctype="multipart/form-data">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-delete">
                                        {{ __('アカウント削除') }}
                                    </button>
                                </form>
                            </div>
                            <div class="col-md-2">
                                <a href="/board" class="btn btn-light" >
                                    <span class="small text-secondary">
                                        戻る
                                    </span>
                                </a>
                            </div>
                        </div>
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
