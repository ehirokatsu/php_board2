@extends('layouts.helloapp')

@section('title', 'Bulletinboard.index')

@section('menubar')
   @parent
   インデックスページ
@endsection

@section('content')

    <!-- 投稿フォーム -->
    <form action="/board" method="post" name="post_text" enctype="multipart/form-data">

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
   <tr><th>Data</th></tr>
   @foreach ($items as $item)
       <tr>
           <td>{{$item->getData()}}</td>
       </tr>
   @endforeach
   </table>
@endsection

@section('footer')
copyright 2020 tuyano.
@endsection