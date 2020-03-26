<?php

include_once ('./classes/visitors.php');
    $mysqli = getConnected();

    $visitor = new visitors();
    //echo $page;
    if($page=='camp'){
        $vis = $visitor->getVisitorsByCampSendType($_SESSION['user_id'], $_GET['i'], $_GET['t']);

    }
    else {
        $vis = $visitor->getVisitors($_SESSION['user_id']);
    }

$res="Highcharts.chart('chart', {
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
foreach ($vis as $v) {
    $res.="'".$v['date_']."',";
}
$res=substr($res,0, -1);
$res.="]
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
    color: '#CE6462',
    name: 'Visitors last 15 days', 
    data: [";
foreach ($vis as $v) {
    $res.=$v['Visitors'].",";
}
$res=substr($res,0, -1);
$res.="]
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


    echo $res;
