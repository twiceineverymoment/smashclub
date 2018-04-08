<?php

require_once($_SERVER['DOCUMENT_ROOT']."/service/app_properties.php");
require_once($_SERVER['DOCUMENT_ROOT']."/service/svc_site_settings.php");

//Returns a MySQL result set containing all current ranks. Excludes players still in placement.
//order: 0 for current rank high to low, 1 for current rank low to high, 2 for season high high to low, 3 for career high high to low, 4 for A-Z
function svc_getAllCurrentRankData($order){
	global $db;
	$query = "SELECT * FROM user_ranking INNER JOIN user_authentication ON user_ranking.uuid = user_authentication.uuid WHERE rank_placements = 0 AND user_locked IN (0, 1, 3)";
	switch($order){
		default:
		case 0:
		$query .= " ORDER BY rank_current DESC";
		break;
		case 1:
		$query .= " ORDER BY rank_current ASC";
		break;
		case 2:
		$query .= " ORDER BY rank_season_high DESC";
		break;
		case 3:
		$query .= " ORDER BY rank_career_high DESC";
		break;
		case 4:
		$query .= " ORDER BY user_username ASC";
		break;
	}
	$result = mysqli_query($db, $query);
	if ($result){
		writeLog(DEBUG, "getAllCurrentRankData called with order=".$order);
		return $result;
	}
	else {
		writeLog(SEVERE, "getAllCurrentRankData failed with order=".$order);
		writeLog(SEVERE, "Query: ".$query);
		writeLog(SEVERE, "MySQL Error: ".mysqli_error($db));
		return false;
	}
}

function svc_getRankHistoryBySeason($seasonid, $order){
	global $db;
	$query = "SELECT * FROM user_rank_history
	INNER JOIN user_authentication ON user_rank_history.uuid = user_authentication.uuid
	WHERE season_number = '$seasonid'";
	switch($order){
		default:
		case 0:
		$query .= " ORDER BY rank_final DESC";
		break;
		case 1:
		$query .= " ORDER BY rank_final ASC";
		break;
		case 2:
		$query .= " ORDER BY rank_high DESC";
		break;
		case 3:
		$query .= " ORDER BY rank_high DESC";
		break;
		case 4:
		$query .= " ORDER BY user_username ASC";
		break;
	}
	$result = mysqli_query($db, $query);
	if ($result){
		writeLog(DEBUG, "getRankHistoryBySeason called with order=".$order);
		return $result;
	}
	else {
		writeLog(SEVERE, "getRankHistoryBySeason failed with order=".$order);
		writeLog(SEVERE, "Query: ".$query);
		writeLog(SEVERE, "MySQL Error: ".mysqli_error($db));
		return false;
	}
}

//Echoes a set of dropdown menu options for each account that is active. Excludes type 5 (invisible admin)
function svc_getEligiblePlayersHTML(){
	global $db;
	$query = "SELECT uuid, user_username FROM user_authentication WHERE user_locked < 2 AND user_type < 5 ORDER BY user_username ASC";

	$rs = mysqli_query($db, $query);

	while ($ent = mysqli_fetch_assoc($rs)){
		echo "<option value='".$ent['uuid']."'>".$ent['user_username']."</option>";
	}
}

function svc_getRankDataByUser($uuid){
	global $db;
	$query = "SELECT rank_current, rank_placements FROM user_ranking WHERE uuid = '$uuid'";
	$rs=mysqli_query($db, $query);
	if (!$rs){
		writeLog(SEVERE, "getRankDataByUser failed for id=".$uuid);
		return false;
	}
	else {
		return $rs;
	}
}

//Updates a user's ranking in the database to the new rank.
//Updates season and career highs, if applicable.
//Decrements placements counter if greater than zero.
function svc_updateRank($uuid, $rank){
	global $db;
	$query = "UPDATE user_ranking 
	SET rank_current = '$rank', 
	rank_season_high = CASE WHEN rank_placements<2 THEN GREATEST(rank_season_high, rank_current) ELSE rank_season_high END, 
	rank_career_high = CASE WHEN rank_placements<2 THEN GREATEST(rank_career_high, rank_current) ELSE rank_career_high END, 
	rank_placements = GREATEST(0, rank_placements-1) 
	WHERE uuid='$uuid'";
	//case is <2 because if placements is 1, then it will go to 0 and the member will place. If 0, it will not decrement

	if (mysqli_query($db, $query)){
		writeLog(INFO, "User ID ".$uuid." rank was updated to ".$rank." in database.");
		return true;
	}
	else {
		writeLog(SEVERE, "updateRank procedure failed! userid=".$uuid.", new rank=".$rank);
		writeLog(SEVERE, "Query: ".$query);
		writeLog(SEVERE, "MySQL Error: ".mysqli_error($db));
		return false;
	}
}

//Returns the tier code of a given rank, based on the established ranges in the 1-3000 scale.
function svc_getTierCodeByRank($rank){
	if ($rank<400) return 1;
	elseif ($rank<600) return 2;
	elseif ($rank<800) return 3;
	elseif ($rank<1000) return 4;
	elseif ($rank<1200) return 5;
	elseif ($rank<1400) return 6;
	elseif ($rank<1600) return 7;
	elseif ($rank<1800) return 8;
	elseif ($rank<2000) return 9;
	elseif ($rank<2200) return 10;
	elseif ($rank<2500) return 11;
	else return 12;
}

function svc_getTierName($tiercode){
	$tiers = array("E-Class", "D-Class", "C-Class", "B-Class", "A-Class", "Bronze", "Silver", "Gold", "Platinum", "Master 3rd-Class", "Master 2nd-Class", "Master 1st-Class");
	return $tiers[$tiercode-1];
}

function svc_isNewCareerHighTier($new, $high){
	if (svc_getTierCodeByRank($new) > svc_getTierCodeByRank($high)){
		return true;
	}
	return false;
}

//End the current season.
//Set the current season ID to 0 (offseason)
//Copy current ranking data into the records table.
function svc_endCurrentSeason(){
	global $db;
	writeLog(TRACE, "Entering endCurrentSeason...");
	//Copy the current rankings into the records table
	$query1 = "INSERT INTO user_rank_history (uuid, rank_final, rank_high) 
	SELECT uuid, rank_current, rank_season_high FROM user_ranking 
	WHERE user_ranking.rank_placements = 0";
	//Update the newly inserted records to the outgoing season's number
	$seasonnum = svc_getSetting("CurrentSeasonNumber");
	$query2 = "UPDATE user_rank_history SET season_number = '$seasonnum' WHERE season_number = 0";
	if (mysqli_query($db, $query1)){
		writeLog(TRACE, "Copy query completed.");
		if (mysqli_query($db, $query2)){
			writeLog(TRACE, "Season ID update query completed.");
			if (svc_putSetting("CurrentSeasonNumber", 0)){
				writeLog(TRACE, "Settings change completed.");
				writeLog(INFO, "User ".$_SESSION['name']." Ended the current season. Ratings have been stored to the Hall of Records.");
				return true;
			} else {
				writeLog(SEVERE, "endCurrentSeason failed on step 3: Change site settings");
				return false;
			}
		} else {
			writeLog(SEVERE, "endCurrentSeason failed on step 2: Update season number in records");
			writeLog(SEVERE, "Query: ".$query2);
			writeLog(SEVERE, "MySQL Error: ".mysqli_error($db));
			return false;
		}
	} else {
		writeLog(SEVERE, "endCurrentSeason failed on step 1: Copy current ranks to records");
		writeLog(SEVERE, "Query: ".$query1);
		writeLog(SEVERE, "MySQL Error: ".mysqli_error($db));
		return false;
	}
}

const INIT_FRESH_START = 2;
const INIT_LAST_SEASON = 0;
const INIT_AVG_SEASONS = 1;

//Insert a new record into the seasons table.
//Set current season ID to the new record.
//Set all initial ranks based on initRanks, clear season highs, and set placements to 4.
function svc_startSeason($title, $game, $method, $placements){
	writeLog(TRACE, "Entering startSeason...");
	global $db;
	$query1 = "INSERT INTO season_data (season_title, season_game, season_start_date) VALUES ('$title', '$game', NOW())";
	if (mysqli_query($db, $query1)){
		$seasonid = mysqli_insert_id($db);
		writeLog(TRACE, "Insert query successful, new season ID is ".$seasonid);
		svc_putSetting("CurrentSeasonNumber", $seasonid);
		svc_putSetting("InitialPlacementMatches", $placements);
		if (svc_populateInitRanks($method, $placements, $game)){
			writeLog(INFO, "User ".$_SESSION['name']." started a new season: ".$title);
			return true;
		} else {
			return false; //Init ranks method will have already logged the error
		}
	} else {
		writeLog(SEVERE, "startSeason failed!");
		writeLog(SEVERE, "Query: ".$query1);
		writeLog(SEVERE, "MySQL Error: ".mysqli_error($db));
	}
}

//Called by startSeason - populates the user_rankings table with new initial rankings
function svc_populateInitRanks($method, $placements, $game){
	global $db;
	if ($method==INIT_FRESH_START){ //Set all rows to 1200 and reset placement matches
		$query = "UPDATE user_ranking SET rank_current = 1200, rank_season_high = 0, rank_placements = '$placements'";
		if (mysqli_query($db, $query)){
			writeLog(DEBUG, "Initial season ratings have been populated using the fresh-start method,.");
			return true;
		} else {
			writeLog(SEVERE, "populateInitRanks failed.");
			writeLog(SEVERE, "Query: ".$query1);
			writeLog(SEVERE, "MySQL Error: ".mysqli_error($db));
			return false;
		}
	} elseif ($method==INIT_LAST_SEASON) {
		$games = implode("','", svc_getSeasonsByGame($game));
		$query1 = "SELECT uuid, rank_final FROM user_rank_history WHERE season_number IN ('$games') ORDER BY season_number DESC"; //If we select relevant seasons and order highest first, then the first row we hit for each player is the last relevant season we have data for.
		$user_array = svc_getActiveUUIDArray();
		$rs1 = mysqli_query($db, $query1);
		if (!$rs1){
			writeLog(SEVERE, "populateInitRanks failed on records query.");
			writeLog(SEVERE, "Query: ".$query1);
			writeLog(SEVERE, "MySQL Error: ".mysqli_error($db));
			return false;
		}
		$init_ranks = array();
		for($i=0; $i<sizeof($user_array); $i++){ //Build an initial array with active UUID's as keys, and 1200 as values. If we don't get any hits in the next look for some user, then their value will be the fallback of 1200.
			$key = (string) $user_array[$i];
			writeLog(TRACE, "Looking for records for UUID ".$key);
			$init_ranks[$key] = 1200;
			mysqli_data_seek($rs1, 0);
			while ($rec = mysqli_fetch_assoc($rs1)){
				if ($rec['uuid']==$key){
					writeLog(TRACE, "Found a record for UUID ".$key." = ".$rec['rank_final']);
					$init_ranks[$key]=$rec['rank_final'];
					break; //Stop at the first hit, as it will be the most recent season that came back in the records query.
				}
			}
		}
		foreach($init_ranks as $rkey => $rval){ //Perform database updates.
			$query2 = "UPDATE user_ranking SET rank_current = '$rval', rank_season_high = 0, rank_placements = '$placements' WHERE uuid = '$rkey'";
			if (mysqli_query($db, $query2)){
				writeLog(TRACE, "init_ranks query: ".$query2);
			} else {
				writeLog(SEVERE, "init_ranks query failed. Aborting the update.");
				writeLog(SEVERE, "Query: ".$query2);
				writeLog(SEVERE, "MySQL Error: ".mysqli_error($db));
				return false;
			}
		}
		writeLog(DEBUG, "Initial season ratings have been populated using the last-season method.");
		return true;
	}
}

//Returns an array of all seasons matching the given game (or mixed)
function svc_getSeasonsByGame($game){
	global $db;
	$query = "SELECT season_id FROM season_data";
	if ($game!=0){
		$query .= " WHERE season_game in ('$game', 0)";
	}
	writeLog(4, "getSeasonsByGame Query: ".$query);
	$result = array();
	$rs = mysqli_query($db, $query);
	writeLog(4, "getSeasonsByGame returned ".mysqli_num_rows($rs)." rows");
	$i=0;
	while ($row = mysqli_fetch_assoc($rs)){
		$result[$i] = $row['season_id'];
		$i++;
	}
	return $result;
}

function svc_getActiveUUIDArray(){
	global $db;
	$query = "SELECT uuid FROM user_ranking";
	$result = array();
	$rs = mysqli_query($db, $query);
	$i=0;
	while ($row = mysqli_fetch_assoc($rs)){
		$result[$i] = $row['uuid'];
		$i++;
	}
	return $result;
}