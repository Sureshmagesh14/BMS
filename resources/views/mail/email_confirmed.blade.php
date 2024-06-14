@extends('layouts.email')

@section('title')
Email Confirmed Successfully
@endsection

@section('content')
<p>Hi, {{ $fullname }}</p>
<p>Thank you for verifying your account by confirming your email address.</p>
@endsection