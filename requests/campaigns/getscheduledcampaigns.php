<?php 
ob_start();
session_start();
header('Content-type:text/html; charset=utf-8');
include_once('../../classes/campaigns.php');

$cmp= new campaigns();

$scheduledcamp = $cmp->getScheduledview($_SESSION['user_id']);

echo '<thead>
    <tr>
        <th>Name</th>
        <th>Type</th>
        <th>Status</th>
        <th>SMS Body</th>
        <th>Sending Date</th>
        <th>Sender</th>
        <th class="text-center">Action
        </th>
    </tr>
    </thead>
    <tbody>';

        foreach($scheduledcamp as $cmp){
            echo '<tr id="'.$cmp['id'].'" >
                    <td>'.$cmp['name'].'</td>
                    <td>'.$cmp['type'].'</td>
                    <td style="color: #EB078C; font-weight: bolder">'.$cmp['CMP_STATUS'].'</td>';
                    if($cmp['body'] === NULL) { echo "<td>Social Campaign !</td>";} else  echo '<td>'.$cmp['body'].'</td>';
                    if($cmp['date'] === NULL) { echo "<td>".$cmp['created_at']."</td>";} else  echo '<td>'.$cmp['date'].'</td>';
                    if($cmp['S_NAME'] === NULL) { echo "<td>Social Campaign !</td>";} else  echo '<td>'.$cmp['S_NAME'].'</td>';
                    echo '<td class="text-center">
                        <a href="#" title="Delete Group"  class="btn btn-danger btn-sm">
                            <i class="fa fa-trash-alt" style="color:white";"></i>
                        </a>
                    </td>
                </tr>';
            }
   echo '</tbody>';
    echo '<script>
            $(document).ready(function() {
              $("#scheduledtable").dataTable().fnDestroy();
                $("#scheduledtable").DataTable( {
                responsive: true,
                "pagingType": "full_numbers"
            });
        });
    </script>';
?>