@extends('layouts.email')

@section('title')
Approved Rewards
@endsection

@section('content')
<p>Hi {{ $name }}, <br><br>This is a mailer to notify you of your rewards approved for; <br> {{ $project }}</p>
@endsection