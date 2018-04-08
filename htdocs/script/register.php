<?php

require_once($_SERVER['DOCUMENT_ROOT']."/service/svc_authentication.php");
require_once($_SERVER['DOCUMENT_ROOT']."/service/svc_activity_feed.php");
require_once($_SERVER['DOCUMENT_ROOT']."/service/svc_mailer.php");

$u = mysqli_real_escape_string($db, $_POST['username']);
$p = mysqli_real_escape_string($db, $_POST['password']);
$e = $_POST['email'];
$n = $_POST['phone'];
$t = $_POST['type'];
$f = mysqli_real_escape_string($db, $_POST['firstname']);
$l = mysqli_real_escape_string($db, $_POST['lastname']);

$idn = mysqli_real_escape_string($db, $_POST['id_nnw']);
$idx = mysqli_real_escape_string($db, $_POST['id_xbl']);
$idp = mysqli_real_escape_string($db, $_POST['id_psn']);
$ids = mysqli_real_escape_string($db, $_POST['id_stm']);
$ido = mysqli_real_escape_string($db, $_POST['id_org']);
$oid1 = mysqli_real_escape_string($db, $_POST['id_oths']);
$oid2 = mysqli_real_escape_string($db, $_POST['id_othn']);

if (!isset($_POST['agent'])){
	writeLog(WARNING, "Script:REGISTER loaded without proper context, IP: ".$_SERVER['REMOTE_ADDR']);
	showErrorPage(400);
	die();
}

$main = $_POST['main'];
$catch = htmlspecialchars(mysqli_real_escape_string($db, $_POST['catchphrase']));

if (svc_userIDtaken($u)){
	showJavascriptAlert("Sorry, that username is taken!");
	sendBack();
	die();
}

if (svc_emailTaken($e)){
	showJavascriptAlert("An account with that email address already exists. If you have forgotten your password, please contact the club staff.");
	sendBack();
	die();
}

if ($_POST['agent']=="admin"){
	if (svc_createNewUser($u, $p, $t, $e, $n, $f, $l)){
		echo "<script type='text/javascript'>alert('Registration successful!');window.location='/';</script>";
		$welcomemsg = "Welcome <b>".$u."</b> to the club!";
		svc_addActivityItem(6, "", $welcomemsg, null);
	}
	else {
		echo "<script type='text/javascript'>alert('Registration failed. Check the logs for more info.');</script>";
	}
}

else {
	if ($uuid = svc_selfRegisterUser($u, $p, $e, $n, $f, $l, $idn, $idx, $idp, $ids, $ido, $oid1, $oid2, $main, $catch)){
		showJavascriptAlert("Success! Your SmashClub Account has been created. Log in to get started.");
		$welcomemsg = "Welcome <b>".$u."</b> to the club!";
		svc_addActivityItem(6, "", $welcomemsg, null);
		$welcomemail = "Hello ".$u.", Your SmashClub account has been successfully created. This confirmation email lets you know you will receive notifications at this address. Visit the site and log in to start editing your player profile!";
		svc_emailSingleUser($uuid, "Your SmashClub Account Has Been Created", $welcomemail);
		sendRedirect("/");
	}
	else {
		showJavascriptAlert("There was a problem creating your account (Error 500). Please contact the administrator.");
		showErrorPage(500);
	}
}

?>