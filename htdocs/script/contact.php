<?php
require_once($_SERVER['DOCUMENT_ROOT']."/service/svc_mailer.php");
if (isset($_POST['send'])){
	$body = "New Contact From: ".$_POST['name'].", Reply To: ".$_POST['from']." \r\n ".$_POST['message'];
	if ($_POST['recipient']==0){
		$recipient = svc_getSetting("SpokespersonUUID");
		writeLog(INFO, "Sending a Contact email to the spokesperson (ID=".$recipient.")");
		svc_emailSingleUser($recipient, "New Contact", $body);
	} elseif ($_POST['recipient']==-1){
		writeLog(INFO, "Sending a contact email to all attendees of event ID ".$_POST['event']);
		svc_emailEventGuests($_POST['event'], "New Message From Event Host", $body);
	} else {
		$recipient = $_POST['recipient'];
		writeLog(INFO, "Sending a Contact email to event host (ID=".$recipient.")");
		svc_emailSingleUser($recipient, "New Message About Your Event", $body);
	}
	showJavascriptAlert("Your message was sent!");
	sendRedirect("/");
} else {
	writeLog(WARNING, "Script:CONTACT loaded with no POST variables, IP: ".$_SERVER['REMOTE_ADDR']);
	showErrorPage(400);
}

?>