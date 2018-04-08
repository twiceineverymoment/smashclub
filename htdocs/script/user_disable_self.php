<?php

require_once($_SERVER['DOCUMENT_ROOT']."/service/svc_authentication.php");

if (!isset($_SERVER['HTTP_REFERER']) or strpos($_SERVER['HTTP_REFERER'], "/account")==false){
	writeLog(WARNING, "Script:USER_DISABLE_SELF loaded without expected referral, IP: ".$_SERVER['REMOTE_ADDR']);
	showErrorPage(400);
	die();
}

if ($_SESSION['type']==5){
	showJavascriptAlert("You cannot disable this account.");
	sendRedirect("/account/");
	die();
}

if (svc_setAccountStatus($_SESSION['uuid'], STATUS_DISABLE)){
	showJavascriptAlert("Your account has been disabled. You will now be logged out.");
	writeLog(INFO, "User ".$_SESSION['name']." has disabled their account. An admin will need to be contacted to re-enable it.");
	svc_logOutUser();
	sendRedirect("/");
	die();
} else {
	showErrorPage(500);
	die();
}

?>