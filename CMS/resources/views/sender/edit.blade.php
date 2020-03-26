@extends('layouts.app')

@section('content')
    <center><h1>Edit  User </h1></center>
    @foreach ($sender as $us)

        {!! Form::open(['action'=> ['SenderController@update', $us->id], 'method'=>'POST', 'enctype' => 'multipart/form-data']) !!}
        <div class="form-group">
            {{form::label('name', 'Name')}}
            {{form::text('name', $us->name, ['class'=>'form-control', 'placeholder'=>'Name'])}}
        </div>
        <div class="form-group">
            <label for="user">User: </label>
            <select id="user" name="user" class="form-control">
                @foreach($users as $u)
                    @if($u->id==$us->US_ID_FK)
                        <option selected value="{{$us->US_ID_FK}}">{{$u->full_name}}</option>
                    @else
                        <option  value="{{$us->US_ID_FK}}">{{$u->full_name}}</option>
                    @endif
                @endforeach
            </select>
        </div>
        <br>
        <hr>
        <div class="form-group">
            @if($us->active==1)
                <div class="form-check-inline">
                    <label class="form-check-label">
                        <input type="radio" class="form-check-input" name="active" value="1" checked>Active
                    </label>
                </div>
                <div class="form-check-inline">
                    <label class="form-check-label">
                        <input type="radio" class="form-check-input" name="active" value="0">Inactive
                    </label>
                </div>
            @else
                <div class="form-check-inline">
                    <label class="form-check-label">
                        <input type="radio" class="form-check-input" name="active" value="1" >Active
                    </label>
                </div>
                <div class="form-check-inline">
                    <label class="form-check-label">
                        <input type="radio" class="form-check-input" name="active" value="0" checked>Inactive
                    </label>
                </div>
            @endif
        </div>
       <br/>
        {{form::hidden('_method', 'PUT')}}
        {{form::submit('Submit', ['class'=>'btn btn-primary'])}}
        {!! Form::close() !!}
    @endforeach
@endsection
 