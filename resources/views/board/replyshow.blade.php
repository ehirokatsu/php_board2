@extends('board/layout')
@section('content')
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
                <div class="small text-secondary text-end">
                    {{ $board->send_date }}
                </div>
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
        <div class="col-1 col-lg-3">
        </div>
    </div>
</div>
<br>
<div class="container">
    <div class="row">
        <div class="col-1 col-lg-3">
        </div>
        <div class="col-2 col-lg-1 border border-end-0">
            <div class="row">
                @if(Storage::disk('local')->exists('public/profile/' . $user->id . '.jpg'))
                    <figure>
                        <img src="/storage/profile/{{$user-> id}}.jpg" width="50px" height="50px">
                    </figure>
                @endif
            </div>
        </div>
		<div class="col-8 col-lg-5 border border-start-0" style="padding:10px">
			<div class="row">
				<div class="col-lg-3">
                    <!--名前は左揃えにする-->
                    <div class="text-start font-weight-bold fs-4">
                    {{ $user->name }}
                </div>
            </div>
            <div class="col-lg-5">
            </div>
            <div class="col-lg-4">
			</div>
		</div>
		<div class="row">
            <form action="/board/reply" method="post" enctype="multipart/form-data">
                <input type="hidden" name="_src_id" value="{{ $board->id }}">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="form-group">
                    <input type="textarea" class="form-control" name="post_text" value="" cols="60" rows="8" maxlength=140>
                </div>
                <input type="file" name="image">
                <button type="submit" class="btn btn-default">投稿</button>
                <a href="/board">戻る</a>
            </form>
		</div>
        <div class="col-1 col-lg-3">
        </div>
    </div>
</div>


<!--
<div class="container ops-main">
    <div class="row">
        <div class="col-md-6">
            <h2>元投稿</h2>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8 col-md-offset-1">
            <label for="name">投稿者:{{$board->user->name}}
            </label>
            <br>
            @if(Storage::disk('local')->exists('public/profile/' . $board->user->id . '.jpg'))
                <figure>
                    <img src="/storage/profile/{{$board->user-> id}}.jpg" width="100px" height="100px">
                </figure>
            @endif
            <label for="name">{{$board->post_text}}
            </label>
            @if(!empty($board->boardimage->image_name))
            <figure>
              <img src="/storage/images/{{$board->boardimage->image_name}}">
            </figure>
            @endif
        </div>
    </div>
</div>
-->
<div class="container ops-main">
    <div class="row">
        <div class="col-md-6">
            <h2>返信フォーム</h2>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8 col-md-offset-1">
            <form action="/board/reply" method="post" enctype="multipart/form-data">
            <input type="hidden" name="_src_id" value="{{ $board->id }}">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="form-group">
                    <label for="name">投稿</label>
                    <input type="textarea" class="form-control" name="post_text" value="" cols="60" rows="8" maxlength=140>
                </div>
                <input type="file" name="image">
                <button type="submit" class="btn btn-default">投稿</button>
                <a href="/board">戻る</a>
            </form>
        </div>
    </div>
</div>
@endsection
