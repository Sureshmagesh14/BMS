@extends('layouts.email')

@section('title')
<h1> UPCOMING RESEARCH</h1>
<hr>
See if you qualify!
<hr>
@endsection

@section('content')
<p>Hi {{ $name }}, </p>
<br><br>
@if($proj_content!='')
<p>{{$proj_content}} </p>
@else
<p>We have interesting paid market reaserch <br> {{ $project }}. <br><br>Please answer a few questions to see if you qualify. <br> </p>
<hr>
<b> Duration</b><br>
<p>
    {{ $survey_duration }}
</p>
<hr>

<b> Paying</b><br>
<p>
    Points {{ $reward }}
</p>
<br><a href="{{ route('dashboard') }}" target="_blank">Click here</a>
<hr>
@endif
<!-- <br><br>
<p style="font-size:8px;">
    You are receiving this email because you are signed up to the Branch 
</p> -->
@endsection