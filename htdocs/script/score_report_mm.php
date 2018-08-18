<?php

require_once($_SERVER['DOCUMENT_ROOT']."/service/svc_score_report.php");
require_once($_SERVER['DOCUMENT_ROOT']."/service/svc_match_manager.php");
require_once($_SERVER['DOCUMENT_ROOT']."/service/svc_authentication.php");

if ($_SESSION['type']<2){
	writeLog(ALERT, "Script:SCORE_REPORT_MM requested by unauthorized user, IP: ".$_SERVER['REMOTE_ADDR']);
	showErrorPage(403);
	die();
}

if (!isset($_POST['submit'])){
	writeLog(WARNING, "Script:SCORE_REPORT_MM loaded without proper context, IP: ".$_SERVER['REMOTE_ADDR']);
	showErrorPage(400);
	die();
}

if (svc_closeMatch($_POST['match_id'])){
	$ranked = svc_getSetting("EventIsRanked");
	svc_logMatchResults($event, $_POST['uuid1'], $_POST['uuid2'], $_POST['score1'], $_POST['score2'], 0, $ranked);
	if ($ranked==1){
		if (svc_reportSinglesScore($_POST['uuid1'], $_POST['score1'], $_POST['uuid2'], $_POST['score2'])){
			$event = svc_getSetting("MatchMakingEvent");
			sendRedirect("/scoring");
		} else {
			showErrorPage(500);
		}
	} else { //Post to activity feed without reporting score to rank
		$infotext = svc_getUsernameByID($_POST['uuid1'])." <h2 style=\'display: inline-block\'>".$_POST['score1']."-".$_POST['score2']."</h2> ".svc_getUsernameByID($_POST['uuid2']);
		svc_addActivityItem(1, null, $infotext, $_SESSION['uuid']);
		sendRedirect("/scoring");
	}
} else {
	showErrorPage(500);
}

?>