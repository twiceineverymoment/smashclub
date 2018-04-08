<?php

require_once($_SERVER['DOCUMENT_ROOT']."/service/svc_activity_feed.php");
require_once($_SERVER['DOCUMENT_ROOT']."/service/svc_mailer.php");

if (!isset($_POST['post'])){
	writeLog(WARNING, "Script:ANNOUNCEMENT loaded with no POST variables, IP: ".$_SERVER['REMOTE_ADDR']);
	showErrorPage(400);
	die();
}

if ($_SESSION['type']<3){
	writeLog(ALERT, "Script:ANNOUNCEMENT attempted load by unauthorized user, IP: ".$_SERVER['REMOTE_ADDR']);
	showErrorPage(403);
	die();
}

global $db;
$header = mysqli_real_escape_string($db, $_POST['header']);
$body = mysqli_real_escape_string($db, $_POST['body']);

if (svc_addActivityItem(0, $header, $body, $_SESSION['uuid'])){

	$mailmsg = $_SESSION['name']." Posted a new announcement: ".$header."\r\n".$body;
	svc_emailAllActiveUsers("Announcement: ".$header, $mailmsg);
	sendRedirect("/activity/");
}
else {
	showJavascriptAlert("An error has occurred. Check the logs for more info.");
	showErrorPage(500);
	die();
}

?>