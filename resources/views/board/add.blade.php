@extends('layouts.helloapp')

@section('title', 'Board.Add')

@section('menubar')
   @parent
   新規作成ページ
@endsection

@section('content')
   @if (count($errors) > 0)
   <div>
       <ul>
           @foreach ($errors->all() as $error)
               <li>{{ $error }}</li>
           @endforeach
       </ul>
   </div>
   @endif
   <form action="/board/add" method="post">
   <table>
       @csrf
       <tr><th>name: </th><td><input type="text" name="post_text"
           value="{{old('post_text')}}"></td></tr>
       <tr><th></th><td><input type="submit" 
           value="send"></td></tr>
   </table>
   </form>
@endsection

@section('footer')
copyright 2020 tuyano.
@endsection