@extends('layouts.app')

@section('content')

    @foreach ($credits as $us)

        {!! Form::open(['action'=> ['CreditsController@update', $us->id], 'method'=>'POST', 'enctype' => 'multipart/form-data']) !!}

        @foreach($users as $user)
               <center><h1>Add Credits to the user <u>{{$user->full_name}}</u>  </h1></center>
               <hr>
               <div class="form-group">
                    <label for="credits">Nb of Credits</label>
                   <input type="number" name="credits" id="credits" value="0">
               </div>
        @endforeach


        <br>
        <hr>
       <br/>
        {{form::hidden('_method', 'PUT')}}
        {{form::submit('Submit', ['class'=>'btn btn-primary'])}}
        {!! Form::close() !!}
    @endforeach
@endsection
 