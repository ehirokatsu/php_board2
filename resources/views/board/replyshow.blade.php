@extends('board/layout')
<style>
    .imagePreviewPre {
    }
    .imagePreview {
        width: 180px;
        height: 300px;
        background-position: center center;
        background-size: cover;
        -webkit-box-shadow: 0 0 1px 1px rgba(0, 0, 0, .3);
        display: inline-block;
    }
</style>

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
                <!--名前右スペースダミー-->
                <div class="col-lg-9">
                </div>
            </div>
            <form action="/board/reply" method="post" enctype="multipart/form-data">
            <!--<div class="input-group">-->
		    <div class="row">
                
                    <input type="hidden" name="_src_id" value="{{ $board->id }}">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="form-group">
                        <input type="textarea" class="form-control" name="post_text" value="" cols="60" rows="8" maxlength=140>
                    </div>
                
            </div>
            <div class="row" style="padding:15px;">
                <div class="imagePreviewPre">
                </div>
            </div>

            <div class="row">
                <div class="col-3 col-lg-3 d-flex align-items-center justify-content-center">
<!--
                    <input type="file" class="custom-file-input" name="image">
-->
                    <label class="input-group-btn">
                        <span class="btn btn-primary">
                                画像<input type="file" name="image" style="display:none" class="uploadFile">
                        </span>
                    </label>
                    <!--
                    <input type="text" class="form-control" readonly="">
-->
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
            <!--</div>-->
            </form>
		</div>
        <div class="col-1 col-lg-3">
        </div>
    </div>
</div>

<label>
<span class="btn btn-primary">
    画像
    <input type="file" style="display:none">
</span>
</label>
<div class="text">aaa</div>

<div class="container page-header">
            <div class="col-sm-4">
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="imagePreview">
                    </div>
                    <div class="input-group">
                        <label class="input-group-btn">
                            <span class="btn btn-primary">
                                Choose File<input type="file" style="display:none" class="uploadFile">
                            </span>
                        </label>
                        <input type="text" class="form-control" readonly="">
                    </div>
                </form>
            </div>
        </div>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<!--
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
-->
        <script>
            /*
        $(function(){
		    $('.text').mouseover(function(){
                //$(this).removeClass('hover_off');
                $('.text').addClass('imagePreview');
		    });	
	    });*/

        $(document).on('change', ':file', function() {
            var input = $(this),
            numFiles = input.get(0).files ? input.get(0).files.length : 1,
            label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
            input.parent().parent().next(':text').val(label);

            var files = !!this.files ? this.files : [];
            if (!files.length || !window.FileReader) return; // no file selected, or no FileReader support
            if (/^image/.test( files[0].type)){ // only image file
                var reader = new FileReader(); // instance of the FileReader
                reader.readAsDataURL(files[0]); // read the local file
                reader.onloadend = function(){ // set image data as background of div
                    //input.parent().parent().parent().prev('.imagePreview').css("background-image", "url("+this.result+")");
                    input.parent().parent().parent().parent().prev().children('.imagePreview').css("background-image", "url("+this.result+")");
                }
                $('.imagePreviewPre').addClass('imagePreview')
            }
        });
        </script>
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
