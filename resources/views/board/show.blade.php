@extends('board/layout')
@section('content')
<div class="container ops-main">
    <div class="row">
        <div class="col-md-6">
            <h2>投稿</h2>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8 col-md-offset-1">
            <label for="name">投稿者:{{$board->user->name}}
            </label>
            <br>
            <label for="name">{{$board->post_text}}
            </label>
            @if(!empty($board->boardimage->image_name))
            <figure>
              <img src="/storage/images/{{$board->boardimage->image_name}}">
            </figure>
            @endif
            <a href="/board">戻る</a>
        </div>
    </div>
</div>
@endsection
