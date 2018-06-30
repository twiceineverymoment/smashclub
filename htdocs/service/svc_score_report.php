<?php

require_once($_SERVER['DOCUMENT_ROOT']."/service/svc_player_ranks.php");
require_once($_SERVER['DOCUMENT_ROOT']."/service/svc_member_lookup.php");
require_once($_SERVER['DOCUMENT_ROOT']."/service/svc_activity_feed.php");
require_once($_SERVER['DOCUMENT_ROOT']."/service/svc_site_settings.php");

function svc_reportSinglesScore($id1, $score1, $id2, $score2){

		//Call ranking service to get current ranks and placement status
		$p1data = svc_getMemberInfoByID($id1);
		$p2data = svc_getMemberInfoByID($id2);

		//Populate players' current ranking information
		$curr1 = $p1data['rank_current'];
		$curr2 = $p2data['rank_current'];
		$pl1 = $p1data['rank_placements'];
		$pl2 = $p2data['rank_placements'];

		$diff = $score1 - $score2;

		if ($diff>0){ //P1 wins
			$p1add = getWinnerRatingIncrease($curr1, $curr2) * abs($diff);
			$p2sub = getLoserRatingDecrease($curr2, $curr1) * abs($diff);
			if ($pl1>0) $p1add *= 2;
			if ($pl2>0) $p2sub *= 2;
			$new1 = $curr1 + $p1add;
			$new2 = $curr2 - $p2sub;
		}
		elseif ($diff<0){ //P2 wins
			$p1sub = getLoserRatingDecrease($curr1, $curr2) * abs($diff);
			$p2add = getWinnerRatingIncrease($curr2, $curr1) * abs($diff);
			if ($pl1>0) $p1sub *= 2;
			if ($pl2>0) $p2add *= 2;
			$new1 = $curr1 - $p1sub;
			$new2 = $curr2 + $p2add;
		}
		else { //Tie
			$new1 = $curr1;
			$new2 = $curr2;
			//TODO Implement ties
		}

		//Round rankings to the nearest integer
		$new1 = round($new1);
		$new2 = round($new2);

		//Enforce minimum and maximum values
		if ($new1<1) $new1=1;
		if ($new2<1) $new2=1;
		if ($new1>3000) $new1=3000;
		if ($new2>3000) $new2=3000;

		//Record match in logs
		writeLog(INFO, "--------");
		writeLog(INFO, "A match was recorded by ".$_SESSION['name']);
		writeLog(INFO, "Context: FREEPLAY, Type: SINGLES");
		writeLog(INFO, "Player[1]: ".$p1data['user_username'].", Score: ".$score1.", Old rank: ".$curr1.", New rank: ".$new1.", PM Counter: ".$pl1);
		writeLog(INFO, "Player[2]: ".$p2data['user_username'].", Score: ".$score2.", Old rank: ".$curr2.", New rank: ".$new2.", PM Counter: ".$pl2);
		writeLog(INFO, "--------");

		//Perform database update
		if ($score1 > 0 or $score2 > 0){
			if (!svc_updateRank($id1, $new1)){
				return false;
			}
			if (!svc_updateRank($id2, $new2)){
				return false;
			}
		}

		$infotext = $p1data['user_username']." <h3 style=\'display: inline-block\'>".$score1."</h3><br/>".$p2data['user_username']." <h3 style=\'display: inline-block\'>".$score2."</h3>";

		svc_addActivityItem(1, null, $infotext, $_SESSION['uuid']);

		//Check for a new career high tier
		if ($new1 > $p1data['rank_career_high'] && svc_isNewCareerHighTier($new1, $p1data['rank_career_high']) && $pl1 <= 1){
			svc_addActivityItem(5, null, 
				"<b>".$p1data['user_username']."</b> has reached the <b>".svc_getTierName(svc_getTierCodeByRank($new1))."</b> tier for the first time! Congrats!"
				, null);
		}
		if ($new2 > $p2data['rank_career_high'] && svc_isNewCareerHighTier($new2, $p2data['rank_career_high']) && $pl2 <= 1){
			svc_addActivityItem(5, null, 
				"<b>".$p2data['user_username']."</b> has reached the <b>".svc_getTierName(svc_getTierCodeByRank($new2))."</b> tier for the first time! Congrats!"
				, null);
		}

		return true;
}

function svc_reportDoublesScore($id11, $id12, $score1, $id21, $id22, $score2){
	//Call ranking service to get current ranks and placement status
		$p11data = svc_getMemberInfoByID($id11);
		$p12data = svc_getMemberInfoByID($id12);
		$p21data = svc_getMemberInfoByID($id21);
		$p22data = svc_getMemberInfoByID($id22);

		//Populate players' current ranking information
		$curr11 = $p11data['rank_current'];
		$curr12 = $p12data['rank_current'];
		$pl11 = $p11data['rank_placements'];
		$pl12 = $p12data['rank_placements'];
		$curr21 = $p21data['rank_current'];
		$curr22 = $p22data['rank_current'];
		$pl21 = $p21data['rank_placements'];
		$pl22 = $p22data['rank_placements'];

		$diff = $score1 - $score2;

		$avg1 = ($curr11 + $curr12) / 2.0;
		$avg2 = ($curr21 + $curr22) / 2.0;

		if ($diff>0){ //Team 1 wins
			$p11add = getTeamWinnerRatingIncrease($curr11, $curr12, $avg2) * abs($diff);
			$p12add = getTeamWinnerRatingIncrease($curr12, $curr11, $avg2) * abs($diff);
			$p21sub = getTeamLoserRatingDecrease($curr21, $curr22, $avg1) * abs($diff);
			$p22sub = getTeamLoserRatingDecrease($curr22, $curr21, $avg1) * abs($diff);
			if ($pl11>0) $p11add *= 2;
			if ($pl12>0) $p12add *= 2;
			if ($pl21>0) $p21sub *= 2;
			if ($pl22>0) $p22sub *= 2;
			$new11 = $curr11 + $p11add;
			$new12 = $curr12 + $p12add;
			$new21 = $curr21 - $p21sub;
			$new22 = $curr22 - $p22sub;
		}
		elseif ($diff<0){ //Team 2 wins
			$p21add = getTeamWinnerRatingIncrease($curr21, $curr22, $avg1) * abs($diff);
			$p22add = getTeamWinnerRatingIncrease($curr22, $curr21, $avg1) * abs($diff);
			$p11sub = getTeamLoserRatingDecrease($curr11, $curr12, $avg2) * abs($diff);
			$p12sub = getTeamLoserRatingDecrease($curr12, $curr11, $avg2) * abs($diff);
			if ($pl11>0) $p11sub *= 2;
			if ($pl12>0) $p12sub *= 2;
			if ($pl21>0) $p21add *= 2;
			if ($pl22>0) $p22add *= 2;
			$new11 = $curr11 - $p11sub;
			$new12 = $curr12 - $p12sub;
			$new21 = $curr21 + $p21add;
			$new22 = $curr22 + $p22add;
		}
		else { //Tie
			$new11 = $curr11;
			$new12 = $curr12;
			$new21 = $curr21;
			$new22 = $curr22;
			//TODO: Implement ties
		}

		//Round rankings to the nearest integer
		$new11 = round($new11);
		$new12 = round($new12);
		$new21 = round($new21);
		$new22 = round($new22);

		//Enforce minimum and maximum values
		if ($new11<1) $new11=1;
		if ($new12<1) $new12=1;
		if ($new11>3000) $new11=3000;
		if ($new12>3000) $new12=3000;
		if ($new21<1) $new21=1;
		if ($new22<1) $new22=1;
		if ($new21>3000) $new21=3000;
		if ($new22>3000) $new22=3000;

		//Record match in logs
		writeLog(INFO, "--------");
		writeLog(INFO, "A match was recorded by ".$_SESSION['name']);
		writeLog(INFO, "Context: FREEPLAY, Type: DOUBLES");
		writeLog(INFO, "Player[1/1]: ".$p11data['user_username'].", Score: ".$score1.", Old rank: ".$curr11.", New rank: ".$new11.", PM Counter: ".$pl11);
		writeLog(INFO, "Player[1/2]: ".$p12data['user_username'].", Score: ".$score1.", Old rank: ".$curr12.", New rank: ".$new12.", PM Counter: ".$pl12);
		writeLog(INFO, "Player[2/1]: ".$p21data['user_username'].", Score: ".$score2.", Old rank: ".$curr21.", New rank: ".$new21.", PM Counter: ".$pl21);
		writeLog(INFO, "Player[2/2]: ".$p22data['user_username'].", Score: ".$score2.", Old rank: ".$curr22.", New rank: ".$new22.", PM Counter: ".$pl22);
		writeLog(INFO, "--------");

		//Perform database update
		if ($score1 > 0 or $score2 > 0){
		if (!svc_updateRank($id11, $new11)){
			return false;
		}
		if (!svc_updateRank($id12, $new12)){
			return false;
		}
		if (!svc_updateRank($id21, $new21)){
			return false;
		}
		if (!svc_updateRank($id22, $new22)){
			return false;
		}
		}

		$infotext = $p11data['user_username']." & ".$p12data['user_username']." <h3 style=\'display: inline-block\'>".$score1."</h3><br/>".$p21data['user_username']." & ".$p22data['user_username']." <h3 style=\'display: inline-block\'>".$score2."</h3>";
		svc_addActivityItem(1, null, $infotext, $_SESSION['uuid']);

		if ($new11 > $p11data['rank_career_high'] && svc_isNewCareerHighTier($new11, $p11data['rank_career_high']) && $pl11 <= 1){
			svc_addActivityItem(5, null, 
				"<b>".$p11data['user_username']."</b> has reached the <b>".svc_getTierName(svc_getTierCodeByRank($new11))."</b> tier for the first time! Congrats!"
				, null);
		}
		if ($new12 > $p12data['rank_career_high'] && svc_isNewCareerHighTier($new12, $p12data['rank_career_high']) && $pl12 <= 1){
			svc_addActivityItem(5, null, 
				"<b>".$p12data['user_username']."</b> has reached the <b>".svc_getTierName(svc_getTierCodeByRank($new12))."</b> tier for the first time! Congrats!"
				, null);
		}
		if ($new21 > $p21data['rank_career_high'] && svc_isNewCareerHighTier($new21, $p21data['rank_career_high']) && $pl21 <= 1){
			svc_addActivityItem(5, null, 
				"<b>".$p21data['user_username']."</b> has reached the <b>".svc_getTierName(svc_getTierCodeByRank($new21))."</b> tier for the first time! Congrats!"
				, null);
		}
		if ($new12 > $p22data['rank_career_high'] && svc_isNewCareerHighTier($new22, $p22data['rank_career_high']) && $pl22 <= 1){
			svc_addActivityItem(5, null, 
				"<b>".$p22data['user_username']."</b> has reached the <b>".svc_getTierName(svc_getTierCodeByRank($new22))."</b> tier for the first time! Congrats!"
				, null);
		}

		return true;
}

function getWinnerRatingIncrease($win, $opp){
	$yield = (50 + (($opp-$win)/12.0));
	if ($yield <= 0) $yield = 1;
	return $yield;
}

function getLoserRatingDecrease($los, $opp){
	$yield = (50 + (($los-$opp)/12.0));
	if ($yield <= 0) $yield = 1;
	return $yield;
}

function getTeamWinnerRatingIncrease($curr, $team, $opp){
	$diff = $opp - $curr;
	$yield = (50 + ($diff / 12.0));
	if ($yield <= 0) $yield = 1;
	return $yield;
}

function getTeamLoserRatingDecrease($curr, $team, $opp){
	$diff = $curr - $opp;
	$yield = (50 + ($diff / 12.0));
	if ($yield <= 0) $yield = 1;
	return $yield;
}

?>