<?php

require_once($_SERVER['DOCUMENT_ROOT']."/service/app_properties.php");
require_once($_SERVER['DOCUMENT_ROOT']."/service/svc_site_settings.php");

/*
Returns a MySQL result set containing the list of seasons, including the current season.
*/
function svc_getSeasonListWithGameTitles(){
	global $db;
	$query = "SELECT season_id, season_title, season_game FROM season_data WHERE season_id > 0
	ORDER BY season_id DESC";
	$rs = mysqli_query($db, $query);

	if (!$rs){
		writeLog(SEVERE, "getSeasonList failed!");
		writeLog(SEVERE, mysqli_error($db));
		return false;
	}
	else return $rs;
}

/*
Pulls the hall of records information for the Records landing page.
Returns a 2-dimensional associative array, record name => user/value => data
*/
function svc_getLandingPageRecordData(){
	global $db;
	$data = array();

	//Highest rank this season
	$query1 = "SELECT r.rank_season_high, a.user_username 
	FROM user_ranking r 
	INNER JOIN user_authentication a ON a.uuid = r.uuid 
	WHERE rank_season_high = (SELECT MAX(rank_season_high) FROM user_ranking WHERE rank_placements = 0) 
    LIMIT 3";
	if ($rs = mysqli_query($db, $query1)){
		$user="";
		while ($rec = mysqli_fetch_assoc($rs)){
			$value = $rec["rank_season_high"];
			if (strlen($user)>0){
				 $user .= ", ";
			}
			$user .= $rec["user_username"];
		}
		if (strlen($user)>0){
			$data["HighestRankThisSeason"] = [
				"user" => $user,
				"rank" => $value,
			];
		}
	} else {
		writeLog(ERROR, "Error on landing page record: Highest rank this season");
		writeLog(ERROR, mysqli_error($db));
	}


	//Highest rating of all time
	$query2 = "SELECT r.rank_career_high, a.user_username 
	FROM user_ranking r 
	INNER JOIN user_authentication a ON a.uuid = r.uuid 
	WHERE rank_career_high = (SELECT MAX(rank_career_high) FROM user_ranking WHERE rank_career_high > 0) 
    LIMIT 3";
	if ($rs = mysqli_query($db, $query2)){
		$user="";
		while ($rec = mysqli_fetch_assoc($rs)){
			$value = $rec["rank_career_high"];
			if (strlen($user)>0){
				 $user .= ", ";
			}
			$user .= $rec["user_username"];
		}
		if (strlen($user)>0){
			$data["HighestRankAllTime"] = [
				"user" => $user,
				"rank" => $value,
			];
		}
	} else {
		writeLog(ERROR, "Error on landing page record: Highest rank this season");
		writeLog(ERROR, mysqli_error($db));
	}

	//Longest winning streak
	$interval = svc_getSetting("WinningStreakInterval");
	$query3 = "SELECT r.rank_consec_max, a.user_username 
	FROM user_ranking r 
	INNER JOIN user_authentication a ON a.uuid = r.uuid 
	WHERE rank_consec_max >= '$interval' 
    AND rank_consec_max = (SELECT MAX(rank_consec_max) FROM user_ranking) 
    LIMIT 3";
	if ($rs = mysqli_query($db, $query3)){
		$user="";
		while ($rec = mysqli_fetch_assoc($rs)){
			$value = $rec["rank_consec_max"];
			if (strlen($user)>0){
				 $user .= ", ";
			}			
			$user .= $rec["user_username"];
		}
		if (strlen($user)>0){
			$data["LongestWinningStreak"] = [
				"user" => $user,
				"streak" => $value
			];
		}
	} else {
		writeLog(ERROR, "Error on landing page record: Longest winning streak");
		writeLog(ERROR, mysqli_error($db));
	}

	//Most matches won
	$query4 = "SELECT r.rank_career_wins, a.user_username 
	FROM user_ranking r 
	INNER JOIN user_authentication a ON a.uuid = r.uuid 
	WHERE rank_career_wins = (SELECT MAX(rank_career_wins) FROM user_ranking WHERE rank_career_wins > 0) 
    LIMIT 3";
	if ($rs = mysqli_query($db, $query4)){
		$user="";
		while ($rec = mysqli_fetch_assoc($rs)){
			$value = $rec["rank_career_wins"];
			if (strlen($user)>0){
				 $user .= ", ";
			}			
			$user .= $rec["user_username"];
		}
		if (strlen($user)>0){
			$data["MostMatchesWon"] = [
				"user" => $user,
				"wins" => $value
			];
		}
	} else {
		writeLog(ERROR, "Error on landing page record: Most matches won");
		writeLog(ERROR, mysqli_error($db));
	}

	//Most tournaments won
	$query5 = "SELECT r.rank_tourney_wins, a.user_username 
	FROM user_ranking r 
	INNER JOIN user_authentication a ON a.uuid = r.uuid 
	WHERE rank_tourney_wins = (SELECT MAX(rank_tourney_wins) FROM user_ranking WHERE rank_tourney_wins > 0) 
    LIMIT 3";
	if ($rs = mysqli_query($db, $query5)){
		$user="";
		while ($rec = mysqli_fetch_assoc($rs)){
			$value = $rec["rank_tourney_wins"];
			if (strlen($user)>0){
				 $user .= ", ";
			}			
			$user .= $rec["user_username"];
		}
		if (strlen($user)>0){
			$data["MostTournamentsWon"] = [
				"user" => $user,
				"wins" => $value
			];
		}
	} else {
		writeLog(ERROR, "Error on landing page record: Most tournaments won");
		writeLog(ERROR, mysqli_error($db));
	}

	writeLog(DEBUG, "Finished getting landing page records. Dumping array");
	writeLog(DEBUG, var_export($data, true));

	return $data;
}

function svc_getTournamentRecordsData($event_id){
	global $db;
	$query = "SELECT * FROM records_tourney_schedule WHERE event_id = '$event_id'";
	$rs = mysqli_query($db, $query);
	if ($rs){
		return mysqli_fetch_assoc($rs);
	} else {
		writeLog(SEVERE, "Failed to load tournament data");
		return false;
	}
}

function svc_getPastTournamentRounds($event_id, $bracket){
	global $db;
	$query = "SELECT * FROM records_tourney_round WHERE event_id = '$event_id' AND round_bracket_level = '$bracket'";
	return mysqli_query($db, $query);
}

function svc_getPastTournamentMatches($event_id, $bracket, $roundno){
	global $db;
	$query = "SELECT * FROM records_tourney_match WHERE event_id = '$event_id' AND match_round_no = '$roundno' AND match_bracket_level = '$bracket'";
	$rs = mysqli_query($db, $query);
	return $rs;
}

?>