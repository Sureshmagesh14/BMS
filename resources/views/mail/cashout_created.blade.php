@extends('layouts.email')

@section('title')
Cashout Created
@endsection

@section('content')
<p>Hi {{ $name }}, <br><br>This is a mailer to notify you of a new cashout created.</p>
@endsection