@extends('layouts.login')
@section('content')
@if(Session::has('error_message'))
    <div data-alert class="alert-box warning">
        {{ Session::get('error_message') }}
        @foreach($errors->all() as $error)
            <p>{{ $error }}</p>
        @endforeach
        <a href="#" class="close">&times;</a>
    </div>
@endif

@if (count($errors) > 0)
<div data-alert class="alert-box warning">
    @foreach ($errors->all() as $error)
        <p>{{ $error }}</p>
    @endforeach
    <a href="#" class="close">&times;</a>
</div>
@endif
    <div class="login-wrapper">
        <div class="row">
            {!! Html::image("img/logo_header_desktop.png") !!}
            <div class="login">
                {!! Form::open(['url' => 'login']) !!}
                {!! Form::label('email', 'Email:') !!}
                {!! Form::text('email') !!}
                {!! Form::label('password', 'Password:') !!}
                {!! Form::password('password') !!}
                {!! Form::submit('Submit', array('class'=>'submit_button button')) !!}
            </div>
        </div>
    </div>
@stop