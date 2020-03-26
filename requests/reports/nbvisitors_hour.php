<?php

include_once ('./classes/visitors.php');
$mysqli = getConnected();

$visitor1 = new visitors();
if($page=='camp'){
    $vis1 = $visitor1->getVisitorsPerHourByCamp($_SESSION['user_id'], $_GET['i']);
}
else {
    $vis1 = $visitor1->getVisitorsPerHour($_SESSION['user_id']);
}

$res1="Highcharts.chart('charthour', {
    chart: {
    type: 'areaspline',
    height: 210
    },
     title: {
        text: ''
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
foreach ($vis1 as $v1) {
    $res1.="'".$v1['Hours'].":00:00',";
}
$res1=substr($res1,0, -1);
$res1.="]
    },

    plotOptions: {
    series: {
        fillOpacity: 0.1,
        }
},
tooltip: {
        crosshairs: true,
        shared: true
    },

    series: [{
    color: '#77A033',
    name: 'Visitors', 
    data: [";
foreach ($vis1 as $v1) {
    $res1.=$v1['visitor'].",";
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
});";


echo $res1;
