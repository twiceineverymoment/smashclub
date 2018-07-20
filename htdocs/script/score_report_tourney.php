<?php

require_once($_SERVER['DOCUMENT_ROOT']."/service/app_properties.php");
require_once($_SERVER['DOCUMENT_ROOT']."/service/svc_tourney_manager.php");
require_once($_SERVER['DOCUMENT_ROOT']."/service/svc_score_report.php");

if ($_SESSION['type']<2){
	writeLog(ALERT, "Script:SCORE_REPORT_TOURNEY requested by unauthorized user, IP: ".$_SERVER['REMOTE_ADDR']);
	showErrorPage(403);
	die();
}

if (empty($_POST['match_no'])){
	writeLog(ALERT, "Script:SCORE_REPORT_TOURNEY loaded without proper context (no match_no value), IP: ".$_SERVER['REMOTE_ADDR']);
	showErrorPage(400);
	die();
}

if (isset($_POST['startmatch'])){
	if (svc_startMatch($_POST['match_no'])){
		sendBack();
	} else {
		showErrorPage(500);
		die();
	}
}

elseif (isset($_POST['update'])){
	if (svc_updateScore($_POST['match_no'], $_POST['score1'], $_POST['score2'])){
		sendBack();
	} else {
		showErrorPage(500);
		die();
	}
}

elseif (isset($_POST['endmatch'])){
	//Op 1: Update the score
	if (!svc_updateScore($_POST['match_no'], $_POST['score1'], $_POST['score2'])){
		showErrorPage(500);
		die();
	}
	//Check for a winner
	if (!isset($_POST['winner'])){
		showJavascriptAlert("Please confirm the winner using the checkboxes next to player names before finalizing a match.");
		sendBack();
		die();
	}
	if ($_POST['winner']==1){
		$winner_id = $_POST['uuid1'];
		$loser_id = $_POST['uuid2'];
	} else {
		$winner_id = $_POST['uuid2'];
		$loser_id = $_POST['uuid1'];
	}
	//Op 2: Update the bracket
	if (!svc_completeMatch($_POST['match_no'], $winner_id, $loser_id)){
		showErrorPage(500);
		die();
	}
	//Op 3: Update rankings
	if (svc_getSetting("EventIsRanked")==1){
		svc_reportSinglesScore($_POST['uuid1'], $_POST['score1'], $_POST['uuid2'], $_POST['score2']);
	} else {
		//Post to activity feed without updating rank
	}
	//Op 4: Check for grand finals match
	writeLog(TRACE, "isFinal: ".$_POST['isfinal'].", winner slot: ".$_POST['winner']);
	if ($_POST['isfinal']==1 AND $_POST['winner']==1){ //The top slot (winners bracket) won the finals, so the second final is not needed
		writeLog(TRACE, "Calling setSkipFinalMatch...");
		if (!svc_setSkipFinalMatch($winner_id)){
			showErrorPage(500);
			die();
		}
	}
	//Op 5: Check if the tournament is over
	if (svc_isTourneyFinished()){
		showJavascriptAlert("The tournament is now over! Results have been saved to the Hall of Records. You may now end the event.");
		if (!svc_endTournament($winner_id)){
			showJavascriptAlert("There was an error finalizing the tournament. Please contact the site administrator as soon as possible.");
			showErrorPage(500);
			die();
		}
	}
	sendBack();
}

elseif (isset($_POST['reopen'])){
	sendBack();
}

else {
	writeLog(ALERT, "Script:SCORE_REPORT_TOURNEY loaded without proper context (no submit method selected), IP: ".$_SERVER['REMOTE_ADDR']);
	showErrorPage(400);
	die();
}

?>