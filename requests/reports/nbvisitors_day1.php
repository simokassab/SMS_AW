<?php
ob_start();
session_start();


include_once ('../../classes/visitors.php');
$mysqli = getConnected();

$visitor1 = new visitors();
$vis1 = $visitor1->getVisitorsPerHour($_SESSION['user_id']);
$nbcamp = $visitor1->getVisitorsPerday($_SESSION['user_id']);
$res1="<script>Highcharts.chart('chartreal', {
    chart: {
   type: 'spline',
    styledMode: true,
     animation: false,
     height: 400,
    },
     title: {
        text: 'Real Time Visitor'
    },

    subtitle: {
        text: ''
    },

    yAxis: {
        title: {
            text: 'Visitors'
        }
    },
    xAxis: {
    categories: [";
foreach ($vis1 as $v) {
    $res1.="'".$v['Hours']."',";
}
$res1=substr($res1,0, -1);
$res1.="]
    },

    plotOptions: {
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
    series: [{
    color: '#C0504E',
    dashStyle: 'ShortDash',
    name: 'Visitors', 
    data: [";
foreach ($vis1 as $v) {
    $res1.=$v['visitor'].",";
}
$res1=substr($res1,0, -1);
$res1.="]
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
});</script>";


echo $res1;
?>
<script type="text/javascript">

    Highcharts.chart('container', {
        chart: {
            type: 'spline',
            animation: Highcharts.svg, // don't animate in old IE
            marginRight: 10,
            events: {
                load: function () {

                    // set up the updating of the chart each second
                    var series = this.series[0];
                    setInterval(function () {
                        var x = (new Date()).getTime(), // current time
                            y = Math.random();
                        series.addPoint([x, y], true, true);
                    }, 1000);
                }
            }
        },

        time: {
            useUTC: false
        },

        title: {
            text: 'Live random data'
        },
        xAxis: {
            type: 'datetime',
            tickPixelInterval: 150
        },
        yAxis: {
            title: {
                text: 'Value'
            },
            plotLines: [{
                value: 0,
                width: 1,
                color: '#808080'
            }]
        },
        tooltip: {
            headerFormat: '<b>{series.name}</b><br/>',
            pointFormat: '{point.x:%Y-%m-%d %H:%M:%S}<br/>{point.y:.2f}'
        },
        legend: {
            enabled: false
        },
        exporting: {
            enabled: false
        },
        series: [{
            name: 'Random data',
            data: (function () {
                // generate an array of random data
                var data = [],
                    time = (new Date()).getTime(),
                    i;

                for (i = -19; i <= 0; i += 1) {
                    data.push({
                        x: time + i * 1000,
                        y: Math.random()
                    });
                }
                return data;
            }())
        }]
    });
</script>
