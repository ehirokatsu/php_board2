@extends('board/layout')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-1 col-lg-1">
        </div>
        <div class="col-2 col-lg-2 border border-end-0">
            <div class="row">
                @if(Storage::disk('local')->exists('public/profile/' . $board->user->id . '.jpg'))
                    <figure>
                        <img src="/storage/profile/{{$board->user-> id}}.jpg" width="100px" height="100px">
                    </figure>
                @else
                    <figure>
                        <img src="/storage/profile/0.jpg" width="100px" height="100px">
                    </figure>
                @endif
            </div>
        </div>
		<div class="col-8 col-lg-8 border border-start-0" style="padding:10px">
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
                <img src="/storage/images/{{$board->id}}.jpg" height="300px">
            </figure>
            @endif
		</div>
        <div class="col-1 col-lg-1">
        </div>
    </div>
</div>
<br>
<div class="container">
    <div class="row">
        <div class="col-1 col-lg-1">
        </div>
        <div class="col-2 col-lg-2 border border-end-0">
            <div class="row">
                @if(Storage::disk('local')->exists('public/profile/' . $user->id . '.jpg'))
                    <figure>
                        <img src="/storage/profile/{{$user-> id}}.jpg" width="100px" height="100px">
                    </figure>
                @else
                    <figure>
                        <img src="/storage/profile/0.jpg" width="100px" height="100px">
                    </figure>
                @endif
            </div>
        </div>
		<div class="col-8 col-lg-8 border border-start-0" style="padding:10px">
			<div class="row">
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
            <form action="/board/replyStore" method="post" enctype="multipart/form-data">
		    <div class="row">
                <input type="hidden" name="_src_id" value="{{ $board->id }}">
                @csrf
                <div class="form-group">
                    <textarea class="form-control" name="post_text"  value="" cols="50" rows="6" maxlength="140" style="font-size:130%; resize: none;"></textarea>
                </div>
            </div>
            <div class="row" style="padding:15px;">
                <div class="imagePreviewPre">
                </div>
            </div>
            <div class="row">
                <div class="col-3 col-lg-3 d-flex align-items-center justify-content-center">
                    <!--★★★画像ファイル以外はエラー表示にしたい-->
                    <label class="input-group-btn">
                        <span class="btn btn-info">
                                画像<input type="file" name="image" style="display:none" class="uploadFile">
                        </span>
                    </label>
                </div>
                <div class="col-3 col-lg-3">
                </div>
                <div class="col-3 col-lg-3 d-flex align-items-center justify-content-center">
                    <button type="submit" class="btn btn-primary">投稿する</button>
                </div>
                
                <div class="col-3 col-lg-3 d-flex align-items-center justify-content-center">
                    <a href="/board" class="btn btn-light" >
                        <span class="small text-secondary">戻る</span>
                    </a>
                </div>
            </div>
            </form>
		</div>
        <div class="col-1 col-lg-1">
        </div>
    </div>
</div>
@endsection