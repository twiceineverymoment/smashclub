<?php

require_once($_SERVER['DOCUMENT_ROOT']."/service/svc_member_lookup.php");
require_once($_SERVER['DOCUMENT_ROOT']."/service/svc_authentication.php");

if (!isset($_POST['save'])){
	writeLog(WARNING, "Script:PROFILE_UPDATE loaded without proper context, IP: ".$_SERVER['REMOTE_ADDR']);
	showErrorPage(400);
	die();
}

global $db; //Used for mysql string escaping input sanitization

$un = mysqli_real_escape_string($db, $_POST['username']);
$pn = mysqli_real_escape_string($db, $_POST['id_nnw']);
$px = mysqli_real_escape_string($db, $_POST['id_xbl']);
$pp = mysqli_real_escape_string($db, $_POST['id_psn']);
$ps = mysqli_real_escape_string($db, $_POST['id_stm']);
$po = mysqli_real_escape_string($db, $_POST['id_org']);
$pon = mysqli_real_escape_string($db, $_POST['id_oths']);
$pov = mysqli_real_escape_string($db, $_POST['id_othn']);
$catch = htmlspecialchars(mysqli_real_escape_string($db, $_POST['catchphrase']));
$main = $_POST['main'];
$uuid = $_SESSION['uuid'];

writeLog(TRACE, "ProfileUpdate: id_nnw=".$_POST['id_nnw']." = ".$pn);
writeLog(TRACE, "ProfileUpdate: catch=".$_POST['catchphrase']." = ".$catch);


if (svc_changeProfileDetails($uuid, $main, $catch, $pn, $px, $pp, $ps, $po, $pon, $pov)){
	if (svc_setUsername($uuid, $un)){
		sendRedirect("/profile/?u=".$_SESSION['name']);
	} else {
		showErrorPage(500);
	}
} else {
	showErrorPage(500);
}

?>