@extends('layout')
@extends('nav')
@section('content')
<div class="container">
  <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header">{{ __('ユーザー情報') }}
          </div>
          <div class="card-body">
            <div class="row mb-3">
              <ui>
                <li>更新したい項目を入力して更新ボタンを押してください。</li>
                <li>パスワードを変更する時は、パスワード項目とパスワード確認項目の両方を入力してください。</li>
              </ui>
            </div>
            <form method="POST" action="/user" enctype="multipart/form-data">
              @csrf
              @method('PUT')
              <!--自分のメールアドレスを検証から除外する用-->
              <input type="hidden" name="userId" value="{{$user->id}}">
              <div class="row mb-3">
                <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('名前') }}</label>
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
                <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('メールアドレス') }}</label>
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
                <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('パスワード') }}</label>
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
                <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('パスワード確認') }}</label>
                <div class="col-md-6">
                  <input id="password-confirm" type="password" class="form-control" name="password_confirmation" autocomplete="new-password">
                </div>
              </div>
              <div class="row mb-3">
                <label for="" class="col-md-4 col-form-label text-md-end">
                  {{ __('ユーザー画像') }}
                </label>
                <div class="col-md-6 d-flex align-items-center">
                  <div class="imagePreviewPre">
                  </div>
                  <div class="imagePreviewEdit">
                    @if(Storage::disk('local')->exists('public/user/' . $user->id . '.jpg'))
                      <figure>
                        <img class="img-create" src="/storage/user/{{$user-> id}}.jpg">
                      </figure>
                    @else
                      <div class="">ユーザー画像は登録されていません。</div>
                    @endif
                  </div>
                </div>
              </div>
              <div class="row mb-3">
                <div class="col-md-3 offset-md-4">
                  <label class="input-group-btn">
                    <span class="btn btn-info">
                      画像<input type="file" name="image" style="display:none" class="uploadFile is-invalid">
                    </span>
                  </label>
                </div>
                @error('image')
                  <div class="alert alert-danger col-3 col-lg-7  offset-lg-4 d-flex align-items-center justify-content-center">
                      <strong>{{ $message }}</strong>
                  </div>
                @enderror
              </div>
              <div class="row mb-0">
                <div class="col-md-3 offset-md-4">
                  <button type="submit" class="btn btn-primary">
                    {{ __('更新') }}
                  </button>
                </div>
            </form>
                <div class="col-md-3">
                  <form method="POST" action="/{{ $user->id }}/user" enctype="multipart/form-data">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-delete">
                      {{ __('アカウント削除') }}
                    </button>
                  </form>
                </div>
                <div class="col-md-2">
                    <a href="/" class="btn btn-light" >
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
