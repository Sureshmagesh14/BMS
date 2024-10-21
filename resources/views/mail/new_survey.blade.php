@extends('layouts.email')

@section('title')
New Survey
@endsection

@section('content')
<p>Hi {{ $name }}, <br><br>This is a mailer to notify you of a new survey; <br> 
   {{ $project }}. <br>
   You can access the <a href="{{ route('user.dashboard') }}">Dashboard</a> for more details.
</p>
@endsection