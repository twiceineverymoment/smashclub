<?php

require_once($_SERVER['DOCUMENT_ROOT']."/service/app_properties.php");

/*
Converts a SQL date object into a detailed date for displaying on the Events page.
*/
function svc_longFormatDate($date){
	return date_format($date, "l, F j g:i a");
}

/*
Returns a MySQL result set containing all upcoming event data from the event_schedule table.
*/
function svc_getAllUpcomingEvents($showprivate){
	if (is_null($showprivate)) $showprivate = false;
	global $db;
	$query = "SELECT * FROM event_schedule WHERE event_time >= NOW()";
	if (!$showprivate) $query .= " AND event_signup_access = 0";
	$query .= " ORDER BY event_time ASC";
	$result = mysqli_query($db, $query);
	if (!$result){
		writeLog(SEVERE, "getAllUpcomingEvents failed");
		writeLog(SEVERE, mysqli_error($db));
		return false;
	} else {
		writeLog(DEBUG, "getAllUpcomingEvents returned ".mysqli_num_rows($result)." rows, private=".$showprivate);
		return $result;
	}
}

/*
Returns true if the specified event is full (current signups >= signup limit.)
*/
function svc_isEventFull($event_id){
	global $db;
	$query = "SELECT count(s.uuid) AS current, e.event_signup_limit AS max 
	FROM event_user_signup s 
	INNER JOIN event_schedule e ON e.event_id = s.event_id 
	WHERE e.event_id = '$event_id'";

	if ($result = mysqli_query($db, $query)){
		$data = mysqli_fetch_assoc($result);
		$current = $data['current'];
		$max = $data['max'];
		writeLog(TRACE, "Event Limit current=".$current." max=".$max);
		if ($current >= $max and $max >= 0){
			return true;
		} else {
			return false;
		}
	} else {
		writeLog(ERROR, "isEventFull call failed");
		writeLog(ERROR, mysqli_error($db));
		return true;
	}
}

/*
Returns a MySQL result set of all past events from the event_schedule table.
*/
function svc_getAllPastEvents($showprivate){
	if (is_null($showprivate)) $showprivate = false;
	global $db;
	$query = "SELECT * FROM event_schedule WHERE event_time < NOW()";
	if (!$showprivate) $query .= " AND event_signup_access = 0";
	$query .= " ORDER BY event_time DESC";
	$result = mysqli_query($db, $query);
	if (!$result){
		writeLog(SEVERE, "getAllPastEvents failed");
		writeLog(SEVERE, mysqli_error($db));
		return false;
	} else {
		return $result;
	}
}

/*
Returns true if the specified user/uuid is signed up for the specified event id.
*/
function svc_isUserSignedUp($uuid, $event_id){
	global $db;
	$query = "SELECT * FROM event_user_signup WHERE uuid = '$uuid' AND event_id = '$event_id'";
	if (mysqli_num_rows(mysqli_query($db, $query))>0){
		return true;
	}
	return false;
}

/*
Returns an array of all event ids the specified user/uuid is signed up for.
*/
function svc_getEventIdsByUser($uuid){
	if ($uuid==null){
		writeLog(TRACE, "getEventIdsByUser called for guest, returning an empty array.");
		return array();
	}
	global $db;
	$query="SELECT event_id FROM event_user_signup WHERE uuid = '$uuid'";
	$rs = mysqli_query($db, $query);
	$column = array();
	while ($row = mysqli_fetch_array($rs)){
		$column[] = $row[0];
	}
	writeLog(TRACE, "getEventIdsByUser returned ".sizeof($column)." results for userid=".$uuid);
	return $column;
}

/*
Sign up the specified user/uuid for the specified event id.
*/
function svc_addSignup($uuid, $event_id){
	if (svc_isUserSignedUp($uuid, $event_id)){
		writeLog(INFO, "Cancelling addSignup: Member is already in the list!"); //Added for Incident 64
		return true;
	}
	global $db;
	$query = "INSERT INTO event_user_signup (uuid, event_id) VALUES ('$uuid', '$event_id')";
	if (mysqli_query($db, $query)){
		return true;
	} else {
		writeLog(SEVERE, "addSignup (Member) FAILED to insert");
		writeLog(SEVERE, "MySQL Error: ".mysqli_error($db));
		return false;
	}
}

/*
Creates a guest signup entry for the specified event id.
DEPRECATED - Will be replaced in v2.5 with the new guest signup system.
*/
function svc_addGuestSignup($event_id, $name, $contact){
	global $db;
	$query = "INSERT INTO event_user_signup (event_id, signup_name, signup_contact) VALUES ('$event_id', '$name', '$contact')";
	if (mysqli_query($db, $query)){
		return true;
	} else {
		writeLog(SEVERE, "addSignup (Guest) FAILED to insert");
		writeLog(SEVERE, "MySQL Error: ".mysqli_error($db));
		return false;
	}
}

/*
Remove a user's signup from the specified event id.
*/
function svc_deleteSignup($uuid, $event_id){
	global $db;
	$query = "DELETE FROM event_user_signup WHERE uuid='$uuid' AND event_id='$event_id'";
	if (mysqli_query($db, $query)){
		return true;
	} else {
		writeLog(SEVERE, "deleteSignup (Member) FAILED to delete");
		writeLog(SEVERE, "MySQL Error: ".mysqli_error($db));
		return false;
	}
}

/*
No return value.
Echoes a list of HTML <option> tags for events in a dropdown menu.
If past=false, only upcoming events will be shown.
If tourneys=true, only tournaments will be shown.
*/
function svc_getEventListAsOptions($past, $tourneys){
	global $db;
	$query = "SELECT event_id, event_title FROM event_schedule";
	if ($tourneys){
		$query .= " WHERE event_type = 0";
	} else {
		$query .= " WHERE event_type <= 5";
	}

	if (!$past){
		$query .= " AND event_time >= NOW()";
	}

	$rs = mysqli_query($db, $query);

	while ($opt = mysqli_fetch_assoc($rs)){
		echo "<option value='".$opt['event_id']."'>".$opt['event_title']."</option>";
	}
}

/*
No return value.
Echoes a list of HTML <option> tags for all matchmaking events.
*/
function svc_getMatchmakingEventsAsOptions(){
	global $db;
	$query = "SELECT event_id, event_title FROM event_schedule WHERE event_type IN (1, 2)";

	$rs = mysqli_query($db, $query);

	while ($opt = mysqli_fetch_assoc($rs)){
		echo "<option value='".$opt['event_id']."'>".$opt['event_title']."</option>";
	}
}

/*
Returns the MySQL result set containing all signup information for the specified event.
*/
function svc_getGuestListByEvent($event_id){
	global $db;
	$query = "SELECT signup_id, event_user_signup.uuid, signup_name, signup_contact, user_username FROM event_user_signup
	LEFT OUTER JOIN user_authentication ON event_user_signup.uuid = user_authentication.uuid 
	WHERE event_id = '$event_id'";

	$result = mysqli_query($db, $query);

	if (!$result){
		writeLog(SEVERE, "getGuestListByEvent Failed for event_id=".$event_id);
		writeLog(SEVERE, "MySQL Error: ".mysqli_error($db));
	} else {
		writeLog(DEBUG, "getGuestListByEvent returned ".mysqli_num_rows($result)." rows for event id=".$event_id);
	}

	return $result;
}

/*
Returns an associative array representing all data for a single event.
*/
function svc_getEventDataById($event_id){
	global $db;
	$query = "SELECT * FROM event_schedule WHERE event_id = '$event_id'";
	$rs = mysqli_query($db, $query);
	if (!$rs){
		writeLog(SEVERE, "getEventDataById Failed for ID = ".$event_id);
		writeLog(SEVERE, "MySQL Error: ".mysqli_error($db));
		return false;
	}
	if (mysqli_num_rows($rs)==0){
		writeLog(ERROR, "getEventDataById called for unknown event ID = ".$event_id.", no rows returned");
		return false;
	}
	return mysqli_fetch_assoc($rs);
}

/*
Add an event to the table.
*/
function svc_addEvent($title, $datetime, $location, $type, $visibility, $description, $limit){
	global $db;
	$owner = $_SESSION['uuid'];
	$query = "INSERT INTO event_schedule (event_title, event_time, event_location, event_type, event_signup_access, event_description, event_owner_uuid, event_signup_limit)
	VALUES ('$title', '$datetime', '$location', '$type', '$visibility', '$description', '$owner', '$limit')";

	if (mysqli_query($db, $query)){
		writeLog(INFO, "A new event was created by ".$_SESSION['name'].": ".$title);
		return true;
	}
	else {
		writeLog(SEVERE, "An event failed to create!");
		writeLog(SEVERE, "Query: ".$query);
		writeLog(SEVERE, "MySQL Error: ".mysqli_error($db));
		return false;
	}
}

/*
Modify an existing event with the specified event id.
*/
function svc_updateEvent($event_id, $title, $datetime, $location, $visibility, $description, $limit){
	global $db;
	$query = "UPDATE event_schedule SET 
	event_title = '$title', 
	event_time = '$datetime',
	event_location = '$location', 
	event_signup_access = '$visibility', 
	event_description = '$description',
	event_signup_limit = '$limit' 
	WHERE event_id = '$event_id'";

	if (mysqli_query($db, $query)){
		writeLog(INFO, "An event was changed by ".$_SESSION['name'].": ".$title);
		return true;
	}
	else {
		writeLog(SEVERE, "Event change failed for ID ".$event_id);
		writeLog(SEVERE, "Query: ".$query);
		writeLog(SEVERE, "MySQL Error: ".mysqli_error($db));
		return false;
	}
}

/*
Delete the event with the specified event_id.
*/
function svc_removeEvent($event_id){
	global $db;
	$query = "DELETE FROM event_schedule WHERE event_id = '$event_id'";
	if (mysqli_query($db, $query)){
		writeLog(INFO, "An event was deleted by ".$_SESSION['name'].": ".$event_id);
		return true;
	} else {
		writeLog(SEVERE, "Event change failed for ID ".$event_id);
		writeLog(SEVERE, "Query: ".$query);
		writeLog(SEVERE, "MySQL Error: ".mysqli_error($db));
		return false;
	}
}

/*
Deletes all signups from the table that match the specified signup row ids.
Used for removing guests in bulk from the admin panel.
*/
function svc_purgeSignups($entries){
	global $db;
	if (is_array($entries)){
		$query = "DELETE FROM event_user_signup WHERE signup_id IN (".implode(",", $entries).")";
		if (mysqli_query($db, $query)){
			writeLog(INFO, "User ".$_SESSION['name']." purged ".count($entries)." event signup entries.");
			return true;
		} else {
			writeLog(SEVERE, "purgeSignups failed");
			writeLog(SEVERE, "Query: ".$query);
			writeLog(SEVERE, "MySQL Error: ".mysqli_error($db));
			return false;
		}
	} else {
		writeLog(SEVERE, "Call to purgeSignups failed - entries is not an array");
		return false;
	}
}

/*
Lock or unlock the signups for the specified event id.
True to lock, false to unlock.
*/
function svc_setSignupLock($event_id, $lock){
	global $db;
	if ($lock) $open=0;
	else $open=1;
	$query = "UPDATE event_schedule SET event_signup_open = '$open' WHERE event_id = '$event_id'";
	if (mysqli_query($db, $query)){
		if ($lock) writeLog(INFO, "Locked signup for event ID ".$event_id);
		else writeLog(INFO, "Unlocked signup for event ID ".$event_id);
		return true;
	} else {
		writeLog(ERROR, "Failed to set signup lock state");
		writeLog(ERROR, mysqli_error($db));
		return false;
	}
}

?>