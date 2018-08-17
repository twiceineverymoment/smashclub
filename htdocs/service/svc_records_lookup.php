<?php

require_once($_SERVER['DOCUMENT_ROOT']."/service/app_properties.php");
require_once($_SERVER['DOCUMENT_ROOT']."/service/svc_site_settings.php");

$games_short = array("Mixed", "Smash64", "Melee", "Brawl", "Wii U");
$games_long = array("", "Super Smash Bros. (N64)", "Super Smash Bros. Melee (GC)", "Super Smash Bros. Brawl (Wii)", "Super Smash Bros. for Wii U / 3DS");

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
Prints the list of seasons w/ game titles as dropdown options.
$current: If true, include the current season in the dropdown.
$selectedId: The option to be initially selected.
*/
function svc_echoSeasonList($current, $selectedId = ""){
	global $games_short;
	$seasons = svc_getSeasonListWithGameTitles();
				while ($opt = mysqli_fetch_assoc($seasons)){
					if ($opt['season_id']==svc_getSetting("CurrentSeasonNumber") && !$current) continue; //Added for issue #29
					echo "<option value='".$opt['season_id']."' ".($opt['season_id']==$selectedId ? "selected" : "").">";
					echo $opt['season_title']." (".$games_short[$opt['season_game']].")";
					echo "</option>";
				}
}

/*
Prints the list of games to lookup records by game.
$selectedId: The option to be initially selected.
*/
function svc_echoGamesList($selectedId = ""){
	global $games_long;
	for($i=1; $i<count($games_long); $i++){
		echo "<option value='".$i."' ".($i==$selectedId ? "selected" : "").">";
		echo $games_long[$i];
		echo "</option>";
	}
}

function svc_getCurrentSeasonGameNo(){
	global $db;
	$season = svc_getSetting("CurrentSeasonNumber");
	if ($season==0){
		$query = "SELECT season_game FROM season_data ORDER BY season_id DESC LIMIT 1";
	} else {
		$query = "SELECT season_game FROM season_data WHERE season_id = '$season'";
	}
	$rs = mysqli_query($db, $query);
	if ($rs){
		return mysqli_fetch_assoc($rs)['season_game'];
	} else {
		writeLog(ERROR, $query);
		writeLog(ERROR, mysqli_error($db));
		return false;
	}
}

function svc_getPlayerRankInfoBySeason($uuid, $season_id){
	global $db;
	$query = "SELECT * FROM records_user_ranking WHERE uuid = '$uuid' AND season_number = '$season_id' LIMIT 1";
	if ($rs = mysqli_query($db, $query)){
		return mysqli_fetch_assoc($rs);
	} else {
		return false;
	}
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

function svc_searchMatchLog($user, $opponent, $season_id, $event_id){ //TODO Update for doubles matches
	global $db;
	$query = "SELECT * FROM match_score_log 
	WHERE 1=1 ";

	if (!empty($user)){
		$query .= "AND (match_p1_uuid = '$user' OR match_p2_uuid = '$user') ";
	}
	if (!empty($opponent)){
		$query .= "AND (match_p1_uuid = '$opponent' OR match_p2_uuid = '$opponent') ";
	}
	if (!empty($season_id) or $season_id === "0"){
		$query .= "AND season_id = '$season_id'";
	}
	if (!empty($event_id) or $event_id === "0"){
		$query .= "AND event_id = '$event_id'";
	}
	$query .= " ORDER BY match_no DESC";

	if ($rs = mysqli_query($db, $query)){
		writeLog(TRACE, $query);
		return $rs;
	} else {
		writeLog(ERROR, "searchMatchLog failed");
		writeLog(ERROR, $query);
		writeLog(ERROR, mysqli_error($db));
		return false;
	}
}

function svc_getSeasonNameByID($season_id){
	global $db;
	$query = "SELECT season_title FROM season_data WHERE season_id = '$season_id'";
	return mysqli_fetch_assoc(mysqli_query($db, $query))["season_title"];
}

function svc_getAllTimeCompProfileStats($uuid){
	global $db;
	
}

function svc_echoTournamentRecordsList($selectedId = ""){
	global $db;
	$query = "SELECT r.event_id, e.event_title FROM records_tourney_schedule r INNER JOIN event_schedule e ON e.event_id = r.event_id ORDER BY e.event_time DESC";

	$rs = mysqli_query($db, $query);

	while ($opt = mysqli_fetch_assoc($rs)){
		echo "<option value='".$opt['event_id']."' ".($opt['event_id']==$selectedId ? "selected" : "").">".$opt['event_title']."</option>";
	}
}

?>