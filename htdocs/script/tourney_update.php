<?php

require_once($_SERVER['DOCUMENT_ROOT']."/service/app_properties.php");
require_once($_SERVER['DOCUMENT_ROOT']."/service/svc_site_settings.php");
require_once($_SERVER['DOCUMENT_ROOT']."/service/svc_tourney_manager.php");

if ($_SESSION['type']<3){
	writeLog(ALERT, "Script:TOURNEY_UPDATE requested by unauthorized user, IP: ".$_SERVER['REMOTE_ADDR']);
	showErrorPage(403);
	die();
}

if ($_GET['action']=="start"){
	global $db;
	$rules = mysqli_real_escape_string($db, $_POST['rules']);
	svc_putSetting("TourneyStatus", 2);
	svc_putSetting("CompMatchRules", $rules);
	svc_putSetting("EventIsRanked", $_POST['ranked']);
	svc_putSetting("TourneyBracketStyle", $_POST['bracket']);
	svc_putSetting("MatchMakingEvent", $_POST['event']);
	sendRedirect("/adminpanel/");
}

elseif ($_GET['action']=="close"){
	svc_putSetting("TourneyStatus", 0);
	svc_setSignupLock(svc_getSetting("MatchMakingEvent"), false); //Unlock the event signup
	sendRedirect("/adminpanel/");
}

 elseif ($_GET['action']=="refresh"){
 	svc_refreshMatchStatuses();
 	sendRedirect("/tourney/");
 }

 elseif ($_GET['action']=="opentmm"){
 	$status = svc_getSetting("TourneyStatus");
 	if ($status==1){
 		svc_putSetting("TourneyStatus", 4);
 	}
 	sendRedirect("/");
 }

 //TODO action "build" for generation algorithm

?>