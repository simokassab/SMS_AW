@extends('layouts.app')
<?php
define("MAIN_URL", "http://".$_SERVER['SERVER_NAME']."/SMS");
?>
<style>
    
</style>
@section('content')
    <style>


        /* Button used to open the contact form - fixed at the bottom of the page */


        /* The popup form - hidden by default */
        .form-popup {
            display: none;
            bottom: 0;
            border: 3px solid #f1f1f1;
            z-index: 9;
        }

        /* Add styles to the form container */
        .form-container {
            max-width: 300px;
            padding: 10px;
            background-color: white;
        }
    </style>


        @foreach($users as $u)
            <div class="container-fluid">
                <center><h1>User: {{$u->full_name}}</h1></center>
                <hr>
                <br>
                <div class="row">
                    <div class="col col-sm-3">
                        <label for="fullname">Full Name:</label>
                        <input disabled type="text" class="form-control" value="{{$u->full_name}}">
                    </div>
                    <div class="col col-sm-3">
                        <label for="username">Username:</label>
                        <input disabled type="text" class="form-control" value="{{$u->username}}">
                    </div>
                    <div class="col col-sm-3">
                        <label for="company">Company:</label>
                        <input disabled type="text" class="form-control" value="{{$u->company}}">
                    </div>
                    <div class="col col-sm-3">
                        <label for="phone">Phone:</label>
                        <input disabled type="text" class="form-control" value="{{$u->phone}}">
                    </div>
                </div>
                <br><hr>
                <div class="row">
                    <div class="col col-sm-4">
                        <label for="email">Email:</label>
                        <input disabled type="text" class="form-control" value="{{$u->email}}">
                    </div>
                    <div class="col col-sm-4">
                        <label for="a">Username:</label>
                        <textarea disabled type="text" class="form-control"> {{$u->address}}</textarea>
                    </div>
                    <div class="col col-sm-4">
                        <label for="email">Photo:</label>
                        <?php
                        $img = $u->photo;
                        $img = substr($img, 1);
                        ?>
                        <img width="120px" src='<?php echo MAIN_URL.$img ?>' />
                    </div>
                </div>
                <br><hr>
                <div class="row">
                    <div class="col col-sm-6">
                        <br>
                        @if($u->active==1)
                            <b  class="text-success">User is Active</b>
                        @else
                            <b  class="text-danger">User is Inactive</b>
                        @endif
                        <br><hr>
                        @if($u->doc_uploaded==1)
                            <b  class="text-success">User is Checked and Accepted</b>
                        @elseif($u->doc_uploaded==0)
                            <b  class="text-warning">User is not yet Checked</b>
                        @else
                            <b  class="text-danger">Document checked and declined</b>
                        @endif
                    </div>
                    <div class="col col-sm-6">
                        <label>Notes:</label><br>
                        <textarea disabled class="form-control">{{$u->notes}}</textarea>
                    </div>
                </div>
                <br>
                <hr style="border-bottom: 2px solid #0B3561;">
                <div class="row">

                    <div class="col col-sm-4" style="border-right: 1px solid #0B3561;">

                        <i class="text-success">Download Documents</i><br>
                        <?php
                       // echo $res;
                          // echo MAIN_URL."/CMS/public/new_users/user_".$u->id;
                       // echo file_exists(MAIN_URL."/CMS/public/new_users/user_".$u->id.".zip");
                       // $exists = remoteFileExists(MAIN_URL."/CMS/public/new_users/user_".$u->id.".zip");

                           $ch = curl_init(MAIN_URL."/CMS/public/new_users/user_".$u->id.".zip");

                           curl_setopt($ch, CURLOPT_NOBODY, true);
                           curl_exec($ch);
                           $retcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                           // $retcode >= 400 -> not found, $retcode = 200, found.
                           if($retcode<400){
                        ?>
                        <a title="Download Documents" href="<?php

                        echo MAIN_URL."/CMS/public/new_users/user_".$u->id ?>.zip">
                            <img width="80px" src="{{asset('img/winrar.png')}}">
                        </a>
                        <?php
                        }
                        else {
                            echo "<br><b> No uploaded files</b>";
                        }
                        curl_close($ch);
                        ?>
                    </div>
                    <div class="col col-sm-4" style="border-right: 1px solid #0B3561;">
                        @if($u->active!=1)
                            <button class="btn btn-danger" onclick="openForm()">Reject</button>
                        @else
                            <button disabled class="btn btn-danger" onclick="openForm()">Reject</button>
                        @endif
                        <div class="form-popup form-group" id="myForm" >
                            {!! Form::open(['action'=> ['UserController@updateStatus', $u->id], 'method'=>'POST', 'enctype' => 'multipart/form-data']) !!}
                                <label for="notes">Notes:</label><br>
                                <textarea required class="form-control" name="notes" id="notes" cols="300" rows="4"></textarea>
                            <br>
                            <br>
                                <button type="submit" class="btn btn-success">Submit</button>
                                <button type="button" class="btn btn-warning" onclick="closeForm()">Close</button>
                            {!! Form::close() !!}
                        </div>

                        <script>
                            function openForm() {
                                document.getElementById("myForm").style.display = "block";
                            }

                            function closeForm() {
                                document.getElementById("myForm").style.display = "none";
                            }
                        </script>
                    </div>
                    <div class="col col-sm-4">
                       <a href="./<?php echo $u->id ?>/edit" class="btn  btn-primary">
                           Go to Edit page
                       </a>
                        @if($u->doc_uploaded!=1)
                            <a  href="./<?php echo $u->id ?>/approvedoc"  class="btn  btn-success">
                                Approve Documents
                            </a>
                        @else
                            <a  href="#"  class="text-success" style="cursor: none;font-weight: bold;">
                                 Documents Approved
                            </a>
                        @endif

                    </div>
                </div>
                <?php
                   // $winrar = MAIN_URL."/CMS/uploads/new_users/users_24.zip";
                ?>


            </div>

        @endforeach
@endsection
<script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script>

<script>
$(document).ready(function (e) {

})
</script>

 