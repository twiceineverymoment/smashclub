<?php
require_once($_SERVER['DOCUMENT_ROOT']."/service/app_properties.php");
require_once($_SERVER['DOCUMENT_ROOT']."/service/svc_site_settings.php");


function svc_getSeasonPortletData(){
	$currentSeason = svc_getSetting("CurrentSeasonNumber");
	global $db;
	$query = "SELECT * FROM season_data WHERE season_id = '$currentSeason'";
	$rs = mysqli_query($db, $query);

	if (mysqli_num_rows($rs)!=1){
		writeLog(SEVERE, "Season portlet has an error, you may have invalid data configuration.");
		writeLog(SEVERE, "Correct this error ASAP to avoid corrupting your rank records.");
		return false;
	}

	return mysqli_fetch_assoc($rs);
}

function svc_echoSlideshowImages(){
	$directory = $_SERVER['DOCUMENT_ROOT']."/customization/slideshow/";
	$images = glob($directory . "*.{jpg,png}", GLOB_BRACE);
	$first = true;
	foreach($images as $image){
		if ($first){
			$first = false;
			echo "<li class='slide showing'><img src='/customization/slideshow/".basename($image)."' class='slideimage' /></li>";
		} else {
			echo "<li class='slide'><img src='/customization/slideshow/".basename($image)."' class='slideimage' /></li>";
		}
	}
}

?>