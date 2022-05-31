
<div class="container">

    <div class="row">
        @include('board/message')
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
            @if($target === 'store')
            <form action="/board" method="post" enctype="multipart/form-data">
            @elseif($target === 'update')
            <form action="/board/{{ $board->id }}" method="post" enctype="multipart/form-data">
                <input type="hidden" name="_method" value="PUT">
            @endif

		    <div class="row">
                    @if($target === 'update')
                        @method('PUT')
                    @endif
                    @csrf
                    <div class="form-group">
                        <textarea class="form-control" name="post_text"  value="" cols="50" rows="6" maxlength="140" style="font-size:130%; resize: none;">{{ $board->post_text }}</textarea>
                    </div>
                
            </div>
            <div class="row" style="padding:15px;">
                <div class="imagePreviewPre">
                </div>
                <div class="imagePreviewEdit">
                    @if(!empty($board->boardimage->image_name))
                        <figure>
                        <img src="/storage/images/{{$board->boardimage->image_name}}">
                        </figure>
                    @endif
                </div>
            </div>

            <div class="row">
                <div class="col-3 col-lg-3 d-flex align-items-center justify-content-center">
                    <!--★★★画像ファイル以外はエラー表示にしたい-->
                    <label class="input-group-btn">
                        <span class="btn btn-light">
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

