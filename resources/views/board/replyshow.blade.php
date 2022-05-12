@extends('board/layout')
@section('content')
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
