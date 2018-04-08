<?php

require_once($_SERVER['DOCUMENT_ROOT']."/service/app_properties.php");
require_once($_SERVER['DOCUMENT_ROOT']."/service/svc_site_settings.php");
require_once($_SERVER['DOCUMENT_ROOT']."/service/svc_event_manager.php");

function svc_emailSingleUser($uuid, $subject, $body){
	global $email_on;
	$email = svc_getUserEmailAddress($uuid);
	$header = svc_getFromHeader();
	$recipient = $_POST['recipient'];
	if ($email_on){
		writeLog(INFO, "Sending a Contact email to single user (ID=".$uuid.")");
	} else {
		writeLog(INFO, "Email is turned off, contents will be dumped to logs.");
		writeLog(INFO, "Contact to single user (ID=".$uuid.")");
		writeLog(INFO, "TO:".$email."/ SUBJECT:".$subject."/ BODY:".$body."/ HEADER:".$header);
		return;
	}
	//$subject = filter_var($subject, FILTER_SANITIZE_EMAIL);
	if (mail($email, $subject, $body, $header)){
		writeLog(INFO, "Sent an email to ".$email.": ".$subject);
	} else {
		writeLog(ERROR, "Email to ".$email." was rejected by the mail server.");
	}
}

function svc_emailEventGuests($event_id, $subject, $body){
	global $email_on;
	$email = svc_getSetting("GeneralMailbox");
	$recipients = svc_getEventGuestsBccHeader($event_id);
	if ($recipients==""){
		writeLog(WARNING, "Cancelled email to event guests: recipients BCC header is empty");
		return;
	}
	$headers = svc_getFromHeader();
	$headers .= "Bcc: ".$recipients."\r\n";
	if ($email_on){
		writeLog(INFO, "Sending an email to event guests (EVENT ID=".$event_id.") : ".$subject);
	} else {
		writeLog(INFO, "Email is turned off, contents will be dumped to logs.");
		writeLog(INFO, "Contact to event guests (EVENT ID=".$event_id.")");
		writeLog(INFO, "TO:".$email."/ SUBJECT:".$subject."/ BODY:".$body."/ HEADER:".$headers);
		return;
	}
	//$subject = filter_var($subject, FILTER_SANITIZE_EMAIL);
	if (mail($email, $subject, $body, $headers)){
		writeLog(INFO, "Email complete.");
	} else {
		writeLog(ERROR, "Email to all event guests was rejected by the mail server.");
	}
}

function svc_emailAllActiveUsers($subject, $body){
	global $email_on;
	$email = svc_getSetting("GeneralMailbox");
	$recipients = svc_getAllUsersBccHeader();
	if ($recipients==""){
		writeLog(WARNING, "Cancelled email to all members: recipients BCC header is empty");
		return;
	}
	$headers = svc_getFromHeader();
	$headers .= "Bcc: ".$recipients."\r\n";
	if ($email_on){
		writeLog(INFO, "Sending an email to all members: ".$subject);
	} else {
		writeLog(INFO, "Email is turned off, contents will be dumped to logs.");
		writeLog(INFO, "Contact to all members");
		writeLog(INFO, "TO:".$email."/ SUBJECT:".$subject."/ BODY:".$body."/ HEADER:".$headers);
		return;
	}
	//$subject = filter_var($subject, FILTER_SANITIZE_EMAIL);
	if (mail($email, $subject, $body, $headers)){
		writeLog(INFO, "Email complete.");
	} else {
		writeLog(ERROR, "Email to all users was rejected by the mail server.");
	}
}

function svc_getUserEmailAddress($uuid){
	global $db;
	$query = "SELECT prof_email_address FROM user_profile WHERE uuid = '$uuid'";
	$rs = mysqli_query($db, $query);
	if (mysqli_num_rows($rs)!=1) return false;
	$addr = mysqli_fetch_assoc($rs)['prof_email_address'];
	writeLog(DEBUG, "getUserEmailAddress returned ".$addr." for UUID ".$uuid);
	return $addr;
}

function svc_getEventGuestsBccHeader($event_id){
	global $db;
	$query = "SELECT p.prof_email_address FROM event_user_signup s INNER JOIN user_profile p on s.uuid = p.uuid 
	WHERE s.event_id = '$event_id' AND s.uuid IS NOT NULL";
	$result = mysqli_query($db, $query);
	$list = "";
	if (!$result){
		writeLog(SEVERE, "getEventGuestsBccHeader failed");
		writeLog(SEVERE, "MySQL Error: ".mysqli_error($db));
		return "";
	}
	while ($row = mysqli_fetch_assoc($result)){
		$list .= $row['prof_email_address'].",";
	}
	writeLog(DEBUG, "EventGusts BCC: ".$list);
	return $list;
}

function svc_getAllUsersBccHeader(){
	global $db;
	$list = "";
	$query = "SELECT prof_email_address FROM user_profile p
	INNER JOIN user_authentication a ON a.uuid = p.uuid 
	WHERE a.user_locked in (0, 1)";
	$rs = mysqli_query($db, $query);
	if (!$rs){
		writeLog(SEVERE, "getAllUsersBccHeader failed");
		writeLog(SEVERE, "MySQL Error: ".mysqli_error($db));
		return "";
	}
	while ($row = mysqli_fetch_assoc($rs)){
		$list .= $row['prof_email_address'].",";
	}
	writeLog(DEBUG, "AllActiveUsers BCC: ".$list);
	return $list;
}

function svc_getFromHeader(){
	return "From: ".svc_getSetting("OrganizationName")." <".svc_getSetting("GeneralMailbox").">\r\n";
}

/*
* PEAR is bad, m'kay? 


function svc_sendSingleEmail($uuid, $subject, $body){
	global $mqdb, $mail_options;

	$mailqueue =& new Mail_Queue($mqdb, $mail_options);

	$from = "utcsmashclub@gmail.com";
	$to = svc_getUserEmailAddress($uuid);
	$subject = filter_var($subject, FILTER_SANITIZE_EMAIL);

	$hdrs = array( 'From'    => $from,
               'To'      => $to,
               'Subject' => $subject  );

	$mime = new Mail_mime();
	$mime->setTXTBody($body);
	$msgbody = $mime->get();
	$hdrs = $mime->headers($hdrs, true);

	$mailqueue->put($from, $to, $hdrs, $msgbody);

}
*/

?>