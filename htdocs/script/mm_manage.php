<?php

require_once($_SERVER['DOCUMENT_ROOT']."/service/svc_site_settings.php");
require_once($_SERVER['DOCUMENT_ROOT']."/service/svc_match_manager.php");


if (!isset($_GET['action'])){
	writeLog(WARNING, "Script:MM_MANAGE loaded without proper parameters, IP: ".$_SERVER['REMOTE_ADDR']);
	showErrorPage(400);
	die();
}

if ($_SESSION['type']<3){
	writeLog(ALERT, "Script:MM_MANAGE requested by unauthorized user, IP: ".$_SERVER['REMOTE_ADDR']);
	showErrorPage(403);
	die();
}

if ($_GET['action']=="stop"){
	svc_clearQueue();
	svc_putSetting("TourneyStatus", 0);
	sendRedirect("/adminpanel");
}

elseif ($_GET['action']=="start"){
	if (!isset($_GET['eid']) or !isset($_GET['mode'])){
		writeLog(WARNING, "Script:MM_MANAGE loaded without proper parameters, IP: ".$_SERVER['REMOTE_ADDR']);
		showErrorPage(400);
		die();
	}
	if ($_GET['mode']==1 and svc_getSetting("CurrentSeasonNumber")==0){
		showJavascriptAlert("You cannot play competitively during the off-season. Please select Casual mode or choose a different event.");
		sendBack();
	}
	svc_startEventPlay($_GET['eid'], $_GET['mode']);
	sendRedirect("/adminpanel");
}

elseif ($_GET['action']=="close"){
	if (svc_closeMatch($_GET['mid'])){
		sendBack();
	} else {
		showErrorPage(500);
	}
}

elseif ($_GET['action']=="pause"){
	svc_putSetting("MatchMakingQueueFreeze", 1);
	sendBack();
}

elseif ($_GET['action']=="resume"){
	svc_putSetting("MatchMakingQueueFreeze", 0);
	sendBack();
}

?>