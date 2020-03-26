@extends('layouts.app')

<?php 
    $id='';
?>
@section('content')
    
    @foreach ($camp as $u)
    <?php 
        $id=$u->CMP_ID;
    ?>
    <div class="jumbotron">
        <h1 class="display-4">Name: <i>{{$u->CMP_NAME}}</i></h1><br>
        <br/>
        <div class="row">
            <div class="col col-sm-4">
                <p class="lead">Campaign Type: <i>{{$u->CMP_TYPE}}</i></p>
            </div>
            <div class="col col-sm-4">
                <p class="lead">Sending Type: <i>{{$u->CAMP_ST}}</i></p>
            </div>
            <div class="col col-sm-4">
                <p class="lead">User: <i>{{$u->US_NAME}}</i></p>
            </div>
        </div>
       
        <hr class="my-4">
        <div class="row">
            <div class="col col-sm-4">
                <p class="lead">Sender: <i>{{$u->SENDER_NAME}}</i></p>
            </div>
            <div class="col col-sm-4">
                <p class="lead">Group: <i>{{$u->GRS_NAME}}</i></p>
            </div>

        </div>
        <br><br>
        
    </div>
     <div class="row">
            @if(($u->CMP_TYPE =='advanced') || ($u->CMP_TYPE =='social'))
            <div class="col col-sm-8" style=" height: 600px; max-width: 600px; min-width: 700px; border-radius: 3%;margin-right: 5%; text-align: center; ">
                <label> Message Body: </label><br><br>
                <textarea disabled cols="120" rows="8">{{$u->BODY}}</textarea>

                    <div class="thumbnail-container1" >
                        <div class="thumbnail1">
                        <iframe src='http://{{$land[0]->link}}'  frameborder="1" class="iframereport"
                                            style="margin: 2% 0 0 20%; width:86%; overflow: scroll; background-color: #323232"></iframe><br>

                        </div>
                    </div>

                </div>
                <br>
            @else
                <label> Message Body: </label><br><br>
                <textarea disabled cols="120" rows="8">{{$u->BODY}}</textarea>

            @endif
            <hr class="my-4">
            <div class="col col-sm-4">
                <p class="lead">
                <button type="button" class="btn btn-success btn-lg" id='approve'>Approve It! </button><br><br>
                <button type="button" class="btn btn-danger btn-lg" href="#" id='decline' >Reject It!</button>
            </p>
        </div>
        </div>
    @endforeach
@endsection
<script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script>
<script>
 $(document).ready(function (e) {
     var id ='<?php echo $id ?>';
   $('#approve').on('click', function(e){
    e.preventDefault();
     $.ajax({
        method: 'get',
        url: '../'+id+'/approveIt',
        data: id,
        async: true,
        success: function(response){
            console.log(response);
           // if(response=='ok'){
               // $(this).text('Approved..');
                $('#approve').text('Approved');
                location.href='http://localhost/SMS/CMS/public/campaigns';
           // }
        },
        error: function(data){
            console.log(data);
            alert("fail" + ' ' + this.data)
        },
        });
   });
   $('#decline').on('click', function(e){
    e.preventDefault();
     $.ajax({
        method: 'get',
        url: '../'+id+'/declineIt',
        data: id,
        async: true,
        success: function(response){
            console.log(response);
           // if(response=='ok'){
               // $(this).text('Approved..');
                $('#approve').text('Approved');
                location.href='http://localhost/SMS/CMS/public/campaigns';
           // }
        },
        error: function(data){
            console.log(data);
            alert("fail" + ' ' + this.data)
        },
        });
   });
       
});
</script>
 