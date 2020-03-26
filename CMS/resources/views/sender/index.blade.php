@extends('layouts.app')

@section('content')
    <center><h1>Sender </h1></center>
        <a href="./sender/create" class="btn btn-primary a-btn-slide-text">
            <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
            <span><strong>Create New</strong></span>            
        </a>
        <a href="./logout" class="btn btn-danger a-btn-slide-text">
            <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
            <span><strong>Logout</strong></span>            
        </a>
    <hr>
    <table class="table table-bordered table-bordered">
        <thead>
        <tr>
            <td>Name</td>
            <td>User</td>
            <td>Company</td>
            <td>Active</td>
            <td>CONTROL</td>
        </tr>
        </thead>
        <tbody>
            @foreach($sender as $s)
                <tr>
                    <td>{{$s->name}}</td>
                    <td>{{$s->US_NAME}}</td>
                    <td>{{$s->CMP}}</td>
                    @if($s->active==1)
                        <td style="color: #4CB848; font-weight: bolder;">Active</td>
                    @else
                        <td style="color: #38B9C2; font-weight: bolder;">Inactive</td>
                    @endif
                    <td>{!! Form::open(['action'=> ['SenderController@destroy', $s->id], 'method'=>'POST']) !!}
                        <a href='sender/{{$s->id}}/edit' class="btn btn-primary a-btn-slide-text">
                            <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
                            <span><strong>Edit</strong></span>
                        </a>
                        {{form::hidden('_method', 'DELETE')}}
                        {{ Form::button('<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>Delete', array(
                            'type' => 'submit',
                            'class'=> 'btn btn-danger',
                            'onclick'=>'return confirm("Are you sure?")'
                        )) }}
                        {!! Form::close() !!}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
           
@endsection

 