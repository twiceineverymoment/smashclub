<?php

require_once($_SERVER['DOCUMENT_ROOT']."/service/app_properties.php");

function svc_getActivityItems($count){
	global $db;
	$query = "SELECT * FROM activity_feed ORDER BY activity_time DESC LIMIT $count";
	return mysqli_query($db, $query);
}

function svc_getLatestAnnouncement(){
	global $db;
	$query = "SELECT * FROM activity_feed WHERE activity_type=0 ORDER BY activity_time DESC";
	return mysqli_fetch_assoc(mysqli_query($db, $query));
}

function svc_shortFormatDate($date){
	return date_format($date, "m/d/y h:i a");
}

function svc_getMemberNameByID($uuid){
	global $db;
	$query = "SELECT user_username FROM user_authentication WHERE uuid='$uuid'";
	$rs = mysqli_query($db, $query);
	return mysqli_fetch_assoc($rs)['user_username'];
}

function svc_addActivityItem($type, $header, $body, $owner){
	if ($owner==null) $owner=0;
	global $db;
	$query = "INSERT INTO activity_feed (activity_type, activity_header_html, activity_body_html, activity_owner_uuid, activity_time)
	VALUES ('$type', '$header', '$body', '$owner', NOW())";

	$typearray = array("ANNOUNCEMENT", "RESULTS_FREEPLAY", "RESULTS_TOURNAMENT", "TOURNAMENT_ACTION",
		"NEW_EVENT", "USER_RANK", "NEW_USER", "SEASON_ACTION", "POLL_ACTION", "EVENT_UPDATE");

	if (mysqli_query($db, $query)){
		writeLog(INFO, "Posted to activity feed with type: ".$typearray[$type]);
		return true;
	}
	else {
		writeLog(SEVERE, "Failed to post to activity feed with type: ".$typearray[$type]);
		writeLog(SEVERE, "Query: ".$query);
		writeLog(SEVERE, "MySQL Error: ".mysqli_error($db));
		return false;
	}
}

?>