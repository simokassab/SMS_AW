<?php 
define("MAIN_URL", "http://".$_SERVER['SERVER_NAME']."/SMS");
?>
@extends('layouts.app')

@section('content')
    <center><h1>Edit  User </h1></center>
    @foreach ($users as $us)
        {!! Form::open(['action'=> ['UserController@update', $us->id], 'method'=>'POST', 'enctype' => 'multipart/form-data']) !!}
        <div class="row">
            <div class="col col-sm-3" style="border-right: 1px solid #0B3561; ">
                <div class="form-group">
                    {{form::label('name', 'Name')}}
                    {{form::text('fullname', $us->username, ['class'=>'form-control', 'placeholder'=>'Full Name'])}}
                </div>
            </div>
            <div class="col col-sm-3" style="border-right: 1px solid #0B3561; ">
                <div class="form-group">
                    {{form::label('username', 'UserName')}}
                    {{form::text('username', $us->username, ['class'=>'form-control', 'placeholder'=>'USername'])}}
                </div>
            </div>
            <div class="col col-sm-3" style="border-right: 1px solid #0B3561; ">
                <div class="form-group">
                    {{form::label('email', 'Email')}}
                    {{form::text('email', $us->email, ['class'=>'form-control', 'placeholder'=>'Email'])}}
                </div>
            </div>
            <div class="col col-sm-3" >
                <div class="form-group">
                    {{form::label('address', 'Address')}}
                    {{form::text('address', $us->address, ['class'=>'form-control', 'placeholder'=>'Address'])}}
                </div>
            </div>
        </div>
        <br><hr> <br>
        <div class="row">
            <div class="col col-sm-3" style="border-right: 1px solid #0B3561; ">
                <div class="form-group">
                    {{form::label('phone', 'Phone')}}
                    {{form::text('phone', $us->phone, ['class'=>'form-control', 'placeholder'=>'Phone'])}}
                </div>
            </div>
            <div class="col col-sm-3"  style="border-right: 1px solid #0B3561; ">
                <div class="form-group">
                    {{form::label('company', 'Company')}}
                    {{form::text('company', $us->company, ['class'=>'form-control', 'placeholder'=>'Company'])}}
                </div>
            </div>
            <div class="col col-sm-3" style="border-right: 1px solid #0B3561; ">
                <div class="form-group">
                    {{form::label('img', 'Change your Image: ')}}
                    {!! form::file('image', array('class' => 'form-control')) !!}
                </div>
            </div>
            <div class="col-sm-3" style="border-right: 1px solid #0B3561; ">
                <label for="filter">Filter: </label><br>
                @if($us->filter==1)
                    <input type="radio" name="filter"  id="filter" value="0">Yes
                    <input type="radio" name="filter" id="filter" checked  value="1" style="margin-left:20% ;">No
                @else
                    <input type="radio" name="filter"  id="filter" checked value="0">Yes
                    <input type="radio" name="filter" id="filter"   value="1" style="margin-left:20% ;">No
                @endif
            </div>
        </div>
        <hr>
        <div class="row">
                <div class="col col-sm-12">
                    <center>
                    <label>Image: </label>
                    <div>
                        <?php
                        $img = $us->photo;
                        $img = substr($img, 1);
                        // echo $img;
                        ?>
                        <img width="120px" src='<?php echo MAIN_URL.$img ?>' />
                    </div><br/>
                    </center>
                </div>
        </div>
        <hr>
        <div class="row">
            <div class="col col-sm-12">
                {{form::hidden('_method', 'PUT')}}
               <button type="submit" class="btn btn-primary" style="width: 100%;">Save</button>
            </div>
        </div>


        {!! Form::close() !!}
    @endforeach
@endsection
 