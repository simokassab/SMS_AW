<?php
    include_once ('db_connect.php');

    class visitors {

        function insert($ip, $camp_id, $token_id){
            $mysqli = getConnected();
            $query = "INSERT INTO visitors VALUES (NULL, '$ip', $camp_id, '$token_id', NOW(), 1)";
           // echo $query;
            $mysqli->query($query);
            return $mysqli->insert_id;
        }

        function updateStatus($id, $status){
            $mysqli = getConnected();
            $sql = ' UPDATE campaigns SET status="'.$status.'" WHERE id='.$id;
            if (mysqli_query($mysqli, $sql)) {
                return true;
            } else {
                return "Error updating record: " . mysqli_error($mysqli);
            }
        }

        function getAll(){
            $mysqli = getConnected();
            $sql = "Select * FROM campaigns where active=1";
            // echo $sql;
            $Rslt = mysqli_query($mysqli,$sql);
            if($Rslt) {
                $rows=mysqli_fetch_all($Rslt,MYSQLI_ASSOC);
                return $rows;
            }
            else {
                return "";
            }
        }

        function getVisitors ($user_id){
            $mysqli = getConnected();
            $sql = "SELECT count(visitors.id) as Visitors, DATE(visitors.date) as date_ FROM visitors, campaigns where campaigns.US_ID_FK=$user_id 
                  and campaigns.active=1 and visitors.date > ( CURDATE() - INTERVAL 15 DAY ) and visitors.CAMP_ID_FK=campaigns.id group by date_";
          //  echo $sql;
            $Rslt = mysqli_query($mysqli,$sql);
            if($Rslt) {
                $rows=mysqli_fetch_all($Rslt,MYSQLI_ASSOC);
                return $rows;
            }
            else {
                return "";
            }
        }
        function getVisitorsByCamp ($user_id, $camp_id){
            $mysqli = getConnected();
            $sql = "SELECT count(visitors.id) as Visitors, DATE(visitors.date) as date_ FROM visitors, campaigns where campaigns.US_ID_FK=$user_id 
                  and campaigns.active=1 and campaigns.id=$camp_id  and visitors.date > ( CURDATE() - INTERVAL 15 DAY ) and visitors.CAMP_ID_FK=campaigns.id group by date_";
            //  echo $sql;
            $Rslt = mysqli_query($mysqli,$sql);
            if($Rslt) {
                $rows=mysqli_fetch_all($Rslt,MYSQLI_ASSOC);
                return $rows;
            }
            else {
                return "";
            }
        }

        function getVisitorsByCampSendType ($user_id, $camp_id, $tokenid){
            $mysqli = getConnected();
            $sql = "SELECT count(visitors.id) as Visitors, DATE(visitors.date) as date_ FROM visitors, campaigns where campaigns.US_ID_FK=$user_id 
                  and campaigns.active=1 and campaigns.id=$camp_id and visitors.TOKEN_ID_FK='$tokenid'  and visitors.date > ( CURDATE() - INTERVAL 15 DAY ) and visitors.CAMP_ID_FK=campaigns.id group by date_";
            //  echo $sql;
            $Rslt = mysqli_query($mysqli,$sql);
            if($Rslt) {
                $rows=mysqli_fetch_all($Rslt,MYSQLI_ASSOC);
                return $rows;
            }
            else {
                return "";
            }
        }

        function getVisitorsPerHour ($user_id){
            $mysqli = getConnected();
            $sql1 = "select HOUR(visitors.date) as Hours , count(visitors.id) as visitor from visitors, campaigns WHERE campaigns.active=1 and campaigns.US_ID_FK=$user_id
                    and campaigns.id=visitors.CAMP_ID_FK and DATE(visitors.date)=CURRENT_DATE group by Hours";
            //echo $sql1;
            //  echo $sql;
            $Rslt1 = mysqli_query($mysqli,$sql1);
            if($Rslt1) {
                $rows1=mysqli_fetch_all($Rslt1,MYSQLI_ASSOC);
                return $rows1;
            }
            else {
                return "";
            }
        }

        function getVisitorsPerHourByCamp ($user_id, $camp_id){
            $mysqli = getConnected();
            $sql1 = "select HOUR(visitors.date) as Hours , count(visitors.id) as visitor from visitors, campaigns WHERE campaigns.active=1 and campaigns.id=$camp_id and campaigns.US_ID_FK=$user_id
                    and campaigns.id=visitors.CAMP_ID_FK and DATE(visitors.date)=CURRENT_DATE group by Hours";
            //echo $sql1;
            //  echo $sql;
            $Rslt1 = mysqli_query($mysqli,$sql1);
            if($Rslt1) {
                $rows1=mysqli_fetch_all($Rslt1,MYSQLI_ASSOC);
                return $rows1;
            }
            else {
                return "";
            }
        }

        function getVisitorsPerHourByCampSendtype ($user_id, $camp_id, $tokenid){
            $mysqli = getConnected();
            $sql1 = "select HOUR(visitors.date) as Hours , count(visitors.id) as visitor from visitors, campaigns WHERE campaigns.active=1 and campaigns.id=$camp_id and campaigns.US_ID_FK=$user_id
                    and visitors.TOKEN_ID_FK='$tokenid'  and campaigns.id=visitors.CAMP_ID_FK and DATE(visitors.date)=CURRENT_DATE group by Hours";
            //echo $sql1;
            //  echo $sql;
            $Rslt1 = mysqli_query($mysqli,$sql1);
            if($Rslt1) {
                $rows1=mysqli_fetch_all($Rslt1,MYSQLI_ASSOC);
                return $rows1;
            }
            else {
                return "";
            }
        }

        function getVisitorsLive ($user_id){
            $mysqli = getConnected();
            $sql1 = "select visitors.date as Hours , count(visitors.id) as visitor from visitors, campaigns WHERE campaigns.active=1 and campaigns.US_ID_FK=$user_id and campaigns.id=visitors.CAMP_ID_FK 
                      and DATE(visitors.date)=CURRENT_DATE group by Hours";
            // echo $sql;
            //  echo $sql;
            $Rslt1 = mysqli_query($mysqli,$sql1);
            if($Rslt1) {
                $rows1=mysqli_fetch_all($Rslt1,MYSQLI_ASSOC);
                return $rows1;
            }
            else {
                return "";
            }
        }

        function getVisitorsPerday ($user_id){
            $mysqli = getConnected();
            $sql1 = "SELECT count(campaigns.id) as nb, DATE(visitors.date) as date_ FROM visitors, campaigns 
                    where DATE(visitors.date)=CURDATE() and campaigns.active=1 and campaigns.US_ID_FK=$user_id and campaigns.id=visitors.CAMP_ID_FK";
            // echo $sql;
            //  echo $sql;
            $Rslt1 = mysqli_query($mysqli,$sql1);
            if($Rslt1) {
                $rows1=mysqli_fetch_all($Rslt1,MYSQLI_ASSOC);
                return $rows1;
            }
            else {
                return "";
            }
        }

        function getVisitorsPerdayByCamp ($user_id, $camp_id){
            $mysqli = getConnected();
            $sql1 = "SELECT count(campaigns.id) as nb, DATE(visitors.date) as date_ FROM visitors, campaigns 
                    where DATE(visitors.date)=CURDATE() and campaigns.active=1 and campaigns.id=$camp_id and campaigns.US_ID_FK=$user_id and campaigns.id=visitors.CAMP_ID_FK";
            // echo $sql;
            //  echo $sql;
            $Rslt1 = mysqli_query($mysqli,$sql1);
            if($Rslt1) {
                $rows1=mysqli_fetch_all($Rslt1,MYSQLI_ASSOC);
                return $rows1;
            }
            else {
                return "";
            }
        }

        function getVisitorsPerdayByCampSendtype ($user_id, $camp_id, $tokenid){
            $mysqli = getConnected();
            $sql1 = "SELECT count(campaigns.id) as nb, DATE(visitors.date) as date_ FROM visitors, campaigns 
                    where DATE(visitors.date)=CURDATE() and campaigns.active=1 and campaigns.id=$camp_id and visitors.TOKEN_ID_FK='$tokenid' and campaigns.US_ID_FK=$user_id and campaigns.id=visitors.CAMP_ID_FK";
            // echo $sql1;
            //  echo $sql;
            $Rslt1 = mysqli_query($mysqli,$sql1);
            if($Rslt1) {
                $rows1=mysqli_fetch_all($Rslt1,MYSQLI_ASSOC);
                return $rows1;
            }
            else {
                return "";
            }
        }



        
    }

?>