<?php
require_once($_SERVER['DOCUMENT_ROOT']."/service/svc_polling.php");
require_once($_SERVER['DOCUMENT_ROOT']."/service/svc_activity_feed.php");
require_once($_SERVER['DOCUMENT_ROOT']."/service/svc_mailer.php");

if (!isset($_POST['create']) and !isset($_GET['close'])){
	writeLog(WARNING, "Script:POLL_UPDATE loaded without proper context, IP: ".$_SERVER['REMOTE_ADDR']);
	showErrorPage(400);
	die();
}

if ($_SESSION['type']<3){
	writeLog(ALERT, "Script:POLL_UPDATE requested by unauthorized user, IP: ".$_SERVER['REMOTE_ADDR']);
	showErrorPage(403);
}

global $db;
$question = mysqli_real_escape_string($db, $_POST['question']);

if (isset($_POST['create'])){
	if ($_POST['type']==1){
		if (svc_createNewPoll($_POST['question'], POLL_MULTICHOICE, $_POST['choices'])){
			svc_addActivityItem(8, $_POST['question'], null, null);
			$mailmsg = "A new poll has been created. Login to your SmashClub account to respond to it! \r\n".$_POST['question'];
			svc_emailAllActiveUsers("New Poll Available", $mailmsg);
			sendRedirect("/poll/");
		} else {
			showErrorPage(500);
			die();
		}
	}
	elseif ($_POST['type']==2){
		if (svc_createNewPoll($_POST['question'], POLL_TEXT, null)){
			svc_addActivityItem(8, $_POST['question'], null, null);
			$mailmsg = "A new poll has been created. Login to your SmashClub account to respond to it! \r\n".$_POST['question'];
			svc_emailAllActiveUsers("New Poll Available", $mailmsg);
			sendRedirect("/poll/");
		} else {
			showErrorPage(500);
			die();
		}
	} else {
		showErrorPage(400);
		die();
	}
}

elseif (isset($_GET['close'])){
	if (svc_closePoll()){
		showJavascriptAlert("The current poll has been closed.");
		svc_addActivityItem(8, "", null, null);
		sendRedirect("/adminpanel/");
	} else {
		showErrorPage(500);
	}
}

else {
	writeLog(WARNING, "Script:POLL_UPDATE loaded without proper context, IP: ".$_SERVER['REMOTE_ADDR']);
	showErrorPage(400);
	die();
}

?>