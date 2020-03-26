@extends('layouts.app')

<style>

</style>
@section('content')
    <center><h1>Users </h1></center>
    <a href="./users/create" class="btn btn-primary a-btn-slide-text">
        <span class="fa fa-plus" aria-hidden="true"></span>
        <span><strong>Create New</strong></span>
    </a>
    <a href="./logout" class="btn btn-danger a-btn-slide-text">
        <span class="fa fa-sign-out-alt" aria-hidden="true"></span>
        <span><strong>Logout</strong></span>
    </a>
    <hr>

    <table id='users' class="table table-bordered table-bordered">
        <thead>
        <tr>
            <td>Full Name</td>
            <td>Username</td>
            <td>Email</td>
            <td>Phone</td>
            <td>Company</td>
            <td>Active</td>
            <td>Documents</td>
            <td>Filter</td>
            <td>CONTROL</td>
        </tr>
        </thead>
        <tbody>
        @foreach($users as $u)
            <tr>
                <td>{{$u->full_name}}</td>
                <td>{{$u->username}}</td>
                <td>{{$u->email}}</td>
                <td>{{$u->phone}}</td>
                <td>{{$u->company}}</td>
                @if($u->active ==1)
                    <td style="color:#45A163; font-weight: bold;">Active</td>
                @else
                    <td style="color: #EB078C;font-weight: bold;">Inactive</td>
                @endif
                @if($u->doc_uploaded ==1)
                    <td style="color:#45A163; font-weight: bold;">Confirmed</td>
                @elseif($u->doc_uploaded ==-1)
                    <td style="color: #EB078C;font-weight: bold;">Cancelled</td>
                @else
                    <td style="color:orange;font-weight: bold;">Not yet Checked</td>
                @endif
                @if($u->filter ==1)
                    <td style="color:#45A163; font-weight: bold;">NO FILTER</td>
                @else
                    <td style="color: #EB078C;font-weight: bold;">FILTERED</td>
                @endif
                <td>
                    <a title="view" href='./users/{{$u->id}}' class="btn btn-primary a-btn-slide-text">
                        <span class="fa fa-eye" aria-hidden="true"></span>

                    </a>
                    <a title="edit" href='./users/{{$u->id}}/edit'  class="btn btn-warning a-btn-slide-text">
                        <span class="fa fa-edit" aria-hidden="true"></span>
                    </a>
                    <a title="Delete" href='./users/delete/{{$u->id}}'  onclick="return confirm('Are you sure you want to delete this user?')" class="btn btn-danger a-btn-slide-text">
                        <span class="fa fa-trash-alt" aria-hidden="true"></span>
                    </a>
                    @if(($u->active==1) && ($u->doc_uploaded==1))
                        <a title="Desactivate" href='./users/destroy/{{$u->id}}' class="btn btn-info"
                           style="color: white" id='des'>
                            <span class="fa fa-stop" aria-hidden="true"></span>
                        </a>
                    @elseif ($u->doc_uploaded!=1)
                        <a style="display: none;" title="Activate" href='./users/activate/{{$u->id}}'
                           class="btn btn-success">
                            <span class="fa fa-check-circle" aria-hidden="true"></span>
                        </a>
                    @elseif($u->doc_uploaded==1)
                        <a title="Activate" href='./users/activate/{{$u->id}}' class="btn btn-success">
                            <span class="fa fa-check-circle" aria-hidden="true"></span>
                        </a>
                @endif
            </tr>
        @endforeach
        </tbody>
    </table>
    <?php
    $ch = curl_init("https://smscorp.iq.zain.com/SMS/CMS/pubddlic/new_users/user_6.zip");

    curl_setopt($ch, CURLOPT_NOBODY, true);
    curl_exec($ch);
    $retcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    // $retcode >= 400 -> not found, $retcode = 200, found.
    if ($retcode < 400) {

    }
    curl_close($ch);
    ?>

@endsection
<script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60="
        crossorigin="anonymous"></script>



 