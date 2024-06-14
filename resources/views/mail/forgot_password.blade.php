@extends('layouts.email')

@section('title')
Forgot Password
@endsection

@section('content')
<p>To reset your password, use the following OTP <br> {{ $otp }} </p>
@endsection