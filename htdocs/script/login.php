<?php

require_once($_SERVER['DOCUMENT_ROOT']."/service/svc_authentication.php");

global $debug;
//if ($debug) { echo "calling authenticateuser: u=".$_POST['username'].", p=".$_POST['password']; }

$user = $_POST['username'];
$pass = $_POST['password'];

if (isset($_POST['change'])){ //Password change requested
	if (svc_changePassword($user, $_POST['current'], $_POST['newpass'])){
		svc_logOutUser();
		showJavascriptAlert("You have changed your password. Please log in again using your new password.");
		sendRedirect("/");
		die();
	}
	else {
		showJavascriptAlert("Could not verify your old password. Please try again.");
		sendRedirect("/forms/change_password.php");
		die();
	}
}

if (empty($user) or empty($pass)){
	writeLog(WARNING, "Script:LOGIN loaded without proper context, IP: ".$_SERVER['REMOTE_ADDR']);
	showErrorPage(400);
	die();
}

if (svc_authenticateUser($user, $pass)){
	$status = svc_getAccountStatus($_SESSION['name']);
	writeLog(DEBUG, "getAccountStatus returned ".$status." for user=".$_SESSION['name']);
	if ($status==1){ //User needs password change
		session_start();
		writeLog(INFO, "User ".$_SESSION['name']." has expired password flag. Redirecting to password change form.");
		$_SESSION['expired']=true;
		sendRedirect("/forms/change_password.php");
	}
	elseif ($status==2){ //Account disabled
		showJavascriptAlert("This account is locked or disabled. Please contact your club administrator to regain access.");
		writeLog(ALERT, "Attempted login by disabled account: ".$_SESSION['name'].". Cancelling.");
		svc_logOutUser();
		sendRedirect("/");
	}
	elseif ($status==3){ //Banned
		showJavascriptAlert("This account is banned.");
		writeLog(ALERT, "Attempted login by banned account: ".$_SESSION['name'].". Cancelling.");
		svc_logOutUser();
		sendRedirect("/");
	}
	else { //Successful and active
		sendBack();
	}
}
else {
	echo "<script type='text/javascript'>
	alert('The email and password you entered does not match our records. Please try again.');
	window.history.back();
	</script>";
}

?>