<?php

require_once($_SERVER['DOCUMENT_ROOT']."/service/app_properties.php");
require_once($_SERVER['DOCUMENT_ROOT']."/service/svc_player_ranks.php");
require_once($_SERVER['DOCUMENT_ROOT']."/service/svc_activity_feed.php");
require_once($_SERVER['DOCUMENT_ROOT']."/service/svc_mailer.php");

if ($_SESSION['type']<4){
	writeLog(ALERT, "Script:END_SEASON attempted load by unauthorized user, IP: ".$_SERVER['REMOTE_ADDR']);
	showErrorPage(403);
	die();
}

if (!strpos($_SERVER['HTTP_REFERER'], "adminpanel")){
	writeLog(WARNING, "Script:END_SEASON loaded without proper HTTP referral, IP: ".$_SERVER['REMOTE_ADDR']);
	showErrorPage(400);
	die();
}

if (svc_endCurrentSeason()){
	showJavascriptAlert("The current season has ended. The club will now enter off-season mode.");
	svc_addActivityItem(7, "", null, null);
	svc_emailAllActiveUsers("The Current Season Has Ended", "The current SmashClub season has ended. Your rating for this season has been saved to the Hall of Records. The club is now in the off-season. We hope to see you again soon!");
	sendRedirect("/");
} else {
	showJavascriptAlert("There was an unknown error performing this action. Please check the logs for details.");
	showErrorPage(500);
}

?>