@extends('board/layout')
@section('content')
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
        <th class="text-center">削除</th>
      </tr>
      @foreach($boards as $board)
      <tr>
        <td>
          <a href="/board/{{ $board->id }}/edit">{{ $board->id }}</a>
        </td>
        <td>{{ $board->post_text }}</td>
        <td>{{ $board->post->reply_flag }}</td>
        <td>{{ $board->user->user_name }}</td>
        <td>
          <form action="/board/{{ $board->id }}" method="post">
            <input type="hidden" name="_method" value="DELETE">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <button type="submit" class="btn btn-xs btn-danger" aria-label="Left Align"><span class="glyphicon glyphicon-trash"></span></button>
          </form>
        </td>
      </tr>
      @endforeach
    </table>
    <div><a href="/board/create" class="btn btn-default">新規作成</a></div>
  </div>
</div>
@endsection
