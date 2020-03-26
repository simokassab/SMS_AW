@extends('layouts.app')

@section('content')
    <center><h1>Create New Customer </h1></center>
    {!! Form::open(['action'=>'UserController@store', 'method'=>'POST', 'enctype' => 'multipart/form-data']) !!}
    <div class="form-group">
        {{form::label('name', 'Name')}}
        {{form::text('name', '', ['class'=>'form-control', 'placeholder'=>'Name'])}}
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
        {{form::label('phone', 'Phone')}}
        {{form::text('phone', '', ['class'=>'form-control', 'placeholder'=>'Phone'])}}
    </div>
    <div class="form-group">
        {{form::label('ustype', 'User Type: ')}}
        <select class="form-control" name="ustype" id='ustype'>
            @foreach($ustype as $ust)
                    <option value="{{$ust->id}}">{{$ust->name}}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        {{form::label('image', 'Upload your Image: ')}}
        {!! form::file('image', array('class' => 'form-control')) !!}
    </div> <br>
        {{form::submit('Submit', ['class'=>'btn btn-primary'])}}
        
    {!! Form::close() !!}
@endsection

