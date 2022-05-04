@extends('layouts.helloapp')

@section('title', 'User.Add')

@section('menubar')
   @parent
   投稿ページ
@endsection

@section('content')
   <form action="/user/add" method="post">
   <table>
      @csrf
      <tr><th>user_name: </th><td><input type="text" 
         name="user_name"></td></tr>
      <tr><th>user_mail: </th><td><input type="text" 
         name="user_mail"></td></tr>
      <tr><th>user_pass: </th><td><input type="text" 
         name="user_pass"></td></tr>
      <tr><th></th><td><input type="submit" 
         value="send"></td></tr>
   </table>
   </form>
@endsection

@section('footer')
copyright 2020 tuyano.
@endsection
