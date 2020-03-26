@extends('layouts.app')

@section('content')
    <center><h1>Create New Sender </h1></center>
    {!! Form::open(['action'=>'SenderController@store', 'method'=>'POST', 'enctype' => 'multipart/form-data']) !!}
    <div class="form-group">
        {{form::label('name', 'Name')}}
        {{form::text('name', '', ['class'=>'form-control', 'placeholder'=>'Name'])}}
    </div>
    <div class="form-group">
        {{form::label('msisdn', 'MSISDN')}}
        {{form::text('msisdn', '',   ['class'=>'form-control', 'placeholder'=>'MSISDN'])}}
    </div>
    <div class="form-group">
        <div class="form-group">
            <label for="user">User: </label>
            <select id="user" name="user" class="form-control">
                @foreach($users as $us)
                    <option  value="{{$us->id}}">{{$us->full_name}}</option>
                @endforeach
            </select>
        </div>
    </div>
    <br>
    {{form::submit('Submit', ['class'=>'btn btn-primary'])}}

    {!! Form::close() !!}<br><br><br>   <br>
@endsection



