@extends('board/layout')
@section('content')
<h1>サンプル</h1>

{{$user->name}}
<form method="POST" action="/board/profile" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Name') }}</label>
    <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" autocomplete="name" autofocus>

    <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>
    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" autocomplete="email">

    <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>
    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" autocomplete="new-password">

    <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password') }}</label>
    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" autocomplete="new-password">

    <label for="" class="col-md-4 col-form-label text-md-end">プロフィール画像</label>
                            <div class="col-md-6">
                                <input type="file" name="image">

    <button type="submit" class="btn btn-primary">
        {{ __('Register') }}
    </button>
</form>

<form method="POST" action="/board/profile" enctype="multipart/form-data">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-primary">
        {{ __('Register') }}
    </button>
</form>
<!--

更新ボタン
Putの宛先が必要


削除ボタン
deleteの宛先が必要


-->
@endsection
