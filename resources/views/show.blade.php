@extends('parts.layout')
@extends('parts.nav')
@section('content')
<div class="container">
  <div class="row">
    @include('parts.message')
    <!--レイアウト用ダミー-->
    <div class="col-1 col-lg-1">
    </div>
    <!--ユーザー画像表示用-->
    <div class="col-2 col-lg-2 border border-end-0">
    @include('parts.userImage')
    </div>
    <!--投稿内容表示用-->
    <div class="col-8 col-lg-8 border border-start-0" style="padding:10px">
      <div class="row">
        <div class="col-lg-3">
          <!--ユーザー名表示用-->
          <!--名前は左揃えにする-->
          <div class="text-start font-weight-bold fs-4">
            {{ $board->user->name }}
          </div>
        </div>
        <!--名前右スペースダミー-->
        <div class="col-lg-9">
        </div>
      </div>
      <!--投稿テキスト、画像表示用-->
      <div class="row">
        <p>
          {{ $board->post_text }}
        </p>
          <figure>
            <img class="img-show" src="{{$board->getBoardImageStoragePath()}}">
          </figure>
      </div>
      <!--各ボタン表示用-->
      <div class="row">
        <div class="col-3 col-lg-3 d-flex align-items-center justify-content-center">
          <a href="/{{ $board->id }}/replyShow" class="btn btn-light" >
            <span class="small text-secondary">返信</span>
          </a>
        </div>
        <div class="col-3 col-lg-3 d-flex align-items-center justify-content-center">
          <!--返信元投稿があれば表示する-->
          @if(!empty($board->reply->src_post_id))
            <a href="/{{ $board->reply->src_post_id }}" class="btn btn-light">
              <span class="small text-secondary">返信先</span>
            </a>
          @endif
          </div>
            <!--レイアウト用ダミー-->
            <div class="col-3 col-lg-3 d-flex align-items-center justify-content-center">
            </div>
          <div class="col-3 col-lg-3 d-flex align-items-center justify-content-center">
            <a href="/" class="btn btn-light" >
              <span class="small text-secondary">戻る</span>
            </a>
          </div>
        </div>
      </div>
    <!--レイアウト用ダミー-->
    <div class="col-1 col-lg-1">
    </div>
  </div>
</div>
@endsection
