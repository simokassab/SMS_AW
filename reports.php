<meta http-equiv="refresh" content="300">
<?php
ob_start();
session_start();
header('Content-type:text/html; charset=utf-8');
include_once('classes/login.php');
include_once('classes/groups.php');
include_once('classes/visitors.php');
include_once('classes/campaigns.php');
$page='reports';
$log= new login();
$gr= new groups();
$visitor= new visitors();
$res=$log->checklogin();

$gr_all=$gr->getAll($_SESSION['user_id']);

$cmp= new campaigns();
$viewcamp = $cmp->getAllview($_SESSION['user_id']);

if(!$res)
    header("Location: login.php");

$nv=$visitor->getVisitors($_SESSION['user_id']);
?>
<?php include('includes/header.php');
?>

<script src="https://code.highcharts.com/highcharts.js"></script>

<script>
    $(document).ready(function() {
        $('#table').DataTable( {
            responsive: true,
            "pagingType": "full_numbers"
        });
        $('.campidtable').click(function() {
            var id= $(this).attr('id');
            window.setTimeout(function () {
                location.href='campreports.php?i='+id;
            }, 20);
        });
    });
</script>
<body class='bg'>
<?php include('includes/nav.php');
?>

<h1 class='titlee'> Reports</h1><hr/>
<div class="container-fluid">
    <div class="row">
        <div class="col col-md-3 div1" style="border:2px solid #38B9C2; background-color: white;">

            <h6 style="margin-left: 3%;margin-top: 1%;position: relative;">Number of Visitors last 15 days</h6>
            <hr>

            <div style="text-align: center">
                <div id="chart" style="min-width: 280px; height: 240px; margin: 0 auto"></div>
                <script type="text/javascript">
                    <?php include_once "./requests/reports/nbvisitors.php"?>
                </script>
            </div>
        </div>
        <div class="col col-md-3 div1"  style="border:2px solid #77A033; background-color: white;">
                <h6 style="margin-left: 3%;margin-top: 3%;">Number of Campaigns</h6><hr>
            <div id="chartcamp" style="min-width: 280px; height: 240px; margin: 0 auto"></div>
            <script type="text/javascript">
                <?php include_once "./requests/reports/campaigns.php"?>
            </script>

        </div>
        <div class="col col-md-3 div1" style="border:2px solid #C0504E; background-color: white;">

            <h6 style="margin-left: 3%;margin-top: 1%;position: relative;">Visitors / Hour</h6>
            <hr>

            <div style="text-align: center">
                <div id="charthour" style="min-width: 280px; height: 240px; margin: 0 auto"></div>
                <script type="text/javascript">
                    <?php include_once "./requests/reports/nbvisitors_hour.php"?>
                </script>
            </div>
        </div>
    </div>
    <br/>
    <div class="row div2" >

        <div class="col col-sm-9 live"  >

            <script>
                $(document).ready(function() {
                    $('#visit_day').load('./requests/reports/visitor_day.php?p=reports');
                    setInterval(function(){
                        $('#visit_day').load('./requests/reports/visitor_day.php?p=reports');
                    }, 3000);
                });
                var chart; // global
                function requestData() {
                    $.ajax({
                        url: './requests/reports/nbvisitors_day.php?p=reports',
                        success: function(point) {
                            var series = chart.series[0],
                                shift = series.data.length > 200; // shift if the series is longer than 20

                            chart.series[0].addPoint(eval(point), true, shift);

                            // call it again after one second
                            setTimeout(requestData, 3000);
                        },
                        cache: false
                    });
                }

                $(document).ready(function() {
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
        <div class="col col-sm-2 nbvisitor" >
            <img src="./img/LIVE.gif">
            <h6>Number of Visitors in Day</h6><hr>
            <p id='visit_day' style="color: #38B9C2; font-size: 58px; text-align: center"> </p>
            <hr>

        </div>
    </div>
    <div class='row camptable'>
        <div class="col col-md-12">
            <table  id='table' class="table  table-bordered hover" style="width:100%">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Type</th>
                    <th>Status</th>
                    <th>SMS Body</th>
                    <th>Sending Date</th>
                    <th>Sender</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach($viewcamp as $cmp){
                    //  echo $g['']
                    ?>
                    <tr class='campidtable' id='<?php echo $cmp['id']; ?>'>
                        <td><?php echo $cmp['name'];?></td>
                        <td><?php echo $cmp['type'];?></td>
                        <?php
                        if($cmp['CMP_STATUS']=='SENT'){
                            echo '<td style="color: #4CB848; font-weight: bolder">'.$cmp['CMP_STATUS'].'</td>';
                        }
                        else if($cmp['CMP_STATUS']=='SOCIAL') {
                            echo '<td style="color: #38B9C2; font-weight: bolder">'.$cmp['CMP_STATUS'].'</td>';
                        }
                        else {
                            echo '<td style="color: #EB078C; font-weight: bolder">'.$cmp['CMP_STATUS'].'</td>';
                        }
                        ?>
                        <td><?php if($cmp['body'] === NULL) { echo "Social Campaign !";} else  echo $cmp['body'];?></td>
                        <td><?php if($cmp['date'] === NULL) { echo $cmp['created_at'];} else  echo $cmp['date'];?></td>
                        <td><?php if($cmp['S_NAME'] === NULL) { echo "Social Campaign !";} else  echo $cmp['S_NAME'];?></td>

                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
<div>
</div>
</div>

</body>
