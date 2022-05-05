@extends('layouts.helloapp')

@section('title', 'Bulletinboard.index')

@section('menubar')
   @parent
   インデックスページ
@endsection

@section('content')

    <!-- 投稿フォーム -->
    <form action="/board" method="post" name="post_text" enctype="multipart/form-data">
        @csrf
            <textarea id="post_text" name="post_text" cols="60" rows="8"
             maxlength=140></textarea >
        </div>
        <div class="item_post_file">
            <!--添付ファイル(1M以内)：<input type="file" name="yourfile">-->
        </div>
          <div class="item_post"></div>
        <div class="item_post">
            <input type="submit" value="投稿する">
        </div>
        
        <table>

   <table>
   <tr><th>Message</th><th>Name</th><th>Replyflag</th><th>reply</th><th>delete</th></tr>
   @foreach ($items as $item)
       <tr>
           <td>{{$item->post_text}}</td>
           <td>{{$item->user->user_name}}</td>
           <td>{{$item->post->reply_flag}}</td>
           <td>
               <input type="radio" id="reply{{$item->id}}"name="reply" value="{{$item->id}}">
               <label for="reply{{$item->id}}">返信</label>
            </td>
            <td>
            <button type="submit" id="delete" name="delete"
             value="{{$item->id}}">削除</button>
            </td>
       </tr>
   @endforeach
   </table>
</form>
@endsection

@section('footer')
copyright 2020 tuyano.
@endsection