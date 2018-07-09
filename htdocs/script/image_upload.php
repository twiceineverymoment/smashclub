<?php
require_once($_SERVER['DOCUMENT_ROOT']."/service/svc_site_settings.php");

if ($_SESSION['type']<4){
	writeLog(ALERT, "Script:IMAGE_UPLOAD requested by unauthorized user");
	showErrorPage(401);
	die();
}

$target_dir = $_SERVER['DOCUMENT_ROOT']."/customization/slideshow/";

if (isset($_POST["upload"])) {

$target_file = $target_dir . basename($_FILES["imgUpload"]["name"]);
$ok = true;
$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

$check = getimagesize($_FILES["imgUpload"]["tmp_name"]);
if ($check !== false){
	$ok = true;
} else {
	writeLog(ERROR, "UPLOAD aborted, file is not an image");
	showJavascriptAlert("Please choose an image file.");
	sendBack();
	die();
}

if (file_exists($target_file)){
	writeLog(WARN, "UPLOAD aborted, file already exists: ".$target_file);
	showJavascriptAlert("An image with that name already exists. Please choose a different filename and try again.");
	$ok=false;
}

if ($_FILES["imgUpload"]["size"] > 2000000){
	writeLog(ERROR, "UPLOAD aborted, file is too large.");
	showJavascriptAlert("This file is too large. Please upload images no larger than 2 MB.");
	$ok=false;
}

if ($imageFileType!="jpg" && $imageFileType!="png"){
	writeLog(ERROR, "UPLOAD aborted, invalid file extension");
	showJavascriptAlert("This file type is not allowed. Please upload only JPG or PNG images.");
	$ok=false;
}

if ($ok){
	if (move_uploaded_file($_FILES["imgUpload"]["tmp_name"], $target_file)){
		writeLog(INFO, "Image uploaded: ".$target_file);
		sendBack();
		die();
	} else {
		writeLog(SEVERE, "Image upload failed. See PHP errors.");
		showJavascriptAlert("There was an error uploading the file (500). If this issue persists, please contact the site administrator.");
		showErrorPage(500);
		die();
	}
} else {
	showJavascriptAlert("Your file was not uploaded. Please go back and try again.");
	sendBack();
	die();
}

} elseif (isset($_POST["delete"])) {
	foreach($_POST["files"] as $file){
		if (unlink($target_dir.$file)){
			writeLog(INFO, "Image deleted: ".$target_dir.$file);
		} else {
			writeLog(SEVERE, "Image delete failed. See PHP errors.");
			showJavascriptAlert("There was an error deleting the file (500). If this issue persists, please contact the site administrator.");
			showErrorPage(500);
			die();
		}
	}
	sendBack();
	die();

} else {
	writeLog(WARN, "Script:IMAGE_UPLOAD requested without proper context");
	showErrorPage(400);
	die();
}

?>