@extends('board/layout')
@extends('board/nav')
@section('content')
@include('board/form', ['target' => 'store'])
@endsection
