@extends('board/layout')
@section('content')
<nav class="navbar navbar-expand-sm navbar-light bg-light mt-3 mb-3 sticky-top">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav4" aria-controls="navbarNav4" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <a class="navbar-brand" href="#">My BBS</a>
        <div class="collapse navbar-collapse">
            <!--liクラス全てを中央配置にするのでulクラスにd-flex以降を記述する-->
            <ul class="navbar-nav d-flex align-items-center justify-content-center">
                <li class="nav-item">
                    <a class="nav-link" href="#">TOP</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="/board/create">新規投稿</a>
                </li>
                <div></div>
                <li class="nav-item">
                    <a class="nav-link" href="#">設定</a>
                </li>
                <li class="nav-item">
                  <div class="icon">
                    @if(Storage::disk('local')->exists('public/profile/' . $user->id . '.jpg'))
                      <figure>
                                <img src="/storage/profile/{{$user-> id}}.jpg" width="50px" height="50px">
                      </figure>
                    @else
                      <figure>
                        <img src="/storage/profile/0.jpg" width="50px" height="50px">
                      </figure>
                    @endif
                    <div class="user-info">
                      <span>ユーザ名：{{$user->name}}</span>
                      <br>
                      <span>メールアドレス：{{$user->email}}</span>
                    </div>
                  </div>
                </li>
                <li class="nav-item">
                  <form action="/logout" method="post" style="margin: auto;">
                    @csrf
                    <button type="submit" class="btn btn-light">ログアウト</button>
                   </form>
                </li>
            </ul>
        </div>
    </nav>  
@foreach($boards as $board)
<div class="container">
	<div class="row">
    <div class="col-1 col-lg-3">
    </div>
    <div class="col-2 col-lg-1 border border-end-0">
      <div class="row">
          @if(Storage::disk('local')->exists('public/profile/' . $board->user->id . '.jpg'))
            <figure>
              <img src="/storage/profile/{{$board->user-> id}}.jpg" width="50px" height="50px">
              </figure>
          @else
            <figure>
              <img src="/storage/profile/0.jpg" width="50px" height="50px">
            </figure>
          @endif
      </div>
    </div>
		<div class="col-8 col-lg-5 border border-start-0" style="padding:10px">
			<div class="row">
				<div class="col-lg-3">
          <!--名前は左揃えにする-->
          <div class="text-start font-weight-bold fs-4">
            {{ $board->user->name }}
          </div>
        </div>
				<div class="col-lg-5">
				</div>
				<div class="col-lg-4">
          <!--テキストを右揃えするにはtext-endを指定する。-->
          <div class="small text-secondary text-end">{{ $board->send_date }}</div>
				</div>
			</div>
			<div class="row">
        <a href="/board/{{ $board->id }}" style="text-decoration: none;color: #060606;">
          <p>
            {{ $board->post_text }}
          </p>
          @if(Storage::disk('local')->exists('public/images/' . $board->id . '.jpg'))
            <figure>
                <img src="/storage/images/{{$board->id}}.jpg" height="200px">
            </figure>
          @endif
        </a>
			</div>
      <div class="row">
        <!--col内をセンタリングするにはd-flex以降全て必要-->
				<div class="col-3 col-lg-3 d-flex align-items-center justify-content-center">
          <a href="/board/{{ $board->id }}/reply" class="btn btn-light" >
            <span class="small text-secondary">返信</span>
          </a>
				</div>
				<div class="col-3 col-lg-3 d-flex align-items-center justify-content-center">
          @if(!empty($board->reply->src_post_id))
            <a href="/board/{{ $board->reply->src_post_id }}" class="btn btn-light">
            <span class="small text-secondary">
            返信先
            </span>
          </a>
          @endif
				</div>
				<div class="col-3 col-lg-3 d-flex align-items-center justify-content-center">
          @if($board->user->id === Auth::id())
            <a href="/board/{{ $board->id }}/edit" class="btn btn-light">
              <span class="small text-secondary">編集</span>
            </a>
          @endif
				</div>
				<div class="col-3 col-lg-3 d-flex align-items-center justify-content-center">
          @if($board->user->id === Auth::id())
            <!--form内は下側に若干スペースが出来る。中央揃えにするにはmargin:autoが必要-->
            <form action="/board/{{ $board->id }}" method="post" style="margin: auto;">
              @method('DELETE')
              @csrf
              <button type="submit" class="btn btn-danger">
                <span class="small text-light btn-delete">削除</span>
              </button>
            </form>
          @endif
        </div>
			</div>
		</div>
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
