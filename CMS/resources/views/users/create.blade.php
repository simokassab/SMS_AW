@extends('layouts.app')

@section('content')
    <center><h1>Create New User </h1></center>
    {!! Form::open(['action'=>'UserController@store', 'method'=>'POST', 'enctype' => 'multipart/form-data']) !!}
    <div class="form-group">
        {{form::label('fname', 'Full Name')}}
        {{form::text('fname', '', ['class'=>'form-control', 'placeholder'=>'Full Name'])}}
    </div>
    <div class="form-group">
        {{form::label('username', 'Username')}}
        {{form::text('username', '', ['class'=>'form-control', 'placeholder'=>'Username'])}}
    </div>
    <div class="form-group">
        {{form::label('email', 'Email')}}
        {{form::text('email', '', ['class'=>'form-control', 'placeholder'=>'Email'])}}
    </div>
    <div class="form-group">
        {{form::label('pass', 'Password')}}
        {{form::text('pass', '', ['class'=>'form-control', 'placeholder'=>'Password'])}}
    </div>
    <div class="form-group">
        {{form::label('address', 'Address')}}
        {{form::text('address', '', ['class'=>'form-control', 'placeholder'=>'Address'])}}
    </div>
    <div class="form-group">
        {{form::label('phone', 'Phone')}}
        {{form::text('phone', '', ['class'=>'form-control', 'placeholder'=>'Phone'])}}
    </div>
    <div class="form-group">
        {{form::label('company', 'Company')}}
        {{form::text('company', '', ['class'=>'form-control', 'placeholder'=>'Company'])}}
    </div>
    <div class="form-group">
        {{form::label('image', 'Upload your Image: ')}}
        {!! form::file('image', array('class' => 'form-control')) !!}
    </div><br>
     <div class="form-group">
        {{form::label('filter', 'Filter: ')}}
        {{ Form::radio('filter', 1, array('class' => 'form-control')) }} Yes
        {{ Form::radio('filter', 0, array('class' => 'form-control')) }} NO
    </div> <br>
        {{form::submit('Submit', ['class'=>'btn btn-primary'])}}
        
    {!! Form::close() !!}<br><br><br>   <br>
@endsection