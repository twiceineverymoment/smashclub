<?php

require_once($_SERVER['DOCUMENT_ROOT']."/service/app_properties.php");

function svc_getUnreadMessageCount($uuid){
	global $db;
	$query = "SELECT COUNT(message_id) AS unread FROM user_messaging WHERE to_uuid = '$uuid' AND message_read = '0'";
	$rs = mysqli_query($db, $query);
	return mysqli_fetch_assoc($rs)['unread'];
}

function svc_getInboxByUser($uuid){

}

function svc_sendSingleNotification($uuid, $subject, $body){

}

function svc_sendMassNotification($subject, $body){

}



?>