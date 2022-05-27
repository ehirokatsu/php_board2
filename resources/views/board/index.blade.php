@extends('board/layout')
@section('content')
<!--
@if (Auth::check())
<header>
  <h1>BBS</h1>
</header>
<p>USER: {{$user->name . ' (' . $user->email . ')'}}</p>
  @if(Storage::disk('local')->exists('public/profile/' . $user->id . '.jpg'))
    <td><figure>
              <img src="/storage/profile/{{$user-> id}}.jpg" width="100px" height="100px">
    </figure></td>
  @endif
@else
<p>※ログインしていません。（<a href="/login">ログイン</a>｜
   <a href="/register">登録</a>）</p>
@endif

<form action="/logout" method="post">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <button type="submit" class="btn btn-light">ログアウト</button>
</form>


<div class="container">
	<div class="row">
    
    <div class="col-lg-4 border justify-content-center">
    <div class="text-center">1</div>
    </div>
    <div class="col-lg-4 border d-flex align-items-center justify-content-center" style="height:100px">
      <form  style="margin: auto;">
      <input class="form-control" type="text" name="address">
      </form>
    </div>
    <div class="col-lg-4 border">
      3
    </div>
  </div>
  <div class="row justify-content-center">
    bb
  </div>
  <div class="row">
    cc
  </div>
</div>
-->
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
                  <!--　アイコンマウスオーバーで名前、メールアドレスを表示する
                  <p>USER: {{$user->name . ' (' . $user->email . ')'}}</p>
-->
                    @if(Storage::disk('local')->exists('public/profile/' . $user->id . '.jpg'))
                      <figure>
                                <img src="/storage/profile/{{$user-> id}}.jpg" width="50px" height="50px">
                      </figure>
                    @endif
                </li>
                <li class="nav-item">
                  <form action="/logout" method="post" style="margin: auto;">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
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
        </a>
        @if(Storage::disk('local')->exists('public/images/' . $board->id . '.jpg'))
          <figure>
              <img src="/storage/images/{{$board->id}}.jpg" width="300px" height="300px">
          </figure>
        @endif
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
            <!--{{ $board->reply->src_post_id }}--> 
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
              <input type="hidden" name="_method" value="DELETE">
              <input type="hidden" name="_token" value="{{ csrf_token() }}">
              <button type="submit" class="btn btn-danger">
                <span class="small text-light">削除</span>
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

<div class="container ops-main">
<div class="row">
  <div class="col-md-12">
    <h3 class="ops-title">投稿一覧</h3>
  </div>
</div>
<div class="row">
  <div class="col-md-11 col-md-offset-1">
    <table class="table text-center">
      <tr>
      <th class="text-center">ID</th>
      <th class="text-center">投稿ユーザ</th>
      <th class="text-center">投稿ユーザ画像</th>
        <th class="text-center">投稿内容</th>
        <th class="text-center">reply_flag</th>
        
        <th class="text-center">画像</th>
        <th class="text-center">返信</th>
        <th class="text-center">送信元</th>
        <th class="text-center">編集</th>
        <th class="text-center">削除</th>
        
      </tr>
      @foreach($boards as $board)
      <tr>
      <td><div><a href="/board/{{ $board->id }}">{{ $board->id }}</a></td>
      <td>{{ $board->user->name }}</td>
      @if(Storage::disk('local')->exists('public/profile/' . $board->user->id . '.jpg'))
        <td><figure>
              <img src="/storage/profile/{{$board->user-> id}}.jpg" width="100px" height="100px">
        </figure></td>
        @endif
        <td>{{ $board->post_text }}</td>
        <td>{{ $board->post->reply_flag }}</td>
        
        @if(Storage::disk('local')->exists('public/images/' . $board->id . '.jpg'))
        <td><figure>
              <img src="/storage/images/{{$board->id}}.jpg" width="100px" height="100px">
        </figure></td>
        @endif

        <td>
          <div><a href="/board/{{ $board->id }}/reply" class="btn btn-default">返信</a></div>
        </td>
        @if(!empty($board->reply->src_post_id))
        <td><div><a href="/board/{{ $board->reply->src_post_id }}">{{ $board->reply->src_post_id }}</a></td>
        @endif
        @if($board->user->id === Auth::id())
        <td>
          <div><a href="/board/{{ $board->id }}/edit" class="btn btn-default">編集</a></div>
        </td>

        <td>
          <form action="/board/{{ $board->id }}" method="post">
            <input type="hidden" name="_method" value="DELETE">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <button type="submit" class="btn btn-md btn-danger" aria-label="Left Align"><span class="glyphicon glyphicon-trash"></span></button>
          </form>
        </td>
        @endif
        
      </tr>
      @endforeach
    </table>

  </div>
</div>
@endsection
