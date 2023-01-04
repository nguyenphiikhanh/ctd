@extends('app')

@section('title')
    <title>Tạo nhiệm vụ - {{ config('app.name') }}</title>
@endsection

@section('css')
<link rel="stylesheet" href="{{asset('assets/css/editors/quill.css')}}">
@endsection

@section('content')
    <giao-nhiem-vu></giao-nhiem-vu>
@endsection

@section('js')
<script src="{{asset('assets/js/libs/editors/quill.js')}}"></script>
<script src="{{asset('assets/js/editors.js')}}"></script>
@endsection
