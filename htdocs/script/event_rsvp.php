<?php
require_once($_SERVER['DOCUMENT_ROOT']."/service/app_properties.php");
$userid = $_SESSION['uuid'];
$eventid = $_POST['event-id'];
require_once($_SERVER['DOCUMENT_ROOT']."/service/svc_event_manager.php");

if (isset($_POST['member-rsvp'])){
	if (svc_addSignup($userid, $eventid)){
		writeLog(INFO, "User ".$_SESSION['name']." signed up for event with id ".$eventid);
		echo "<meta http-equiv='REFRESH' content='0 url=/events/' />";
	}
	else {
		writeLog(SEVERE, "Event Member RSVP failed.");
		showErrorPage(500);
	}
}
elseif (isset($_POST['cancel'])){
	if (svc_deleteSignup($userid, $eventid)){
		writeLog(INFO, "User ".$_SESSION['name']." cancelled signup for event with id ".$eventid);
		echo "<meta http-equiv='REFRESH' content='0 url=/events/' />";
	}
	else {
		writeLog(SEVERE, "Event Member RSVP failed.");
		showErrorPage(500);
	}
}
elseif (isset($_POST['guest-rsvp'])){
	echo "<meta http-equiv='REFRESH' content='0 url=/events/guestrsvp/?eid=".$eventid."' />";
}
elseif (isset($_POST['guest-confirm'])){
	if (svc_addGuestSignup($eventid, $_POST['rsvp-name'], $_POST['rsvp-contact'])){
		writeLog(INFO, "Guest signed up for event with id ".$eventid." using name ".$_POST['rsvp-name']);
		echo "<script type='text/javascript'>alert('You have successfully signed up! You will now be taken back to the events page.');</script>";
		echo "<meta http-equiv='REFRESH' content='0 url=/events/' />";
	}
	else {
		writeLog(ERROR, "Event Guest RSVP failed.");
		showErrorPage(500);
	}
}
else {
	writeLog(WARNING, "Script:EVENT_RSVP loaded without proper context, IP: ".$_SERVER['REMOTE_ADDR']);
	showErrorPage(400);
}

?>