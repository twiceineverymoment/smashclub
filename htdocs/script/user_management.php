<?php

require_once($_SERVER['DOCUMENT_ROOT']."/service/svc_authentication.php");

if ($_SESSION['type']<3){
	writeLog(ALERT, "Script:USER_MANAGEMENT requested by unauthorized user, IP: ".$_SERVER['REMOTE_ADDR']);
	showErrorPage(403);
	die();
}

if (isset($_POST['acctmgmt'])){

	$action = $_POST['action'];
	$uuid = $_POST['account'];

	if ($action==0){
		if (svc_getAccountStatusByID($uuid)<2){
			showJavascriptAlert("This account is already active. No changes were made.");
			sendRedirect("/adminpanel/");
		} else {
			if (svc_setAccountStatus($uuid, STATUS_ENABLE)){
				showJavascriptAlert("Account enabled. This user can now log in using their existing password.");
				sendRedirect("/adminpanel/");
			} else {
				showErrorPage(500);
			}
		}
	}
	elseif ($action==1){
		if (svc_compareUserAccess($_SESSION['uuid'], $uuid)==1){
			$genpw = svc_resetUserPassword($uuid);
			if (!$genpw){
				showErrorPage(500);
			}
			else {
				showJavascriptAlert("Password was reset. TEMPORARY PASSWORD: ".$genpw." . Write this down and give it to the account owner. User will be required to change their password on next login.");
				sendRedirect("/adminpanel/");
			}
		} else {
			showJavascriptAlert("You can only reset passwords for users with lower account rights than you. To reset an admin password, use the master account.");
			sendRedirect("/adminpanel/");
		}
	}
	elseif ($action==2){
		if (svc_changeUserRights($uuid, 2)){
			showJavascriptAlert("Account type changed to Referee.");
			sendRedirect("/adminpanel/");
		} else {
			showErrorPage(500);
		}
	}
	elseif ($action==3){
		if (svc_changeUserRights($uuid, 3)){
			showJavascriptAlert("Account type changed to Officer.");
			sendRedirect("/adminpanel/");
		} else {
			showErrorPage(500);
		}
	}
	elseif ($action==4){
		if (svc_changeUserRights($uuid, 4)){
			showJavascriptAlert("Account type changed to Admin.");
			sendRedirect("/adminpanel/");
		} else {
			showErrorPage(500);
		}
	}
	elseif ($action==5){
		if (svc_compareUserAccess($_SESSION['uuid'], $uuid)==1){
			if (svc_changeUserRights($uuid, 1)){
				showJavascriptAlert("Account type changed to Standard Member.");
				sendRedirect("/adminpanel/");
			} else {
				showErrorPage(500);
			}
		} else {
			showJavascriptAlert("You can only demote members with lower rights than you. To demote admins, you must use the master account.");
			sendRedirect("/adminpanel/");
		}
	}
	elseif ($action==6){
		if (svc_compareUserAccess($_SESSION['uuid'], $uuid)==1){
			if (svc_setAccountStatus($uuid, STATUS_DISABLE)){
				showJavascriptAlert("Account disabled. It will not be able to log in or participate in matches, and will not appear in lists.");
				sendRedirect("/adminpanel/");
			} else {
				showErrorPage(500);
			}
		} else {
			showJavascriptAlert("You can only disable members with lower rights than you. To change admins, you must use the master account.");
			sendRedirect("/adminpanel/");
		}
	}
	elseif ($action==7){
		if (svc_compareUserAccess($_SESSION['uuid'], $uuid)==1){
			if (svc_setAccountStatus($uuid, STATUS_BAN)){
				showJavascriptAlert("Account banned. It will not be able to log in or participate in matches, and will not appear in lists. To unban the account, select it again and choose 'Enable'.");
				sendRedirect("/adminpanel/");
			} else {
				showErrorPage(500);
			}
		} else {
			showJavascriptAlert("You can only ban members with lower rights than you. To change admins, you must use the master account.");
			sendRedirect("/adminpanel/");
		}
	}
	elseif ($action==8){
		if (svc_compareUserAccess($_SESSION['uuid'], $uuid)==1){
			if (svc_deleteUser($uuid)){
				showJavascriptAlert("Account deleted. Note that the account may still appear in records.");
				sendRedirect("/adminpanel/");
			} else {
				showErrorPage(500);
			}
		} else {
			showJavascriptAlert("You can only delete members with lower rights than you. To change admins, you must use the master account.");
			sendRedirect("/adminpanel/");
		}
	}
}
else {
	writeLog(WARNING, "Script:USER_MANAGEMENT loaded without proper context, IP: ".$_SERVER['REMOTE_ADDR']);
	showErrorPage(400);
	die();
}

?>