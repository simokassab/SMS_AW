@extends('layouts.app')
 <meta http-equiv="refresh" content="400">
@section('content')
    <center><h1>Campaign Manager </h1></center>
        <a href="./logout" class="btn btn-danger a-btn-slide-text">
            <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
            <span><strong>Logout</strong></span>            
        </a>
    <hr>
    <?php 
        $las =0;
       
    ?>
    <table class="table table-bordered table-bordered">
        <thead>
        <tr>
            <td>Name</td>
            <td>Type</td>
            <td>Sending Type</td>
            <td>User</td>
            <td>Sender</td>
            <td>To Group</td>
            <td>Sending Date</td>
            <td>Control</td>
        </tr>
        </thead>
        <tbody>
            @if(count($camp))
            <?php  $las = $last[0]->id; ?>
                @foreach($camp as $u)
                    <tr>
                        <td>{{$u->CMP_NAME}}</td>
                        <td>{{$u->CMP_TYPE}}</td>
                        <td>{{$u->CAMP_ST}}</td>
                        <td>{{$u->US_NAME}}</td>
                        <td>{{$u->SENDER_NAME}}</td>
                        <td>{{$u->GRS_NAME}}</td>
                        <td>{{$u->Q_DATE}}</td>
                        <td>{!! Form::open(['action'=> ['CampaignController@destroy', $u->CMP_ID], 'method'=>'POST']) !!}
                            <a href='./campaigns/{{$u->CMP_ID}}/edit' class="btn btn-primary a-btn-slide-text">
                                <span class="fa fa-eye" aria-hidden="true"></span>
                                <span><strong>View</strong></span>
                            </a>
                    </tr>
                @endforeach
            @else
                    <tr><td colspan="8"><center>No campaigns !</center></td></tr>
            @endif
        </tbody>
    </table>
@endsection
<script src="http://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script>

 <script>
$(document).ready(function (e) {
    document.addEventListener('DOMContentLoaded', function () {
    if (!Notification) {
        alert('Desktop notifications not available in your browser. Try Chromium.'); 
        return;
    }

    if (Notification.permission !== "granted")
        Notification.requestPermission();
    });

    function notifyMe() {
    if (Notification.permission !== "granted")
        Notification.requestPermission();
    else {
        var notification = new Notification('New Campagin', {
        icon: 'http://localhost/SMS/img/mwlogo@4x.png',
        body: "New Campagin Has been Created!",
        });

        notification.onclick = function () {
            window.close();
        };

    }

    }
   var last = <?php echo $las; ?>;
   var newid='';
   var interval;
   //console.log(last);
   interval = window.setInterval(function(){
        $.ajax({
        method: 'get',
        url: './getLast',
        data: last,
        async: true,
        success: function(response){
            console.log(response);
            if (response.length  === 0) { 
                return;
            }
            else {
                console.log(response[0]['id']);
                newid = response[0]['id']
                
                if((newid==last) || (newid < last)){
                    return;
                }
                else {
                // document.title = '(1) ALERT!!';
                    alert('NEw campaign has been added');
                // notifyMe();
                    location.href='./campaigns';
                }
            } 
        },
        error: function(data){
            console.log(data);
           // alert("fail" + ' ' + this.data)
        },
        });
    }, 3000000);

});
</script>