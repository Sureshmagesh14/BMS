@extends('layouts.email')

@section('title')
    Change mobile number
@endsection

@section('content')
    <p>To change your mobile number, use the following OTP <br> {{ $otp }} </p>
@endsection