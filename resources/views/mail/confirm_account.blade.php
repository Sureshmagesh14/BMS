@extends('layouts.email')

@section('title')
Confirm Account
@endsection

@section('content')
<p>Hi, {{ $fullname }}</p>
<p>Please verify your email address by clicking on the link below;</p>
<p>{{ $url }}</p>
@endsection