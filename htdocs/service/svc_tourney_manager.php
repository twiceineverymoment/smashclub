<?php

require_once($_SERVER['DOCUMENT_ROOT']."/service/app_properties.php");
require_once($_SERVER['DOCUMENT_ROOT']."/service/svc_authentication.php");
require_once($_SERVER['DOCUMENT_ROOT']."/service/svc_activity_feed.php");
require_once($_SERVER['DOCUMENT_ROOT']."/service/svc_event_manager.php");

//Returns match data for a bracketed tourney.
//0=winners bracket or single elim, 1=losers bracket
//roundno starts with 0 for the first round
function svc_getBracketMatches($bracket, $roundno){

	global $db;
	$query = "SELECT * FROM tourney_match_order WHERE match_round_no = '$roundno' AND match_bracket_level = '$bracket'";
	$rs = mysqli_query($db, $query);
	return $rs;

}

function svc_getBracketRounds($bracket){

	global $db;
	$query = "SELECT * FROM tourney_round_list WHERE round_bracket_level = '$bracket'";
	return mysqli_query($db, $query);

}

function svc_getAllMatchData(){

	global $db;
	$query = "SELECT * FROM tourney_match_order";
	return mysqli_query($db, $query);

}

/*
Remedies out-of-line match statuses:
- Matches with both slots filled but still Pending - sets to Ready
*/
function svc_refreshMatchStatuses(){
	global $db;
	$query = "UPDATE tourney_match_order SET match_status = 1 WHERE match_status = 0 AND match_p1_uuid > 0 AND match_p2_uuid > 0";
	if (mysqli_query($db, $query)){
		writeLog(DEBUG, "Successfully called RefreshMatchStatuses");
		return true;
	} else {
		writeLog(ERROR, "Failed to run REFRESH MATCH STATUSES");
		writeLog(ERROR, mysqli_error($db));
		return false;
	}
}

//Set a match to In Progress
function svc_startMatch($matchno){
	global $db;
	$query = "UPDATE tourney_match_order SET match_status = 2 WHERE match_order = '$matchno'";
	if (mysqli_query($db, $query)){
		writeLog(INFO, "Tourney match ".$matchno." was started.");
		return true;
	} else {
		writeLog(ERROR, "Failed to run STARTMATCH on match # ".$matchno);
		writeLog(ERROR, mysqli_error($db));
		return false;
	}
}

//Update the scores on a match (does not affect status)
function svc_updateScore($matchno, $score1, $score2){
	global $db;
	$query = "UPDATE tourney_match_order SET match_p1_score = '$score1', match_p2_score = '$score2' WHERE match_order = '$matchno'";
	if (mysqli_query($db, $query)){
		writeLog(INFO, "Updated scores on tourney match ".$matchno);
		return true;
	} else {
		writeLog(ERROR, "Failed to run UPDATESCORE on match # ".$matchno);
		writeLog(ERROR, mysqli_error($db));
		return false;
	}
}

//Marks the match as complete, sets the winner, and moves the winner and loser forward in the bracket
function svc_completeMatch($matchno, $winner_uuid, $loser_uuid){
	global $db;
	$query0 = "UPDATE tourney_match_order SET match_status = 3, match_winner_uuid = '$winner_uuid' WHERE match_order = '$matchno'";
	$winner_string = "W:".$matchno;
	$loser_string = "L:".$matchno;
	writeLog(TRACE, "Reference strings are ".$winner_string.", ".$loser_string);
	if (mysqli_query($db, $query0)){
		writeLog(INFO, "Tourney match ".$matchno." was finalized. Updating the bracket.");
	} else {
		writeLog(ERROR, "COMPLETEMATCH failed on 1st query for match ".$matchno);
		writeLog(ERROR, $query);
		writeLog(ERROR, mysqli_error($db));
		return false;
	}

	$query1 = "UPDATE tourney_match_order SET match_p1_uuid = '$winner_uuid' WHERE match_p1_ref = '$winner_string'";
	$query2 = "UPDATE tourney_match_order SET match_p2_uuid = '$winner_uuid' WHERE match_p2_ref = '$winner_string'";
	$query3 = "UPDATE tourney_match_order SET match_p1_uuid = '$loser_uuid' WHERE match_p1_ref = '$loser_string'";
	$query4 = "UPDATE tourney_match_order SET match_p2_uuid = '$loser_uuid' WHERE match_p2_ref = '$loser_string'";

	if (!mysqli_query($db, $query1)){
		writeLog(ERROR, "Failed to update bracket on query 1/4");
		writeLog(ERROR, mysqli_error($db));
		return false;
	}
	if (!mysqli_query($db, $query2)){
		writeLog(ERROR, "Failed to update bracket on query 2/4");
		writeLog(ERROR, mysqli_error($db));
		return false;
	}
	if (!mysqli_query($db, $query3)){
		writeLog(ERROR, "Failed to update bracket on query 3/4");
		writeLog(ERROR, mysqli_error($db));
		return false;
	}
	if (!mysqli_query($db, $query4)){
		writeLog(ERROR, "Failed to update bracket on query 4/4");
		writeLog(ERROR, mysqli_error($db));
		return false;
	}

	svc_refreshMatchStatuses(); //Opens matches that now have both slots filled
	return true;
}

function svc_setSkipFinalMatch($winner){
	global $db;
	$query = "UPDATE tourney_match_order SET match_status = 3, match_winner_uuid = '$winner' WHERE match_is_final = 2";
	if (mysqli_query($db, $query)){
		writeLog(INFO, "Skipping the second grand finals match because it is not needed.");
		return true;
	} else {
		writeLog(ERROR, "Failed to set grand finals match skipped");
		writeLog(ERROR, mysqli_error($db));
		return false;
	}
}

function svc_isTourneyFinished(){
	global $db;
	$query = "SELECT match_id FROM tourney_match_order WHERE match_status < 3";
	if (mysqli_num_rows(mysqli_query($db, $query))>0){
		return false;
	} else {
		return true;
	}
}

function svc_buildBracket($inprounds, $inpmatches){

	$rounds = explode(PHP_EOL, $inprounds);
	$matches = explode(PHP_EOL, $inpmatches);
	return svc_buildBracketByArray($rounds, $matches);

}

/*
Format:
BracketLvl,RoundNo,RoundName
MatchNo,BracketLvl,RoundNo,Player1,Player2,IsFinal
*/
function svc_buildBracketByArray($rounds, $matches){
	global $db;

	//Part 1: populate rounds
	if (!mysqli_query($db, "TRUNCATE TABLE tourney_round_list")){
		writeLog(ERROR, "Round list truncate failed.");
		writeLog(ERROR, mysqli_error($db));
	}
	foreach($rounds as $round){
		$roundarr = explode(",", $round);
		if (count($roundarr)!=3){
			writeLog(ERROR, "Bracket build aborted: Bad syntax on round input: ".$round);
			return "SYNTAX ERROR: ".$round;
		}
		$bracket = $roundarr[0];
		$roundno = $roundarr[1];
		$name = $roundarr[2];
		$query = "INSERT INTO tourney_round_list (round_bracket_level, round_no, round_name) VALUES ('$bracket', '$roundno', '$name')";
		if (!mysqli_query($db, $query)){
			writeLog(ERROR, "Bracket build aborted: Failed to insert a round");
			writeLog(ERROR, $query);
			writeLog(ERROR, mysqli_error($db));
			return "INTERNAL ERROR: Failed to build the bracket due to a server error. Please see the logs.";
		}
	}
	//Part 2: populate matches
	if (!mysqli_query($db, "TRUNCATE TABLE tourney_match_order")){
		writeLog(ERROR, "Match list truncate failed.");
		writeLog(ERROR, mysqli_error($db));
	}
	foreach($matches as $match){
		$matcharr = explode(",", $match);
		if (count($matcharr)!=6){
			writeLog(ERROR, "Bracket build aborted: Bad syntax on match input: ".$match);
			return "SYNTAX ERROR: ".$round;
		}
		$m_order = $matcharr[0];
		$m_bracket = $matcharr[1];
		$m_round = $matcharr[2];
		$m_final = $matcharr[5];
	
		if (strpos($matcharr[3], ":")){ //Is a reference
			$m_player1 = null;
			$m_ref1 = $matcharr[3];
		} else { //Is a username
			$uuid = svc_getIDByUsername($matcharr[3]);
			if (!$uuid){
				writeLog(ERROR, "Bracket build aborted: Unknown gamertag: ".$matcharr[3]);
				return "ERROR: Unknown gamertag: ".$matcharr[3];
			} else {
				$m_player1 = $uuid;
				$m_ref1 = null;
			}
		}

		if (strpos($matcharr[4], ":")){ //Is a reference
			$m_player2 = null;
			$m_ref2 = $matcharr[4];
		} else { //Is a username
			$uuid = svc_getIDByUsername($matcharr[4]);
			if (!$uuid){
				writeLog(ERROR, "Bracket build aborted: Unknown gamertag: ".$matcharr[4]);
				return "ERROR: Unknown gamertag: ".$matcharr[4];
			} else {
				$m_player2 = $uuid;
				$m_ref2 = null;
			}
		}

		$query2 = "INSERT INTO tourney_match_order (match_order, match_bracket_level, match_round_no, match_p1_uuid, match_p1_ref, match_p2_uuid, match_p2_ref, match_is_final) 
		VALUES ('$m_order', '$m_bracket', '$m_round', '$m_player1', '$m_ref1', '$m_player2', '$m_ref2', '$m_final')";

		if (!mysqli_query($db, $query2)){
			writeLog(ERROR, "Bracket build aborted: failed to insert a match");
			writeLog(ERROR, $query2);
			writeLog(ERROR, mysqli_error($db));
			return "INTERNAL ERROR: Failed to build the bracket due to a server error. Please see the logs.";
		}
	}
	writeLog(INFO, "Bracket builder finished successfully.");
	return true;
}

//Automatically generate brackets for elimination tournaments
//doubleElim = boolean
//seedOrder: Higher seed values in the templates get byes in any extra rounds. Players seeded earlier will have more rounds to play, in general.
//Orders: 0=lowest ranked first, 1=highest ranked first, 2=random
//Returns TRUE if the script runs successfully, or a string describing the error if it fails.
function svc_makeEliminationBracket($event_id, $doubleElim, $seedOrder){

	writeLog(INFO, "Starting automatic bracket generation... eventID=".$event_id." doubleElim=".$doubleElim." seedOrder=".$seedOrder);
	global $db;

	$event_query = "SELECT s.uuid, a.user_username, r.rank_current 
	FROM event_user_signup s 
	INNER JOIN user_authentication a ON a.uuid = s.uuid 
	INNER JOIN user_ranking r ON r.uuid = s.uuid 
	WHERE s.event_id = '$event_id'";

	if ($seedOrder==0){
		$event_query .= " ORDER BY r.rank_current ASC";
	} elseif ($seedOrder==1){
		$event_query .= " ORDER BY r.rank_current DESC";
	} else {
		$event_query .= " ORDER BY RAND()";
	}

	$rs = mysqli_query($db, $event_query);
	if (!$rs){
		writeLog(ERROR, "Automatic bracket build aborted on SELECT query.");
		writeLog(ERROR, $event_query);
		writeLog(ERROR, mysqli_error($db));
		return "INTERNAL ERROR: Failed to build the bracket due to a server error. Please see the logs.";
	}
	$numPlayers = mysqli_num_rows($rs);
	if ($numPlayers < 4 or $numPlayers > 32){
		return "ERROR: Generated brackets are available from 4 to 32 players. For an event of this size, you must use Manual Entry.";
	} else {
		writeLog(DEBUG, "Got entrant set for event, numPlayers = ".$numPlayers);
	}

	require_once($_SERVER['DOCUMENT_ROOT']."/script/tourney_bracket_templates.php");
	if ($doubleElim) {
		$roundSet = $round_desc_double[$numPlayers];
		$bracketSeedSet = $seeds_double[$numPlayers];
	} else {
		$roundSet = $round_desc_single[$numPlayers];
		$bracketSeedSet = $seeds_single[$numPlayers];
	}

	writeLog(TRACE, "Round array: ".implode(PHP_EOL, $roundSet));
	writeLog(TRACE, "Empty bracket: ".implode(PHP_EOL, $bracketSeedSet));

	$seedIndex = 1;
	while ($seed = mysqli_fetch_assoc($rs)){
		$search = "S:".$seedIndex.",";
		$replace = $seed['user_username'].",";
		$bracketSeedSet = str_replace($search, $replace, $bracketSeedSet);
		$seedIndex++;
	}

	writeLog(TRACE, "Filled bracket: ".implode(PHP_EOL, $bracketSeedSet));

	return svc_buildBracketByArray($roundSet, $bracketSeedSet);

}

/*
Called when the final match is closed.
Announce the winner in the activity feed, update their tourney win count, and save the bracket to the hall of records.
*/
function svc_endTournament($winner){
	global $db;
	$eventName = svc_getEventDataById(svc_getSetting("MatchMakingEvent"))['event_title'];
	$congrats = "Congratulations to <b>".svc_getUsernameByID($winner)."</b>, winner of <b>".$eventName."</b>!";
	svc_addActivityItem(5, null, $congrats, 0);

	$query = "UPDATE user_ranking SET rank_tourney_wins = rank_tourney_wins + 1 WHERE uuid = '$winner'"; //TODO Update for doubles tourmanents
	if (!mysqli_query($db, $query)){
		writeLog(ERROR, "Failed to update tourney win count");
		writeLog(ERROR, mysqli_error($db));
	}
	if (!svc_saveTournamentToRecords($winner)){
		return false;
	}
	return true;
}

//Winner is either a UUID for singles tournaments or a group ID for doubles tournaments
function svc_saveTournamentToRecords($winner){
	global $db;
	$rules = svc_getSetting("CompMatchRules");
	$mode = svc_getSetting("TourneyBracketStyle");
	$event_id = svc_getSetting("MatchMakingEvent");
	$doubles = svc_getSetting("TourneyDoubles");

	$query1 = "INSERT INTO records_tourney_schedule (event_id, tourney_bracket_style, tourney_is_doubles, tourney_rules, tourney_winner_id) 
	VALUES ('$event_id', '$mode', '$doubles', '$rules', '$winner')";

	$query2 = "INSERT INTO records_tourney_round (round_bracket_level, round_no, round_name) 
	SELECT round_bracket_level, round_no, round_name FROM tourney_round_list";

	$query3 = "UPDATE records_tourney_round SET event_id = '$event_id' WHERE event_id = 0";

	$query4 = "INSERT INTO records_tourney_match (match_order, match_bracket_level, match_round_no, match_p1_uuid, match_p1_ref, match_p2_uuid, match_p2_ref, match_status, match_p1_score, match_p2_score, match_winner_uuid, match_is_final) 
	SELECT match_order, match_bracket_level, match_round_no, match_p1_uuid, match_p1_ref, match_p2_uuid, match_p2_ref, match_status, match_p1_score, match_p2_score, match_winner_uuid, match_is_final FROM tourney_match_order";

	$query5 = "UPDATE records_tourney_match SET event_id = '$event_id' WHERE event_id = 0";

	if (mysqli_query($db, $query1)){
		if (mysqli_query($db, $query2)){
			if (mysqli_query($db, $query3)){
				if (mysqli_query($db, $query4)){
					if (mysqli_query($db, $query5)){
						writeLog(INFO, "saveTournamentToRecords finished successfully.");
						return true;
					} else {
						writeLog(SEVERE, "saveTournamentToRecords failed on query 5");
						writeLog(SEVERE, $query5);
						writeLog(SEVERE, mysqli_error($db));
						return false;
					}
				} else {
					writeLog(SEVERE, "saveTournamentToRecords failed on query 4");
					writeLog(SEVERE, $query4);
					writeLog(SEVERE, mysqli_error($db));
					return false;
				}
			} else {
				writeLog(SEVERE, "saveTournamentToRecords failed on query 3");
				writeLog(SEVERE, $query3);
				writeLog(SEVERE, mysqli_error($db));
				return false;
			}
		} else {
			writeLog(SEVERE, "saveTournamentToRecords failed on query 2");
			writeLog(SEVERE, $query2);
			writeLog(SEVERE, mysqli_error($db));
			return false;
		}
	} else {
		writeLog(SEVERE, "saveTournamentToRecords failed on query 1");
		writeLog(SEVERE, $query1);
		writeLog(SEVERE, mysqli_error($db));
		return false;
	}
}

?>