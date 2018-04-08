<?php
require_once($_SERVER['DOCUMENT_ROOT']."/service/app_properties.php");
require_once($_SERVER['DOCUMENT_ROOT']."/service/svc_site_settings.php");
require_once($_SERVER['DOCUMENT_ROOT']."/service/svc_authentication.php");

function svc_getFreeplayQueue(){
	global $db;
	$query = "SELECT * FROM match_freeplay_queue ORDER BY match_id ASC";
	return mysqli_query($db, $query);
}

//Returns the UUID of a ranked match for the specified user, using the specified event guest list.
//Order should be 0 for the first search, incrementing by 1 for each new search to return the next match.
//Leave event-id null to pool from the entire roster.
//Returns null if there are no further matches.
function svc_getMatchProposal($uuid, $event_id, $order, $enforce_ranks){
	global $db;
	$query1 = "SELECT rank_current FROM user_ranking WHERE uuid = '$uuid'"; //Grab the logged in user's current rank
	$rank = mysqli_fetch_assoc(mysqli_query($db, $query1))['rank_current'];

	if ($event_id==0){ //Pool from the entire club roster if no event is selected
		$query2 = "SELECT a.uuid, a.user_username, r.rank_current, r.rank_season_high, ABS(r.rank_current - '$rank') 
		FROM user_authentication a 
		INNER JOIN user_ranking r ON r.uuid = a.uuid 
		WHERE a.user_type < 5 AND a.user_locked IN (0,1) 
		ORDER BY ABS(r.rank_current - '$rank') ASC";
	} else { //Pool only from the signed-up guests
		$query2 = "SELECT s.uuid, a.user_username, r.rank_current, r.rank_season_high, ABS(r.rank_current - '$rank') 
		FROM event_user_signup s
		INNER JOIN user_authentication a ON s.uuid = a.uuid 
		INNER JOIN user_ranking r ON s.uuid = r.uuid 
		WHERE s.event_id = '$event_id' AND a.user_type < 5 AND a.user_locked IN (0,1) 
		ORDER BY ABS(r.rank_current - '$rank') ASC";
	}

	$rs = mysqli_query($db, $query2);
	if (!$rs){
		writeLog(SEVERE, "getMatchProposal encountered an error");
		writeLog(SEVERE, "Query: ".$query2);
		writeLog(SEVERE, "MySQL Error: ".mysqli_error($db));
		return null;
	}

	$counter = 0;
	while ($opp = mysqli_fetch_assoc($rs)){
		if ($enforce_ranks and !svc_playersCanPairInRanked($rank, $opp['rank_current'])){
			continue;
		}
		if ($opp['uuid']==$uuid) continue; //Prevent players from pairing with themselves
		if ($counter == $order){
			return $opp;
		} else {
			$counter++;
		}
	}
	return null;
}

//Queue up a singles match between two UUID's.
function svc_addSinglesMatchToQueue($p1id, $p2id, $type){
	global $db;
	$query = "INSERT INTO match_freeplay_queue (match_p1_uuid, match_p2_uuid, match_type) VALUES ('$p1id', '$p2id', '$type')";
	if (mysqli_query($db, $query)){
		return true;
	} else {
		writeLog(SEVERE, "addSinglesMatchToQueue failed");
		writeLog(SEVERE, "MySQL Error: ".mysqli_error($db));
		return false;
	}
}

//Close the match with the specified ID.
//A separate script will save the scores. This function only removes the match from the queue.
function svc_closeMatch($match_id){
	global $db;
	if (mysqli_query($db, "DELETE FROM match_freeplay_queue WHERE match_id = '$match_id'")){
		writeLog(INFO, "Queued match #".$match_id." was closed.");
		return true;
	} else {
		writeLog(SEVERE, "Failed to close queued match #".$match_id);
		writeLog(SEVERE, mysqli_error($db));
		return false;
	}
}

//Returns info about the next queued match the specified user is in.
//If no match is found, returns false.
function svc_getQueuedMatch($uuid, $type){
	global $db;
	$query = "SELECT q.* FROM match_freeplay_queue q WHERE (q.match_p1_uuid = '$uuid' OR q.match_p2_uuid = '$uuid') AND q.match_type = '$type'";
	$rs = mysqli_query($db, $query);
	if (mysqli_num_rows($rs)==0){
		return false;
	} elseif (mysqli_num_rows($rs)>1){
		writeLog(ERROR, "Found multiple queued matches of the same type for user ID = ".$uuid.". This could mean you have bad data!");
	}
	return mysqli_fetch_assoc($rs); //There should never be more than 1 row returned by this function. If there is, just take the first one.
}

//Returns the user's order in the match queue for the match of the specified type.
//Returns 0 if the user is not currently in the queue for the specified type.
//0=matchmaking, 1=requested, 2=either
function svc_getQueueOrder($uuid, $type){
	global $db;
	$query = "SELECT match_p1_uuid, match_p2_uuid, match_type FROM match_freeplay_queue";
	// if ($type!=2) $query .= " WHERE match_type = '$type'";
	$ordinal = 0;
	$rs = mysqli_query($db, $query);
	if (!$rs){
		writeLog(SEVERE, "getQueueOrder failed to execute SQL query");
		return false;
	}
	while ($match = mysqli_fetch_assoc($rs)){
		$ordinal++;
		if (($match['match_p1_uuid']==$uuid or $match['match_p2_uuid']==$uuid) and $match['match_type']==$type){
			return $ordinal;
		}
	}
	return 0;
}

function svc_startFreePlayEvent($ranked){
	svc_putSetting("TourneyStatus", 3);
	svc_putSetting("MatchMakingEvent", 0);
	if ($ranked){
		svc_putSetting("EventIsRanked", 1);
	} else {
		svc_putSetting("EventIsRanked", 0);
	}
	writeLog(INFO, "User ".$_SESSION['name']." started free play with ranked=".$ranked);
	return true;
}

function svc_startEventPlay($event_id, $ranked){
	svc_putSetting("TourneyStatus", 3);
	svc_putSetting("MatchMakingEvent", $event_id);
	svc_putSetting("EventIsRanked", $ranked);
	writeLog(INFO, "User ".$_SESSION['name']." started event play with ranked=".$ranked);
	return true;
}

function svc_getViableOpponentsAsOptions($uuid, $event_id, $enforce_ranks){
	global $db;
	if ($event_id==0){ //Open play, list all active users
		$query = "SELECT a.uuid, a.user_username, r.rank_current FROM user_authentication a 
		INNER JOIN user_ranking r ON a.uuid = r.uuid 
		WHERE a.user_type < 5 AND a.user_locked IN (0, 1)";
	} else { //Event play, pull members from event signup table
		$query = "SELECT s.uuid, a.user_username, r.rank_current FROM event_user_signup s
		INNER JOIN user_authentication a ON s.uuid = a.uuid
		INNER JOIN user_ranking r ON s.uuid = r.uuid
		WHERE s.event_id = '$event_id'
		ORDER BY a.user_username ASC";
	}
	$rs = mysqli_query($db, $query);
	if (!$rs){
		writeLog(SEVERE, "getViableOpponentsAsOptions encountered an error");
		writeLog(SEVERE, "MySQL Error: ".mysqli_error($db));
		return false;
	}
	while ($row = mysqli_fetch_assoc($rs)){
		if ($row['uuid']==$_SESSION['uuid']) continue; //Defect 68 fix
		$disable = false;
		if (svc_getQueueOrder($row['uuid'], 1) != 0) $disable = true; //Gray-out options for members that are already in the Friends queue
		$warn = 0;
		if ($enforce_ranks){
			$myid = $_SESSION['uuid'];
			$query2 = "SELECT rank_current FROM user_ranking WHERE uuid = '$myid'"; //Grab the logged in user's current rank
			$myrank = mysqli_fetch_assoc(mysqli_query($db, $query2))['rank_current'];
			if (!svc_playersCanPairInRanked($myrank, $row['rank_current'])){
				writeLog(TRACE, "Setting warn to true because r1=".$myrank." and r2=".$row['rank_current']);
				if ($myrank > $row['rank_current']){
					$warn = 1;
				} else {
					$warn = -1;
				}
			}
		}

		echo "<option value='".$row['uuid']."'";
		if ($disable){
			echo " disabled>";
		} else {
			echo ">";
		}
		if ($warn==1) echo "&darr; ";
		elseif ($warn==-1) echo "&uarr; ";
		echo $row['user_username'];
		echo "</option>";
	}
}

function svc_playersCanPairInRanked($rank1, $rank2){
	$diff = abs($rank1 - $rank2);
	if ($rank1>=2000 or $rank2>=2000){ //If either player is Master 3rd Class or above, diff must be no more than 400
		return ($diff <= 400) ? true : false ;
	}
	elseif ($rank1>=1200 or $rank2>=1200){ //If either player is Bronze or above, diff must be no more than 800
		return ($diff <= 800) ? true : false ;
	}
	else { //If both players are A-class or lower, there are no restrictions
		return true;
	}
}

function svc_clearQueue(){
	global $db;
	mysqli_query($db, "DELETE FROM match_freeplay_queue");
}

function svc_getQueuedOpponent($uuid, $type){
	global $db;
	$query = "SELECT q.* FROM match_freeplay_queue q WHERE (q.match_p1_uuid = '$uuid' OR q.match_p2_uuid = '$uuid') AND q.match_type = '$type'";
	$rs = mysqli_query($db, $query);
	$row = mysqli_fetch_assoc($rs);
	if ($row['match_p1_uuid']==$uuid){
		return svc_getUsernameByID($row['match_p2_uuid']);
	}
	elseif ($row['match_p2_uuid']==$uuid){
		return svc_getUsernameByID($row['match_p1_uuid']);
	}
	else {
		writeLog(ERROR, "getQueuedOpponent name couldn't get a match properly. Something is terribly wrong.");
		return null;
	}
}

?>