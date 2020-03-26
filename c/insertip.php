<?php
/**
 * Created by PhpStorm.
 * User: Pc
 * Date: 12/4/2018
 * Time: 4:03 PM
 */

require_once ('../classes/visitors.php');
require_once ('../classes/links.php');
include_once ('../classes/campaigns.php');
$camp= new campaigns();
$links= new links();
$visitor = new visitors();
$shortlink=$_POST['pagename'];
$parameters= $links->parByShortLink($shortlink);
$par = explode("&", $parameters);
$par1=explode("=", $par[0]);
$campid=$par1[1]; //camp id
$campaign = $camp->getRowByID($campid);
$camptype= $campaign[2];
$par2=explode("=", $par[1]);
$landid=$par2[1]; //landing page id


echo $visitor->insert($_POST['ipaddress'], $campid, $_POST['tokenid']);

?>

