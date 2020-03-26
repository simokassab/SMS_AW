<?php
ob_start();
session_start();
include_once ('../classes/land_page.php');
include_once ('../classes/campaigns.php');
include_once ('../classes/links.php');

$links=new links();
$camp= new campaigns();
$land = new land_page();
$mysqli = getConnected();
$name=$_POST['shortlink'];
$htmlcode='<script   src="https://code.jquery.com/jquery-3.3.1.js"   integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60="   crossorigin="anonymous"></script>
            <script>
            var getUrlParameter = function getUrlParameter(sParam) {
                var sPageURL = window.location.search.substring(1),
                    sURLVariables = sPageURL.split("&"),
                    sParameterName,
                    i;
                if(sPageURL==""){
                    return "null";
                }
                for (i = 0; i < sURLVariables.length; i++) {
                    sParameterName = sURLVariables[i].split("=");
        
                    if (sParameterName[0] === sParam) {
                        return sParameterName[1] === null ? true : decodeURIComponent(sParameterName[1]);
                    }
                }
            };
            $(document).ready(function (e) {
                
                var tokenid=getUrlParameter("t");
                //alert(tokenid);
                $("#tokenid").val(tokenid);
        
            });
        </script>
           <script   src="landingpage.js"  crossorigin="anonymous"></script>
                 <meta charset="utf-8"><meta http-equiv="X-UA-Compatible" content="IE=edge"><meta name="viewport" content="width=device-width, initial-scale=1">';

$htmlfile='<script   src="https://code.jquery.com/jquery-3.3.1.js"   integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60="   crossorigin="anonymous"></script>
            <script>
            var getUrlParameter = function getUrlParameter(sParam) {
                var sPageURL = window.location.search.substring(1),
                    sURLVariables = sPageURL.split("&"),
                    sParameterName,
                    i;
                if(sPageURL==""){
                    return "null";
                }
                for (i = 0; i < sURLVariables.length; i++) {
                    sParameterName = sURLVariables[i].split("=");
        
                    if (sParameterName[0] === sParam) {
                        return sParameterName[1] === null ? true : decodeURIComponent(sParameterName[1]);
                    }
                }
            };
            $(document).ready(function (e) {
                var tokenid=getUrlParameter("t");
                //alert(tokenid);
                $("#tokenid").val(tokenid);
        
            });
        </script>
           <script   src="landingpage.js"   crossorigin="anonymous"></script>
                 <meta charset="utf-8"><meta http-equiv="X-UA-Compatible" content="IE=edge"><meta name="viewport" content="width=device-width, initial-scale=1">';
$htmlfile.="<style>".$_POST['gjs-css']."</style>".$_POST['gjs-html']."<input type='hidden' id='filename' value='".$name."'><input type='hidden' id='tokenid' >";
$htmlfile.='<script   src="youtube.js"  crossorigin="anonymous"></script>';
$htmlcode.='<style>'.mysqli_real_escape_string($mysqli, $_POST['gjs-css'])."</style>".mysqli_real_escape_string($mysqli, $_POST['gjs-html']).'<input type="hidden" id="filename" value="'.$name.'"><input type="hidden" id="tokenid" >';
$htmlcode.='<script   src="youtube.js"  crossorigin="anonymous"></script>';
$parameters= $links->parByShortLink($name);
$par = explode("&", $parameters);
$par1=explode("=", $par[0]);
$campid=$par1[1]; //camp id
$campaign = $camp->getRowByID($campid);
$camptype= $campaign[2];
$par2=explode("=", $par[1]);
$landid=$par2[1]; //landing page id
$expiry_date='2019-01-20';
$published=1;

$htmlfile = str_replace('<video', '<iframe', $htmlfile);
$htmlfile = str_replace('video>', 'iframe>', $htmlfile);

$land-> update($name, '', $_SERVER['SERVER_NAME'].'/SMS/c/'.$name.'.php', $expiry_date, $published, $landid);

$myfile = fopen("../c/".$name.'.php', "w") or die("Unable to open file!");
echo $name;
fwrite($myfile, $htmlfile);
fclose($myfile);


?>

