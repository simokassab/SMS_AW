
<meta http-equiv="refresh" content="300">
<script src="https://code.highcharts.com/highcharts.src.js"></script>
<?php
ob_start();
session_start();
header('Content-type:text/html; charset=utf-8');
include_once('classes/login.php');
include_once('classes/groups.php');
include_once('classes/visitors.php');
include_once('classes/campaigns.php');
include_once('classes/queue.php');
include_once('classes/links.php');
include_once('classes/form.php');
include_once('classes/events.php');
$page='camp';
$log= new login();
$gr= new groups();
$links= new links();
$form= new form();
$groups=new groups();
$gr_all=$groups->getAll($_SESSION['user_id']);
$events= new events();
$link = $links->getLinkByCampID($_GET['i']);
//echo $link;
$queue = new queue();
$que = $queue->getSingleRowByCampID($_GET['i']);

$visitor= new visitors();
$res=$log->checklogin();

$gr_all=$gr->getAll($_SESSION['user_id']);

$cmp= new campaigns();
$camp = $cmp->getRowByID($_GET['i']);


//echo $camp[1];

if(!$res)
    header("Location: login.php");

$nv=$visitor->getVisitors($_SESSION['user_id']);
?>
<?php include('includes/header.php');
?>
<Style>
    .iframereport {
        margin-top: 2% ;
        border:24px solid transparent;
        border-radius: 7%;
        padding-top: 10px;
        padding-bottom: 10px;
        padding-left: 2px;
        padding-right: 2px;
        border-image: url(./img/iphone.png) 30% round;
        border-image-width: 100px;
        overflow: scroll;
        opacity: 1;
    }
    .thumbnail1 iframe {
        width: 100%;
        height: 900px;
    }
    .thumbnail1 {
        position: relative;
        -ms-zoom: 0.6;
        -moz-transform: scale(0.6);
        -moz-transform-origin: 0 0;
        -o-transform: scale(0.6);
        -o-transform-origin: 0 0;
        -webkit-transform: scale(0.6);
        -webkit-transform-origin: 0 0;
    }
    .thumbnail1:after {
        content: "";
        display: block;
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
    }
    .thumbnail-container1 {
        width: 68%;
        height: 900px;
        display: inline-block;
        overflow: hidden;
        position: relative;
    }
    .thumbnail iframe {
        opacity: 0;
        transition: all 300ms ease-in-out;
    }
</Style>

<body class='bg'>
<?php include('includes/nav.php');
?>
    <h1 class='titlee'> Reports</h1>
    <div class="container-fluid">
        <input type="hidden" name="sendingtype" id="sendingtype" value="<?php echo $camp[3]; //sendting type  ?>">
        <input type="hidden" name="type" id="type" value="<?php echo $camp[2]; //camp type  ?>">
        <input type="hidden" name="type" id="campid" value="<?php echo $camp[0]; //camp type  ?>">
        <div class="row">
            <div class="col col-sm-4" style="margin-left: 8%;">
                <div class="campdetails" style=" margin-top: 30%; background-color: white; min-height: 300px; border-radius: 1%; border: 1px solid #38B9C2; ">
                    <p style="color: #7D7D7D; font-size: 1.3vw; margin: 2% 0 5% 8%;"><i class="fa fa-bullhorn" style="margin-right: 4%; color: #38B9C2;"></i> Campaign Name:
                        <u style="color: #38B9C2;font-size: 1vw; ">
                        <?php echo $camp[1]; ?></u>
                    </p><hr>
                    <?php
                        if($camp[2]=='advanced'){
                    ?>
                    <p style="color: #7D7D7D; font-size: 1.3vw; margin: 2% 0 5% 8%;"><i class="fas fa-cog" style="margin-right: 4%; color: #38B9C2;"></i> Campaign Sending Type:
                        <u style="color: #38B9C2;font-size: 1vw; margin-left: 35%; margin-top: 3%;">
                            <?php echo $camp[3]; ?></u>
                    </p><hr>
                    <?php } ?>
                    <p style="color: #7D7D7D; font-size: 1.3vw; margin: 2% 0 1% 8%; "><i class="fa fa-edit" style="margin-right: 4%; color: #38B9C2;"></i>SMS Body:
                    </p>
                    <span style="color: #38B9C2; border: 1px solid #F2F2F2; margin: 0% 0 0 19%;">
                        <?php
                        if($camp[2]=='social'){
                            echo "<img src='https://635.gtbank.com/wp-content/uploads/2018/06/Social-Media-Graphic.jpg' width='250px' height='130px'>";
                        }
                        else {

                            $p= explode(  '?t',  $que['body']) ;
                            echo $p[0];
                        }
                        ?>
                    </span><hr>
                    <p style="color: #7D7D7D; font-size: 1.3vw; margin: 2% 0 5% 8%;"><i class="fa fa-users" style="margin-right: 4%; color: #38B9C2;"></i>Recipient Groups:<br>
                        <span style="color: #38B9C2;font-size: 1vw; margin-left: 25%; margin-top: 5%;">
                            <?php
                            $p="";
                            $grs=$camp[6];
                            $gr=explode(",", $grs);
                            //if($gr[2])
                            foreach($gr_all as $grp){
                                if(in_array($grp['id'], $gr)){
                                    if($gr[1]=="")
                                        $p.=$grp['name'];
                                    else {
                                        $p.=$grp['name'].", ";
                                    }
                                }
                                else {

                                }
                            }
                            if(substr($p, -2)==", "){
                                $p= substr($p, 0, -2);
                            }
                            echo $p;
                                ?></span></p>
                </div>
            </div>
            <?php
                if($camp[2]=='regular'){
                    echo '<div class="col col-sm-6" style="margin-top: 15%;">';
                    echo '<h1 style="color: #38B9C2;">Regular Campaign</h1>';
                    echo '</div>';
                }
                else {
            ?>
            <div class="col col-sm-8" style="background-color: #B0D5E7;  height: 600px; max-width: 600px; min-width: 700px; border-radius: 3%;margin-right: 5%; text-align: center; ">
                <div class="thumbnail-container1" >
                    <div class="thumbnail1">
                        <iframe src="<?php echo LINK."c/".$link.".php"; ?>" sandbox frameborder="1" class="iframereport" onload="this.style.opacity = 2"
                                style="margin: 10% 0 0 30%; width:100%; overflow: scroll; background-color: #323232"></iframe>
                    </div>
                </div>
            </div>
            <?php
                }
            ?>
        </div>
        <hr>
        <?php
            if(($camp[2]!='regular') ) {
                ?> <div class="row" style="text-align: center;margin-left: 7%;">
                    <div class="col col-md-5" style="border:2px solid #38B9C2; background-color: white; margin: 1%; border-radius: 3%;">

                        <h6 style="margin-left: 3%;margin-top: 1%;position: relative;">Number of Visitors last 15 days - <?php echo $camp[1]; ?></h6>
                        <hr>

                        <div style="text-align: center">
                            <div id="chart" style="min-width: 240px; height: 240px; margin: 0 auto"></div>
                            <script type="text/javascript">
                                <?php include_once "./requests/reports/nbvisitors.php"; //visitor last 15 days ?>
                            </script>
                        </div>
                    </div>
                    <div class="col col-md-5 " style="border:2px solid #C0504E; background-color: white; margin: 1%; border-radius: 3%;">

                        <h6 style="margin-left: 3%;margin-top: 1%;position: relative;">Visitors / Hour - <?php echo $camp[1]; ?></h6>
                        <hr>

                        <div style="text-align: center">
                            <div id="charthour" style="min-width: 240px; height: 240px; margin: 0 auto"></div>
                            <script type="text/javascript">
                                <?php include_once "./requests/reports/nbvisitors_hour.php"?>
                            </script>
                        </div>
                    </div>
                </div>
                <br/>
                <div class="row ">
                    <div class="col col-sm-9 live">
                        <script>
                            $(document).ready(function () {
                            $('#table1').DataTable( {
                                responsive: true,
                                "pagingType": "full_numbers"
                            });
                            $('#visit_day').load('./requests/reports/visitor_day.php?p=camp&campid=' +<?php echo $camp[0]; ?>);
                            setInterval(function () {
                                $('#visit_day').load('./requests/reports/visitor_day.php?p=camp&campid=' +<?php echo $camp[0]; ?>);
                            }, 3000);
                            });
                            var chart; // global
                            function requestData() {
                                $.ajax({
                                    url: './requests/reports/nbvisitors_day.php?p=camp&campid=' +<?php echo $camp[0]; ?>,
                                    success: function (point) {
                                        var series = chart.series[0],
                                            shift = series.data.length > 200; // shift if the series is longer than 200

                                        chart.series[0].addPoint(eval(point), true, shift);

                                        // call it again after one second
                                        setTimeout(requestData, 3000);
                                    },
                                    cache: false
                                });
                            }

                            $(document).ready(function () {
                                chart = new Highcharts.Chart({
                                    chart: {
                                        renderTo: 'container',
                                        defaultSeriesType: 'spline',
                                        zoomType: 'x',
                                        events: {
                                            load: requestData
                                        }
                                    },
                                    time: {
                                        useUTC: false
                                    },

                                    title: {
                                        text: 'Live Visitors'
                                    },
                                    subtitle: {
                                        text: document.ontouchstart === undefined ?
                                            'Click and drag in the plot area to zoom in' : 'Pinch the chart to zoom in'
                                    },
                                    plotOptions: {
                                        area: {
                                            fillColor: {
                                                linearGradient: {
                                                    x1: 0,
                                                    y1: 0,
                                                    x2: 0,
                                                    y2: 1
                                                },
                                                stops: [
                                                    [0, Highcharts.getOptions().colors[0]],
                                                    [1, Highcharts.Color(Highcharts.getOptions().colors[0]).setOpacity(0).get('rgba')]
                                                ]
                                            },
                                            marker: {
                                                radius: 2
                                            },
                                            lineWidth: 1,
                                            states: {
                                                hover: {
                                                    lineWidth: 1
                                                }
                                            },
                                            threshold: null
                                        },
                                        series: {
                                            fillOpacity: 0.1,
                                            animation: false,
                                        },
                                        spline: {
                                            marker: {
                                                enabled: true
                                            }
                                        }
                                    },
                                    tooltip: {
                                        crosshairs: true,
                                        shared: true
                                    },
                                    xAxis: {
                                        type: 'datetime',

                                    },
                                    yAxis: {
                                        title: {
                                            text: 'Nb Visotors',
                                        }
                                    },
                                    series: [{
                                        name: 'Visitors',
                                        color: '#C0504E',
                                        dashStyle: 'ShortDash',
                                        data: []
                                    }],
                                    responsive: {
                                        rules: [{
                                            condition: {
                                                maxWidth: 280,
                                                maxHeight: 240
                                            },
                                            chartOptions: {
                                                legend: {
                                                    layout: 'horizontal',
                                                    align: 'center',
                                                    verticalAlign: 'bottom'
                                                }
                                            }
                                        }]
                                    }
                                });
                            });
                        </script>
                        <div id="container" style="width: 90%; height: 400px; margin: 0 auto"></div>

                    </div>
                    <div class="col col-sm-2 nbvisitor">
                        <img src="./img/LIVE.gif">
                        <h6>Number of Visitors in Day</h6>
                        <hr>
                        <p id='visit_day' style="color: #38B9C2; font-size: 58px; text-align: center"></p>
                        <hr>

                    </div>
                </div>
                <?php
                    $forms = $form->getAllByCampID($_GET['i']);
                    $titles=array();
                    if(empty($forms)){

                    }
                    else {
                        $temp = $forms[0]['data'];
                        $str= explode('&', $temp);
                        foreach ($str as $s){
                            $string = explode(":", $s);
                            array_push($titles, $string[0]);
                        }
                       // print_r($titles);

                 ?>
                   <div class="row " style="margin-top: 40px; padding: 20px;  border:2px solid #C0504E; background-color: white;  border-radius: 3%;">
                       <div class="col col-md-12">
                           <table  id='table2' class="table  table-bordered hover" style="width:100%">
                               <thead>
                                   <tr>
                                    <?php
                                        foreach ($titles as $t){
                                            echo "<th>".$t."</th>";
                                        }
                                    ?>
                                   </tr>
                               </thead>
                               <tbody>
                                    <?php
                                        foreach ($forms as $f){
                                            echo "<tr>";
                                            $data = $f['data'];
                                            $str= explode('&', $data);
                                            foreach ($str as $s) {
                                                $string = explode(":", $s);
                                                echo "<td>".$string[1]."</td>";
                                            }
                                            echo "</tr>";
                                        }
                                    ?>
                               </tbody>
                           </table>
                           <script>
                               $(document).ready(function() {
                                   $("#table2").dataTable().fnDestroy();
                                   $('#table2').DataTable( {
                                       responsive: true,
                                       "pagingType": "full_numbers",
                                       dom: 'Bfrtip',
                                       buttons: [
                                           'copyHtml5',
                                           'excelHtml5',
                                           'csvHtml5',
                                           'pdfHtml5'
                                       ]
                                   });
                               });
                           </script>
                       </div>
                   </div>
                <?php
                    }

                $yt= $events->getCountByEvent('YTPLAYED', $_GET['i']);
                $clicktocall= $events->getCountByEvent('CLICKTOCALL', $_GET['i']);
                $fcbk= $events->getCountByEvent('FACEBOOK', $_GET['i']);
                $twitter= $events->getCountByEvent('TWITTER', $_GET['i']);
                $ytended= $events->getCountYTEnded($_GET['i']);
                ?>
                    <div class="row" style=" margin-top: 4% ;padding: 20px; text-align: center;  border:2px solid #0881BD; background-color: white;  border-radius: 3%;">
                        <div class="col col-md-4" style="border-right: 1px solid red;">
                            <div class="row">
                                <div class="col col-sm-6">
                                    <h6>Facebook</h6>
                                    <hr>
                                    <p id='facebookvisitors' style="color: #38B9C2; font-size: 58px; text-align: center"><?php echo $fcbk; ?></p>
                                    <hr>
                                </div>
                                <div class="col col-sm-6">
                                    <h6>Twitter</h6>
                                    <hr>
                                    <p id='twittervisitors' style="color: #38B9C2; font-size: 58px; text-align: center"><?php echo $twitter; ?></p>
                                    <hr>
                                </div>
                            </div>
                        </div>
                        <div class="col col-md-4" style="border-right: 1px solid red;">
                            <div class="row">
                                <div class="col col-sm-6">
                                    <h6>Youtube</h6>
                                    <hr>
                                    <p id='ytvisitors' style="color: #38B9C2; font-size: 58px; text-align: center"><?php echo $yt; ?></p>
                                    <hr>
                                </div>
                                <div class="col col-sm-6">
                                    <h6>Youtube / Ended</h6>
                                    <hr>
                                    <p id='ytendedvisitors' style="color: #38B9C2; font-size: 58px; text-align: center"><?php echo $ytended; ?></p>
                                    <hr>
                                </div>
                            </div>
                        </div>
                        <div class="col col-md-4" style="border-right: 1px solid red;">
                            <div >
                                <h6>Click to Call</h6>
                                <hr>
                                <p id='clicktocallvisitors' style="color: #38B9C2; font-size: 58px; text-align: center"><?php echo $clicktocall; ?></p>
                                <hr>
                            </div>
                        </div>
                    </div>
                <?php
             }
             //echo $camp[2];
                if(($camp[2]=='regular') || ($camp[2]=='advanced')) {
                    $q= $queue->getRowByCampID($_GET['i']);
                ?>
                    <div class='row' style="margin-top: 40px; padding: 20px;  border:2px solid #79A135; background-color: white;  border-radius: 3%;">
                        <div class="col col-md-12">
                            <table  id='table1' class="table  table-bordered hover" style="width:100%">
                                <thead>
                                <tr>
                                    <th>Phone</th>
                                    <th>Text Message</th>
                                    <th>
                                        <?php
                                        $now = date("Y-m-d H:i:s");
                                       // echo $now;
                                        $datetime=date($q[0]['date']);
                                      //  echo $datetime;
                                        $dnow = strtotime($now);
                                        $ddate = strtotime($datetime);
                                        if($dnow < $ddate){
                                            echo "Sending Date";
                                        }
                                        else {
                                            echo "Sent Date";
                                        }
                                        ?>
                                    </th>
                                    <th>Status</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach($q as $que){
                                    //  echo $g['']
                                    ?>
                                    <tr class="campidtable" id='<?php echo $que['id']; ?>'>
                                        <td ><?php echo $que['msisdn'];?></td>
                                        <td class="bodyy"><?php echo $que['body'];?></td>
                                        <?php
                                        $now = date("Y-m-d H:i:s");
                                      //  echo $now;
                                        $datetime=$que['date'];
                                        $dnow = strtotime($now);
                                        $ddate = strtotime($datetime);
                                        if($dnow < $ddate){
                                            echo '<td style="color: #4CB848; font-weight: bolder">'.$que['date'].'</td>';
                                            echo '<td style="color: #EB078C; font-weight: bolder">IN QUEUE</td>';
                                        }
                                        else {

                                            echo '<td style="color: #EB078C; font-weight: bolder">'.$que['date'].'</td>';
                                            echo '<td style="color: #4CB848; font-weight: bolder">SENT</td>';
                                        }

                                        ?>
                                    </tr>
                                <?php } ?>
                                </tbody>
                            </table>
                            <script type="text/javascript" src="./js/pdfmake.min.js"></script>
                            <script type="text/javascript" src="./js/vfs_fonts.js"></script>
                            <script>
                                $(document).ready(function() {
                                    $("#table1").dataTable().fnDestroy();
                                    var d = new Date();
                                    var strDate = d.getFullYear() + "/" + (d.getMonth()+1) + "/" + d.getDate();

                                    pdfMake.fonts = {
                                        Roboto:  {
                                            normal: 'NotoKufiArabic-Regular.ttf',
                                            bold: 'NotoKufiArabic-Regular.ttf',
                                            italics: 'NotoKufiArabic-Regular.ttf',
                                            bolditalics: 'NotoKufiArabic-Regular.ttf'
                                        }
                                    };
                                    $('#table1').DataTable( {
                                        responsive: true,
                                        "pagingType": "full_numbers",
                                        dom: 'Bfrtip',
                                        "buttons": [
                                            'copyHtml5',
                                            {
                                                extend: 'excelHtml5',
                                                title: "Report -"+strDate,
                                                filename: "Camp-Report-"+strDate,
                                                "createEmptyCells" : true,
                                                sheetName: 'Campaign Report',

                                            },
                                            {
                                                "extend": "csvHtml5",
                                                "text": "CSV",
                                                filename: "Camp-Report-"+strDate,
                                                "charset": "utf-8",
                                                "bom": "true",

                                            },
                                           // {
                                         //       extend: 'pdf',
                                         //       text: 'PDF',
                                         //       customize: function (doc) {
                                         //           doc.defaultStyle.font = 'Roboto';
                                        //            },
                                        //    }

                                        ]
                                    });
                                });
                            </script>
                        </div>
                    </div>
                <?php
                    }
                ?>
    </div>
</body>

<script>
    $(document).ready(function () {
        var camptype=$('#type').val();
        var sendingtype=$('#sendingtype').val();
        var campid=$('#campid').val();
        $('.campidtable').click(function() {
            var id= $(this).attr('id');
            var body = $(this).children('td.bodyy').text();
            var res=body.split('?t=');
           // alert(res[1]);
            if((camptype=='advanced') && (sendingtype=='customized')){
                window.setTimeout(function () {
                    var win = window.open('customized.php?t='+res[1]+'&i='+campid, '_blank');
                   // location.href='customized.php?t='+res[1];
                }, 20);
            }
       });
    });
</script>
