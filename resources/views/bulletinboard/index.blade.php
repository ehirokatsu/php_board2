@extends('layouts.helloapp')

@section('title', 'Bulletinboard.index')

@section('menubar')
   @parent
   インデックスページ
@endsection

@section('content')
   <table>
   <tr><th>post_id</th><th>post_text</th><th>reply_flag</th></tr>
   @foreach ($items as $item)
       <tr>
           <td>{{$item->post_id}}</td>
           <td>{{$item->post_text}}</td>
           <td>{{$item->reply_flag}}</td>
       </tr>
   @endforeach
   </table>
@endsection

@section('footer')
copyright 2020 tuyano.
@endsection