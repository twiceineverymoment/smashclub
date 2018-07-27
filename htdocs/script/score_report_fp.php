<?php

require_once($_SERVER['DOCUMENT_ROOT']."/service/svc_score_report.php");

if ($_SESSION['type']<2){
	writeLog(ALERT, "Script:SCORE_REPORT_FP requested by unauthorized user, IP: ".$_SERVER['REMOTE_ADDR']);
	showErrorPage(403);
	die();
}

if (isset($_POST['confirm'])){
	if (isset($_POST['doubles'])){
		if (svc_reportDoublesScore($_POST['player1a'], $_POST['player1b'], $_POST['score1'], $_POST['player2a'], $_POST['player2b'], $_POST['score2'])){
			showJavascriptAlert("This match was logged successfully. Ranks have been adjusted.");
			sendRedirect("/scoring/");
			die();
		} else {
			showJavascriptAlert("Whoops! The system encountered an internal error. Check the logs for more info. This match was NOT logged.");
			showErrorPage(500);
			die();
		}
	} else {

		if (svc_reportSinglesScore($_POST['player1a'], $_POST['score1'], $_POST['player2a'], $_POST['score2'])){
			svc_logMatchResults(0, $_POST['player1a'], $_POST['player2a'], $_POST['score1'], $_POST['score2'], 0, 1);
			showJavascriptAlert("This match was logged successfully. Ranks have been adjusted.");
			sendRedirect("/scoring/");
			die();
		} else {
			showJavascriptAlert("Whoops! The system encountered an internal error. Check the logs for more info. This match was NOT logged.");
			showErrorPage(500);
			die();
		}
	}
} else {
	writeLog(WARNING, "Script:SCORE_REPORT_FP loaded without proper context, IP: ".$_SERVER['REMOTE_ADDR']);
	showErrorPage(400);
	die();
}

?>