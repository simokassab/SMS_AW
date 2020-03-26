<?php 
    define("SITE_URL", "http://".$_SERVER['SERVER_NAME']."/SMS_AWWAL/CMS/public/");
?>
<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>BULK CMS</title>

         <link rel="stylesheet" href="{{asset('css/app.css')}}">
         <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
     <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.8/css/all.css"      integrity="sha384-3AB7yXWz4OeoZcPbieVW64vVXEwADiYyAEhwilzWsLw+9FgqpyjjStpPnpBO8o8S" crossorigin="anonymous">


<script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js" integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ" crossorigin="anonymous"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js" integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY" crossorigin="anonymous"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.18/datatables.min.css"/>

<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.18/datatables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
<script src="https://unpkg.com/flickity@2/dist/flickity.pkgd.min.js"></script>

<script>
$(document).ready(function (e) {
    $('#users').DataTable( {
        responsive: true,
        "pagingType": "full_numbers"
    });
    $('#ctable').DataTable( {
        responsive: true,
        "pagingType": "full_numbers"
    });
    $('#cltable').DataTable( {
        responsive: true,
        "pagingType": "full_numbers"
    });


});
</script>
<style>
    .btn-danger {
        background-color: #EB078C !important;
        border-color: #EB078C !important;
    }

    .btn-danger:hover {
        background-color: #eb0469 !important;
        border-color: #eb0469 !important;
    }

    .btn-warning {
        background-color: #7ACCC4 !important;
        border-color: #7ACCC4 !important;
    }

    .btn-warning:hover {
        background-color: #77cc9d !important;
        border-color: #77cc9d !important;
    }

    .btn-info {
        background-color: #38B9C2 !important;
        border-color: #38B9C2 !important;
    }
    .btn-info:hover {
        background-color: #4F276C !important;
        border-color: #4F276C !important;
    }

    .page-item.active .page-link {
        background-color: #53B9E9 !important;
        border-color: #53B9E9 !important;
    }

    .btn-primary {
        background-color: #53B9E9 !important;
        border-color: #53B9E9 !important;
    }

    .btn-primary:hover {
        background-color: #4ba0e9 !important;
        border-color: #4ba0e9 !important;
    }

    .btn-success {
        background-color: #4CB848 !important;
        border-color: #4CB848 !important;
    }

    .btn-success:hover {
        background-color: #00b804 !important;
        border-color: #00b804 !important;
    }
    .iframereport {
        margin-top: 2% ;
        border:24px solid transparent;
        border-radius: 8%;
        border-image: url(./img/iphone.png) 30% round;
        border-image-width: 100px;
        overflow: scroll;
        opacity: 0.9;
    }
    .thumbnail1 iframe {
        width: 100%;
        height: 1000px;
    }
    .thumbnail1 {
        position: relative;
        -ms-zoom: 0.8;
        -moz-transform: scale(0.8);
        -moz-transform-origin: 0 0;
        -o-transform: scale(0.8);
        -o-transform-origin: 0 0;
        -webkit-transform: scale(0.8);
        -webkit-transform-origin: 0 0;
    }

    .thumbnail-container1 {
        width: 88%;
        height: 900px;
        display: inline-block;
        overflow: hidden;
        position: relative;
    }
    .thumbnail iframe {
        opacity: 0;
        transition: all 1200ms ease-in-out;
    }
       .container {
      max-width: 960px;
    }

/*
 * Custom translucent site header
 */

.site-header {
  background-color: rgba(0, 0, 0, .85);
  -webkit-backdrop-filter: saturate(180%) blur(20px);
  backdrop-filter: saturate(180%) blur(20px);
}
.site-header a {
  color: #999;
  transition: ease-in-out color .15s;
}
.site-header a:hover {
  color: #fff;
  text-decoration: none;
}

/*
 * Dummy devices (replace them with your own or something else entirely!)
 */

.product-device {
  position: absolute;
  right: 10%;
  bottom: -30%;
  width: 300px;
  height: 540px;
  background-color: #333;
  border-radius: 21px;
  -webkit-transform: rotate(30deg);
  transform: rotate(30deg);
}

.product-device::before {
  position: absolute;
  top: 10%;
  right: 10px;
  bottom: 10%;
  left: 10px;
  content: "";
  background-color: rgba(255, 255, 255, .1);
  border-radius: 5px;
}

.product-device-2 {
  top: -25%;
  right: auto;
  bottom: 0;
  left: 5%;
  background-color: #e5e5e5;
}


/*
 * Extra utilities
 */

.flex-equal > * {
  -ms-flex: 1;
  flex: 1;
}
@media (min-width: 768px) {
  .flex-md-equal > * {
    -ms-flex: 1;
    flex: 1;
  }
}

.overflow-hidden { overflow: hidden; }

    </style>
</head>
<body>
@include('inc.navbar')
 <div id='container-fluid' style='margin: 0 5% 0 5%;'>
    <br/>
    @include('inc.messages')
    @yield('content')
 </div>

<?php if (Auth::check()) {
    //header("Location: login.php");
}
else {
    return redirect('auth/login');
}
?>
</html>

