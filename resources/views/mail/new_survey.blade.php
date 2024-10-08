@extends('layouts.email')

@section('title')
New Survey
@endsection

@section('content')
<p>Hi {{ $name }}, <br><br>This is a mailer to notify you of a new survey; <br> {{ $project }}</p>
<br><a href="{{ route('dashboard') }}" target="_blank">Click here</a>

@endsection