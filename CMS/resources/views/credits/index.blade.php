@extends('layouts.app')

@section('content')
    <center><h1>Credits </h1></center>
        <a href="./logout" class="btn btn-danger a-btn-slide-text">
            <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
            <span><strong>Logout</strong></span>            
        </a>
    <hr>
    <table class="table table-bordered table-bordered" id="ctable">
        <thead>
        <tr>
            <td>Name</td>
            <td>Company</td>
            <td>Nb of Credits</td>
            <td>CONTROL</td>
        </tr>
        </thead>
        <tbody>
            @foreach($credits as $s)
                <tr>
                    <td>{{$s->US_NAME}}</td>
                    <td>{{$s->CMP}}</td>
                    <td>{{$s->credit}}</td>
                    <td><a href='credits/{{$s->US_ID}}/addcredits' class="btn btn-primary a-btn-slide-text">
                            <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
                            <span><strong>Add Credits</strong></span>
                        </a></td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <br>
    <hr style="border-top: 2px solid red; ">
    <br>
    <center><h1>Credits Logs </h1></center>
    <table class="table table-bordered table-bordered" id="cltable">
        <thead>
        <tr>
            <td>Name</td>
            <td>Company</td>
            <td>Nb of Credits</td>
            <td>Date</td>
        </tr>
        </thead>
        <tbody>
        @foreach($logs as $l)
            <tr>
                <td>{{$l->US_NAME}}</td>
                <td>{{$l->CMP}}</td>
                <td>{{$l->credits}}</td>
                <td>{{$l->date}}</td>

            </tr>
        @endforeach
        </tbody>
    </table>
@endsection

 