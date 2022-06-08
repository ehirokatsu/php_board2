@extends('layout')
@extends('nav')
@section('content')
<!--返信元投稿表示用-->
<div class="container">
  <div class="row">
  @include('message')
    <!--レイアウト用ダミー-->
    <div class="col-1 col-lg-1">
    </div>
    <!--ユーザー画像表示用-->
    <div class="col-2 col-lg-2 border border-end-0">
    <div class="row">
        @if(Storage::disk('local')->exists('public/user/' . $board->user->id . '.jpg'))
          <figure>
            <img src="/storage/user/{{$board->user-> id}}.jpg" width="100px" height="100px">
          </figure>
        @else
          <figure>
            <img src="/storage/user/0.jpg" width="100px" height="100px">
          </figure>
        @endif
      </div>
    </div>
    <!--投稿内容表示用-->
		<div class="col-8 col-lg-8 border border-start-0" style="padding:10px">
			<div class="row">
        <!--ユーザー名表示用-->
				<div class="col-lg-3">
          <!--名前は左揃えにする-->
          <div class="text-start font-weight-bold fs-4">
            {{ $board->user->name }}
          </div>
          </div>
          <!--レイアウト用ダミー-->
          <div class="col-lg-5">
          </div>
          <!--投稿日時表示用-->
          <div class="col-lg-4">
            <!--テキストを右揃えするにはtext-endを指定する。-->
            <div class="small text-secondary text-end">
              {{ $board->send_date }}
            </div>
          </div>
        </div>
        <!--投稿テキスト、画像表示用-->
        <div class="row">
          <a href="/{{ $board->id }}" style="text-decoration: none;color: #060606;">
            <p>
              {{ $board->post_text }}
            </p>
            @if(Storage::disk('local')->exists('public/images/' . $board->id . '.jpg'))
            <figure>
              <img class="img-show" src="/storage/images/{{$board->id}}.jpg">
            </figure>
            @endif
          </a>
        </div>
      </div>
    </div>
  </div>
</div>
<br>
<!--返信フォーム表示用-->
<div class="container">
  <div class="row">
    <!--レイアウト用ダミー-->
    <div class="col-1 col-lg-1">
    </div>
    <!--ユーザー画像表示用-->
    <div class="col-2 col-lg-2 border border-end-0">
      <div class="row">
        @if(Storage::disk('local')->exists('public/user/' . $user->id . '.jpg'))
          <figure>
            <img src="/storage/user/{{$user-> id}}.jpg" width="100px" height="100px">
          </figure>
        @else
          <figure>
            <img src="/storage/user/0.jpg" width="100px" height="100px">
          </figure>
        @endif
      </div>
    </div>
    <!--投稿フォーム表示用-->
    <div class="col-8 col-lg-8 border border-start-0" style="padding:10px">
      <div class="row">
        <!--ユーザー名表示用-->
        <div class="col-lg-3">
          <!--名前は左揃えにする-->
          <div class="text-start font-weight-bold fs-4">
              {{ $user->name }}
          </div>
        </div>
        <!--名前右スペースダミー-->
        <div class="col-lg-9">
        </div>
      </div>
      <!--投稿テキスト表示用-->
      <form action="/replyStore" method="post" enctype="multipart/form-data">
        <input type="hidden" name="_src_id" value="{{ $board->id }}">
		  <div class="row">
        @csrf
        <div class="form-group">
            <textarea class="form-control"
            name="post_text"  value="" cols="50" rows="6" maxlength="140" style="font-size:130%; resize: none;"></textarea>
        </div>
      </div>
      <!--投稿画像表示用-->
      <div class="row" style="padding:15px;">
        <div class="imagePreviewPre">
        </div>
      </div>
      <!--各ボタン表示用-->
      <div class="row">
        <div class="col-3 col-lg-3 d-flex align-items-center justify-content-center">
          <label class="input-group-btn">
            <span class="btn btn-info">
              画像<input type="file" name="image" style="display:none" class="uploadFile">
            </span>
          </label>
        </div>
        <!--レイアウト用ダミー-->
        <div class="col-3 col-lg-3">
        </div>
        <div class="col-3 col-lg-3 d-flex align-items-center justify-content-center">
            <button type="submit" class="btn btn-primary">投稿する</button>
        </div>
        <div class="col-3 col-lg-3 d-flex align-items-center justify-content-center">
          <a href="/" class="btn btn-light" >
            <span class="small text-secondary">戻る</span>
          </a>
        </div>
      </div>
      </form>
    </div>
    <!--レイアウト用ダミー-->
    <div class="col-1 col-lg-1">
    </div>
  </div>
</div>
@endsection