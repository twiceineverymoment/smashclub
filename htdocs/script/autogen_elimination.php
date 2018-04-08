<?php

require_once($_SERVER['DOCUMENT_ROOT']."/service/app_properties.php");
require_once($_SERVER['DOCUMENT_ROOT']."/service/svc_site_settings.php");
require_once($_SERVER['DOCUMENT_ROOT']."/service/svc_tourney_manager.php");

if ($_SESSION['type']<3){
	writeLog(ALERT, "Script:AUTOGEN_ELIMINATION requested by unauthorized user, IP: ".$_SERVER['REMOTE_ADDR']);
	showErrorPage(403);
	die();
}

$event_id = svc_getSetting("MatchMakingEvent");
$doubleElim = svc_getSetting("TourneyBracketStyle");
$order = $_GET['order'];

if ($doubleElim > 1) {
	showJavascriptAlert("You cannot use this script on round-robin or swiss tournaments.");
	showErrorPage(400);
	die();
}

$result = svc_makeEliminationBracket($event_id, $doubleElim, $order);
if ($result === true){
	svc_putSetting("TourneyStatus", 1);
	svc_setSignupLock(svc_getSetting("MatchMakingEvent"), true); //Lock the event signup
	sendRedirect("/tourney/");
	die();
} else {
	showJavascriptAlert("The bracket builder encountered an error. ".$result);
	sendRedirect("/");
}

?>