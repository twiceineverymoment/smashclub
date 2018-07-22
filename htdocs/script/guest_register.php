<?php
require_once($_SERVER['DOCUMENT_ROOT']."/service/app_properties.php");
$userid = $_SESSION['uuid'];
$eventid = $_POST['event-id'];
require_once($_SERVER['DOCUMENT_ROOT']."/service/svc_event_manager.php");
require_once($_SERVER['DOCUMENT_ROOT']."/service/svc_authentication.php");

if (isset($_POST['guest-submit'])){
	$event_id = $_POST['event-id'];
	$first = $_POST['guest-firstname'];
	$last = $_POST['guest-lastname'];
	$username = $_POST['guest-username'];
	$email = $_POST['guest-email'];
	$phone = $_POST['guest-phone'];

	if (svc_userIDTaken($username)){
		showJavascriptAlert("Sorry, that username is already taken. If you have been a guest in the past, please create an account rather than register as a guest a second time.");
		sendBack();
		die();
	}

	if (svc_emailTaken($email)){
		showJavascriptAlert("An account with that email address already exists. You cannot sign up as a guest more than once. Please activate your account to sign up, or contact the club organizer.");
		sendBack();
		die();
	}

	if (svc_createGuestAndSignUp($event_id, $username, $first, $last, $email, $phone)){
		showJavascriptAlert("You have successfully signed up as a guest. Please contact the organizer to change or cancel your RSVP.");
		sendRedirect("/events");
		die();
	} else {
		showErrorPage(500);
		die();
	}
}
else {
	writeLog(WARNING, "Script:GUEST_REGISTER loaded without proper context, IP: ".$_SERVER['REMOTE_ADDR']);
	showErrorPage(400);
}

?>