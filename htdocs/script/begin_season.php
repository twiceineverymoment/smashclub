<?php

require_once($_SERVER['DOCUMENT_ROOT']."/service/app_properties.php");
require_once($_SERVER['DOCUMENT_ROOT']."/service/svc_player_ranks.php");
require_once($_SERVER['DOCUMENT_ROOT']."/service/svc_activity_feed.php");
require_once($_SERVER['DOCUMENT_ROOT']."/service/svc_mailer.php");

if ($_SESSION['type']<4){
	writeLog(ALERT, "Script:BEGIN_SEASON attempted access by unauthorized user, IP: ".$_SERVER['REMOTE_ADDR']);
	showErrorPage(403);
	die();
}

if (isset($_POST['create'])){
	global $db;
	$title = mysqli_real_escape_string($db, $_POST['season-title']);
	$game = $_POST['season-game'];
	$method = $_POST['seed-method'];
	$placements = $_POST['placements'];
	if (svc_startSeason($title, $game, $method, $placements)){
		svc_addActivityItem(7, $title, null, null);
		svc_emailAllActiveUsers("A New Season Has Started: ".$title, "A new season has begun! Your ranking will be reset. Complete placement matches at ranked events to earn your new rating.");
		showJavascriptAlert("A new season has begun! Members will appear on the Rankings page once they have completed placement.");
		sendRedirect("/leaderboard/");
	} else {
		showJavascriptAlert("There was an internal error processing this request. Please check the site logs for details.");
		showErrorPage(500);
	}
} else {
	writeLog(WARNING, "Script:BEGIN_SEASON loaded with no POST variables, IP: ".$_SERVER['REMOTE_ADDR']);
	showErrorPage(400);
}

?>