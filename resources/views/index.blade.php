@extends('layout')
@section('content')
@extends('nav')
<!--投稿毎に繰り返す-->
@foreach($boards as $board)
<div class="container">
	<div class="row">
    <!--レイアウト用ダミー-->
    <div class="col-1 col-lg-3">
    </div>
    <!--ユーザー画像表示用-->
    <div class="col-2 col-lg-1 border border-end-0">
      <div class="row">
        <figure>
          <img src="{{$board->getBoardUserImagePath()}}" width="50px" height="50px">
        </figure>
      </div>
    </div>
    <!--投稿内容表示用-->
		<div class="col-8 col-lg-5 border border-start-0" style="padding:10px">
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
          <div class="small text-secondary text-end">{{ $board->send_date }}</div>
				</div>
			</div>
      <!--投稿テキスト、画像表示用-->
			<div class="row">
        <a href="/{{ $board->id }}" style="text-decoration: none;color: #060606;">
          <p>
            {{ $board->post_text }}
          </p>
          <figure>
            <img class="img-index" src="{{$board->getBoardImagePath()}}">
          </figure>
        </a>
			</div>
      <!--各ボタン表示用-->
      <div class="row">
        <!--col内をセンタリングするにはd-flex以降全て必要-->
				<div class="col-3 col-lg-3 d-flex align-items-center justify-content-center">
          <a href="/{{ $board->id }}/replyShow" class="btn btn-light" >
            <span class="small text-secondary">返信</span>
          </a>
				</div>
				<div class="col-3 col-lg-3 d-flex align-items-center justify-content-center">
          <!--返信元投稿があれば表示する-->
          @if(!empty($board->reply->src_post_id))
            <a href="/{{ $board->reply->src_post_id }}" class="btn btn-light">
            <span class="small text-secondary">
            返信先
            </span>
          </a>
          @endif
				</div>
				<div class="col-3 col-lg-3 d-flex align-items-center justify-content-center">
          <!--ログインユーザの投稿なら編集ボタンを表示する-->
          @if($board->user->id === Auth::id())
            <a href="/{{ $board->id }}/edit" class="btn btn-light">
              <span class="small text-secondary">編集</span>
            </a>
          @endif
				</div>
				<div class="col-3 col-lg-3 d-flex align-items-center justify-content-center">
          <!--ログインユーザの投稿なら削除ボタンを表示する-->
          @if($board->user->id === Auth::id())
            <!--form内は下側に若干スペースが出来る。中央揃えにするにはmargin:autoが必要-->
            <form action="/{{ $board->id }}" method="post" style="margin: auto;">
              @method('DELETE')
              @csrf
              <button type="submit" class="btn btn-danger btn-delete">
                <span class="small text-light">削除</span>
              </button>
            </form>
          @endif
        </div>
			</div>
		</div>
    <!--レイアウト用ダミー-->
    <div class="col-1 col-lg-3">
    </div>
  </div>
</div>
<br>
@endforeach
<div class="text-center">
  {{$boards->links()}}
</div>
@endsection
