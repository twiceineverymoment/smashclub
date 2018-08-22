<?php

require_once($_SERVER['DOCUMENT_ROOT']."/service/app_properties.php");

//Returns the list of seasons 
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

?>