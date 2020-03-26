<?php

include_once ('./classes/campaigns.php');
    $mysqli = getConnected();

    $camp = new campaigns();
    $campaign = $camp->getCountCampaigns($_SESSION['user_id']);
$res="Highcharts.chart('chartcamp', {
    chart: {
    type: 'column',
    height: 200
    },
     title: {
        text: ''
    },

    subtitle: {
        text: ''
    },

    yAxis: {
        title: {
            text: 'Number of Campaigns'
        }
    },
    xAxis: {
    categories: [";
foreach ($campaign as $v) {
    $res.="'".$v['type']."',";
}
$res=substr($res,0, -1);
$res.="]
    },

    plotOptions: {
    series: {
        fillOpacity: 0.1,
        },
    column: {
                colorByPoint: true
            }
       },
     colors: [
            '#77A033',
            '#C0504E',
            '#0881BD'
        ],
    series: [{
    name: 'Campaigns', 
    data: [";
foreach ($campaign as $v) {
    $res.=$v['NB'].",";
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
