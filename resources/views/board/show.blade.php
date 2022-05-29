@extends('board/layout')
@section('content')

<div class="container">

    <div class="row">
        @include('board/message')
        <div class="col-1 col-lg-1">
        </div>
        <div class="col-2 col-lg-2 border border-end-0">
            <div class="row">
                @if(Storage::disk('local')->exists('public/profile/' . $board->user->id . '.jpg'))
                    <figure>
                        <img src="/storage/profile/{{$board->user-> id}}.jpg" width="50px" height="50px">
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
                <!--名前右スペースダミー-->
                <div class="col-lg-9">
                </div>
            </div>

		    <div class="row">
                
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="form-group">
                        <textarea class="form-control" name="post_text"  value="{{ $board->post_text }}" cols="50" rows="6" maxlength="140">{{ $board->post_text }}</textarea>
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

                </div>
                <div class="col-3 col-lg-3">
                </div>
                <div class="col-3 col-lg-3 d-flex align-items-center justify-content-center">
                </div>
                
                <div class="col-3 col-lg-3 d-flex align-items-center justify-content-center">
                    <a href="/board" class="btn btn-light" >
                        <span class="small text-secondary">戻る</span>
                    </a>
                </div>
            </div>
		</div>
        <div class="col-1 col-lg-1">
        </div>
    </div>
</div>
@endsection
