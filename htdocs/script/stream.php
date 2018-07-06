<?php

require_once($_SERVER['DOCUMENT_ROOT']."/service/svc_site_settings.php");

if (!isset($_SERVER['HTTP_REFERER']) or strpos($_SERVER['HTTP_REFERER'], "/adminpanel")==false){
	writeLog(WARNING, "Script:STREAM loaded without expected referral, IP: ".$_SERVER['REMOTE_ADDR']);
	showErrorPage(400);
	die();
}

if ($_GET['live']==1){
	svc_putSetting("TwitchOnAir", 1);
	sendRedirect("/stream");
	die();
} elseif ($_GET['live']==0) {
	svc_putSetting("TwitchOnAir", 0);
	sendRedirect("/adminpanel");
	die();
} else {
	showErrorPage(400);
	die();
}

?>