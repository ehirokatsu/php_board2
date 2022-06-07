@extends('layout')
@section('content')
@extends('nav')
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
        <a href="/{{ $board->id }}" style="text-decoration: none;color: #060606;">
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
          <a href="/{{ $board->id }}/replyShow" class="btn btn-light" >
            <span class="small text-secondary">返信</span>
          </a>
				</div>
				<div class="col-3 col-lg-3 d-flex align-items-center justify-content-center">
          @if(!empty($board->reply->src_post_id))
            <a href="/{{ $board->reply->src_post_id }}" class="btn btn-light">
            <span class="small text-secondary">
            返信先
            </span>
          </a>
          @endif
				</div>
				<div class="col-3 col-lg-3 d-flex align-items-center justify-content-center">
          @if($board->user->id === Auth::id())
            <a href="/{{ $board->id }}/edit" class="btn btn-light">
              <span class="small text-secondary">編集</span>
            </a>
          @endif
				</div>
				<div class="col-3 col-lg-3 d-flex align-items-center justify-content-center">
          @if($board->user->id === Auth::id())
            <!--form内は下側に若干スペースが出来る。中央揃えにするにはmargin:autoが必要-->
            <form action="/{{ $board->id }}" method="post" style="margin: auto;">
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
