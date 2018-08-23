<?php

require_once($_SERVER['DOCUMENT_ROOT']."/service/app_properties.php");

function svc_getUnreadMessageCount($uuid){
	global $db;
	$query = "SELECT COUNT(message_id) AS unread FROM user_messaging WHERE to_uuid = '$uuid' AND message_read = '0'";
	$rs = mysqli_query($db, $query);
	return mysqli_fetch_assoc($rs)['unread'];
}

function svc_getInboxByUser($uuid){
	global $db;
	$query = "SELECT * FROM user_messaging WHERE to_uuid = '$uuid' ORDER BY message_sent DESC";

	if ($rs = mysqli_query($db, $query)){
		return $rs;
	} else {
		writeLog(SEVERE, "Failed to load inbox");
		writeLog(SEVERE, mysqli_error($db));
		return false;
	}
}

/*
Send a notification to a user's inbox. Notifications only display the body.
$uuid - Recipient
$subject - Message subject
$body - Message body
*/
function svc_sendSingleNotification($uuid, $subject, $body){
	global $db;
	$query = "INSERT INTO user_messaging 
	(from_uuid, to_uuid, message_subject, message_body, message_sent) 
	VALUES ('0', '$uuid', '$subject', '$body', getdate())";

	if (mysqli_query($db, $query)){
		return true;
	} else {
		writeLog(ERROR, "Failed to send notification");
		writeLog(ERROR, $query);
		writeLog(ERROR, mysqli_error($db));
		return false;
	}
}

function svc_sendMassNotification($subject, $body){

}



?>