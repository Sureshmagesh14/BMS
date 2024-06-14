@extends('layouts.email')

@section('title')
New Survey
@endsection

@section('content')
@php 
dd($project);
@endphp 
<p>Hi {{ $name }}, <br><br>This is a mailer to notify you of a new survey; <br> {{ $project }}</p>
@endsection