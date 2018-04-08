<?php

require_once($_SERVER['DOCUMENT_ROOT']."/service/app_properties.php");
require_once($_SERVER['DOCUMENT_ROOT']."/service/svc_site_settings.php");

function svc_getPollChoices(){
	global $db;
	$query = "SELECT setting_value FROM site_settings WHERE setting_key = 'PollResponses'";

	$result = mysqli_query($db, $query);

	if (!$result){
		writeLog(SEVERE, "getPollChoices FAILED");
		writeLog(SEVERE, "MySQL Error: ".mysqli_error($db));
		return false;
	}
	else {
		$arr = mysqli_fetch_assoc($result);
		return explode("|", $arr['setting_value']);
	}
}

function svc_userAlreadyResponded($uuid){
	global $db;
	$query = "SELECT response_uuid FROM poll_response WHERE response_uuid = '$uuid'";
	if (mysqli_num_rows(mysqli_query($db, $query))>0){
		return true;
	} else {
		return false;
	}
}

function svc_addMCPollResponse($uuid, $choiceno){
	global $db;
	$query = "INSERT INTO poll_response (response_uuid, response_choice) VALUES ('$uuid', '$choiceno');";

	if (mysqli_query($db, $query)){
		writeLog(INFO, "A poll response was recorded (multiple choice).");
		return true;
	}
	else {
		writeLog(SEVERE, "A poll response failed to save!");
		writeLog(SEVERE, "MySQL Error: ".mysqli_error($db));
		return false;
	}

}

function svc_addTextPollResponse($uuid, $response){
	global $db;
	$query = "INSERT INTO poll_response (response_uuid, response_text) VALUES ('$uuid', '$response');";

	if (mysqli_query($db, $query)){
		writeLog(INFO, "A poll response was recorded (open ended).");
		return true;
	}
	else {
		writeLog(SEVERE, "A poll response failed to save!");
		writeLog(SEVERE, "MySQL Error: ".mysqli_error($db));
		return false;
	}

}

function svc_closePoll(){
	global $db;
	$query = "DELETE FROM poll_response";
	if (svc_putSetting("PollStatus", 0)){
		if (mysqli_query($db, $query)){
			writeLog(INFO, "The active poll was closed by ".$_SESSION['name']);
			return true;
		} else {
			writeLog(SEVERE, "closePoll query failed! Check SQL user ID permissions.");
			return false;
		}
	}
	return false;
}

const POLL_MULTICHOICE = 0;
const POLL_TEXT = 1;

function svc_createNewPoll($question, $type, $responses){
	global $db;
	$choices = explode("\n", $responses);
	if ($type==POLL_MULTICHOICE){
		$resp = implode("|", $choices);
		svc_putSetting("PollStatus", 1);
		svc_putSetting("PollResponses", $resp);
		svc_putSetting("PollQuestion", $question);
		writeLog(INFO, "A new multiple-choice poll was opened by ".$_SESSION['name']);
	}
	elseif ($type==POLL_TEXT){
		svc_putSetting("PollStatus", 2);
		svc_putSetting("PollQuestion", $question);
		writeLog(INFO, "A new text poll was opened by ".$_SESSION['name']);
	}
	return true;
}

function svc_getMCPollResults(){
	$choices = svc_getPollChoices();
	$results = array_fill(0, sizeof($choices), 0);
	global $db;
	$query = "SELECT response_choice FROM poll_response";
	$rs = mysqli_query($db, $query);
	while ($resp = mysqli_fetch_assoc($rs)){
		$j = $resp['response_choice'];
		$results[$j]++;
	}
	writeLog(DEBUG, "MCPollResults = ".implode(",", $results));
	return $results;
}

function svc_getTextPollResults(){
	global $db;
	$query = "SELECT response_text FROM poll_response";
	$rs = mysqli_query($db, $query);
	return $rs;
}

function svc_getTotalPollResponses(){
	global $db;
	$query = "SELECT count(*) FROM poll_response";
	return mysqli_fetch_row(mysqli_query($db, $query))[0];
}

?>