@extends('layout')
@extends('nav')
@section('content')
<!--返信元投稿表示用-->
<div class="container">
  <div class="row">
    <!--レイアウト用ダミー-->
    <div class="col-1 col-lg-1">
    </div>
    <!--ユーザー画像表示用-->
    <div class="col-2 col-lg-2 border border-end-0">
    <div class="row">
      <figure>
        <img src="{{$board->getBoardUserImageStoragePath()}}" width="50px" height="50px">
      </figure>
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
            <figure>
              <img class="img-show" src="{{$board->getBoardImageStoragePath()}}">
            </figure>
          </a>
        </div>
      </div>
    </div>
  </div>
</div>
<br>
<!--返信フォーム表示用-->
@include('form', ['target' => 'reply'])
@endsection