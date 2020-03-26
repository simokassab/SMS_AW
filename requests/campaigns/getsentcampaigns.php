<?php 
ob_start();
session_start();
header('Content-type:text/html; charset=utf-8');
include_once('../../classes/campaigns.php');

$cmp= new campaigns();

$sentcmp = $cmp->getSentview($_SESSION['user_id']);
$social = $cmp->getAllSocial($_SESSION['user_id']);

echo '<thead>
        <tr>
        <th>Name</th>
        <th>Type</th>
        <th>Status</th>
        <th>SMS Body</th>
        <th>Sending Date</th>
        <th>Sender</th>
        <th class="text-center">Action</th>
    </tr>
    </thead>
    <tbody>';

        foreach($sentcmp as $cmp){
        echo '<tr id="'.$cmp['id'].'" class="campidtable">
                <td>'.$cmp['name'].'</td>
                <td>'.$cmp['type'].'</td>';
                if($cmp['CMP_STATUS']=='SOCIAL') {
                    echo '<td style="color: #38B9C2; font-weight: bolder">'.$cmp['CMP_STATUS'].'</td>';
                }
                else {
                    echo '<td style="color: #4CB848; font-weight: bolder">'.$cmp['CMP_STATUS'].'</td>';
                }
                if($cmp['body'] === NULL) { echo "<td>Social Campaign !</td>";} else  echo '<td>'.$cmp['body'].'</td>';
                if($cmp['date'] === NULL) { echo "<td>".$cmp['created_at']."</td>";} else  echo '<td>'.$cmp['date'].'</td>';
                if($cmp['S_NAME'] === NULL) { echo "<td>Social Campaign !</td>";} else  echo '<td>'.$cmp['S_NAME'].'</td>';
                echo '<td class="text-center">
                          <a href="./campreports.php?i='.$cmp["id"].'"  title="View Report" id="viewreports"  class="btn btn-success btn-sm">
                         <i class="fas fa-chart-bar" style="color:white;"></i>
                    </a>              
                        </td>
                 </tr>';
        }
        foreach($social as $cmp){
            echo '<tr id="'.$cmp['id'].'" class="campidtable">
                <td>'.$cmp['name'].'</td>
                <td>'.$cmp['type'].'</td>';
            if($cmp['CMP_STATUS']=='SENT'){
                echo '<td style="color: #4CB848; font-weight: bolder">'.$cmp['CMP_STATUS'].'</td>';
            }
            else if($cmp['CMP_STATUS']=='SOCIAL') {
                echo '<td style="color: #38B9C2; font-weight: bolder">'.$cmp['CMP_STATUS'].'</td>';
            }
            else {
                echo '<td style="color: #EB078C; font-weight: bolder">'.$cmp['CMP_STATUS'].'</td>';
            }
            echo "<td>Social Campaign !</td>";
            echo "<td>".$cmp['created_at']."</td>";;
            echo "<td>Social Campaign !</td>";
            echo '<td class="text-center">
                          <a href="./campreports.php?i='.$cmp["id"].'"  title="View Report" id="viewreports"  class="btn btn-success btn-sm">
                        <i class="fas fa-chart-bar" style="color:white;"></i>
                    </a>              
                        </td>
                 </tr>';
    }
   echo '</tbody>';
    echo '<script>
            $(document).ready(function() {
                $("#senttable").dataTable().fnDestroy();
                $("#senttable").DataTable( {
                    responsive: true,
                    "pagingType": "full_numbers"
                });
            });
        </script>';
?>