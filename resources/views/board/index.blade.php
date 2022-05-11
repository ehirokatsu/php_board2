@extends('board/layout')
@section('content')
@if (Auth::check())
<p>USER: {{$user->name . ' (' . $user->email . ')'}}</p>
@else
<p>※ログインしていません。（<a href="/login">ログイン</a>｜
   <a href="/register">登録</a>）</p>
@endif
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
        <th class="text-center">投稿内容</th>
        <th class="text-center">reply_flag</th>
        <th class="text-center">投稿ユーザ</th>
        <th class="text-center">画像</th>
        <th class="text-center">返信</th>
        <th class="text-center">送信元</th>
        <th class="text-center">編集</th>
        <th class="text-center">削除</th>
        
      </tr>
      @foreach($boards as $board)
      <tr>
      <td><div><a href="/board/{{ $board->id }}">{{ $board->id }}</a></td>
        <td>{{ $board->post_text }}</td>
        <td>{{ $board->post->reply_flag }}</td>
        <td>{{ $board->user->name }}</td>
        @if(!empty($board->boardimage->image_name))
        <!--<td>{{ $board->boardimage->image_name }}</td>-->
        <td><figure>
              <img src="/storage/images/{{$board->boardimage->image_name}}" width="100px" height="100px">
              <!--<figcaption>現在のプロフィール画像</figcaption>-->
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
    <div><a href="/board/create" class="btn btn-default">新規作成</a></div>
  </div>
</div>
@endsection
