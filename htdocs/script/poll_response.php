<?php
require_once($_SERVER['DOCUMENT_ROOT']."/service/svc_polling.php");

if (!isset($_POST['respsubmit']) or $_SESSION['type']==0){
	writeLog(WARNING, "Script:POLL_RESPONSE loaded without proper context, IP: ".$_SERVER['REMOTE_ADDR']);
	showErrorPage(401);
	die();
}

if (isset($_POST['resptext'])){
	if (svc_addTextPollResponse($_SESSION['uuid'], $_POST['resptext'])){
		sendRedirect("/poll/");
	} else {
		showErrorPage(500);
	}
}

elseif (isset($_POST['respchoice'])){
	if (svc_addMCPollResponse($_SESSION['uuid'], $_POST['respchoice'])){
		sendRedirect("/poll/");
	} else {
		showErrorPage(500);
	}
}

?>