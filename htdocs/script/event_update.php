<?php

require_once($_SERVER['DOCUMENT_ROOT']."/service/svc_event_manager.php");
require_once($_SERVER['DOCUMENT_ROOT']."/service/svc_activity_feed.php");
require_once($_SERVER['DOCUMENT_ROOT']."/service/svc_mailer.php");

if ($_SESSION['type']<3){
	writeLog(WARNING, "Script:EVENT_UPDATE requested without authorization, IP: ".$_SERVER['REMOTE_ADDR']);
	showErrorPage(403);
	die();
}

if (isset($_POST['create'])){
	$private = 0;
	if (isset($_POST['private'])) $private = 1;
	global $db;
	$title = mysqli_real_escape_string($db, $_POST['title']);
	$type = $_POST['type'];
	$description = mysqli_real_escape_string($db, $_POST['description']);
	$location = mysqli_real_escape_string($db, $_POST['location']);
	$datetime = $_POST['datetime'];
	$limit = $_POST['limit'];

	if (svc_addEvent($title, $datetime, $location, $type, $private, $description, $limit)){
		$when = new DateTime($datetime);

		$emailmsg = $_SESSION['name']." just added a new event on SmashClub. \r\n".
		"What: ".$title."\r\n".
		"When: ".svc_longFormatDate($when)."\r\n".
		"Where: ".$location."\r\n".
		$description."\r\n".
		"Log into SmashClub to sign up. Hope to see you there!";

		if (isset($_POST['sendemails'])) svc_emailAllActiveUsers("New Event: ".$title, $emailmsg);
		svc_addActivityItem(4, $title, $description, $_SESSION['uuid']);
		sendRedirect("/events/");
	}
	else {
		showJavascriptAlert("Event creation failed (500). See the logs for more information.");
		showErrorPage(500);
	}
}

elseif (isset($_POST['update'])){
	$private = 0;
	if (isset($_POST['private'])) $private = 1;
	global $db;
	$title = mysqli_real_escape_string($db, $_POST['title']);
	$type = $_POST['type'];
	$description = mysqli_real_escape_string($db, $_POST['description']);
	$location = mysqli_real_escape_string($db, $_POST['location']);
	$datetime = $_POST['datetime'];
	$eid = $_POST['eid'];
	$limit = $POST['limit'];

	if (svc_updateEvent($eid, $title, $datetime, $location, $private, $description, $limit)){
		$when = new DateTime($datetime);

		$emailmsg = $_SESSION['name']." changed details for the event ".$title.": "."\r\n".
		"When: ".svc_longFormatDate($when)."\r\n".
		"Where: ".$location."\r\n".
		"Log into SmashClub to sign up or contact the organizer. Hope to see you there!";

		svc_emailAllActiveUsers("Event Update: ".$title, $emailmsg);
		svc_addActivityItem(9, $title, $description, $_SESSION['uuid']);
		sendRedirect("/events/");
	}
	else {
		showJavascriptAlert("Event operation failed (500). See the logs for more information.");
		showErrorPage(500);
	}
}

elseif (isset($_POST['delete'])){
	writeLog(DEBUG, "Called deleteEvent");
	if (svc_removeEvent($_POST['event-id'])){
		showJavascriptAlert("Event deleted successfully.");
		sendRedirect("/forms/event_manage.php");
	} else {
		showJavascriptAlert("Event operation failed (500). See the logs for more information.");
		showErrorPage(500);
	}
}

else {
	showErrorPage(400);
}

?>