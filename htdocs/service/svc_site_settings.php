<?php
require_once($_SERVER['DOCUMENT_ROOT']."/service/app_properties.php");

function svc_getSetting($key){
	global $db, $debug;
	$query = "SELECT setting_value FROM site_settings WHERE setting_key = '".$key."';";
	$rs = mysqli_query($db, $query);
	if ($debug and !$rs){
		echo mysqli_error($db);
	}
	$arr = mysqli_fetch_assoc($rs);
	return $arr['setting_value'];
}

function svc_putSetting($key, $value){
	global $db;
	$query = "UPDATE site_settings SET setting_value = '$value' WHERE setting_key = '$key'";
	if (mysqli_query($db, $query)){
		writeLog(INFO, "Site setting [".$key."] changed to ".$value);
		return true;
	}
	else {
		writeLog(SEVERE, "Failed to change site settings table. Check your SQL user ID permissions.");
		writeLog(SEVERE, "Query: ".$query);
		writeLog(SEVERE, "MySQL Error: ".mysqli_error($db));
		return false;
	}
}

function svc_getFirstNameForNavBar($uuid){
	global $db;
	$query = "SELECT prof_first_name FROM user_profile WHERE uuid = '$uuid'";
	$rs = mysqli_query($db, $query);
	return mysqli_fetch_assoc($rs)['prof_first_name'];
}
?>