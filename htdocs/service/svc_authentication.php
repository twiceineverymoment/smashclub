<?php
require_once($_SERVER['DOCUMENT_ROOT']."/service/app_properties.php");
require_once($_SERVER['DOCUMENT_ROOT']."/service/svc_site_settings.php");

//Authenticate a userid/password.
//If successful, returns true and sets the session variables.
//If unsuccessful, returns false and does nothing else.
function svc_authenticateUser($username, $password){
	global $db, $debug;
	$query = "SELECT a.*, p.prof_email_address FROM user_authentication a 
	INNER JOIN user_profile p ON p.uuid = a.uuid 
	WHERE p.prof_email_address = '".$username."';"; //Changed to use e-mail login
	$rs = mysqli_query($db, $query);
	if (mysqli_num_rows($rs)!=1){
		if ($debug){ echo "Username not found / "; echo mysqli_num_rows($rs)." / "; echo $query; }
		writeLog(ALERT, "Login failed for user ".$username." from ".$_SERVER['REMOTE_ADDR']." (email address not found)");
		return false; //0 rows (username not found), or more than 1 row (duplicate usernames - this should never happen)
	}
	else {
		$row = mysqli_fetch_assoc($rs);
	}

	if (password_verify($password, $row['user_password_hash'])){
		session_start();
		$_SESSION['uuid'] = $row['UUID'];
		$_SESSION['type'] = $row['user_type'];
		$_SESSION['name'] = $row['user_username'];
		writeLog(DEBUG, "Authentication successful: email=".$username.", type=".$_SESSION['type'].", uuid=".$_SESSION['uuid'].", username=".$_SESSION['name']);
		writeLog(INFO, $row['user_username']." logged in from IP address ".$_SERVER['REMOTE_ADDR']);
		return true;
	}
	else {
		if ($debug){ echo "Password verify failed"; }
		writeLog(ALERT, "Login failed for user ".$username." from ".$_SERVER['REMOTE_ADDR']." (invalid password)");
		return false;
	}
}

//Log out the active user and clear session variables back to their default values.
function svc_logOutUser(){
	session_start();
	writeLog(INFO, $_SESSION['name']." logged out");
	unset($_SESSION['uuid']);
	unset($_SESSION['name']);
	unset($_SESSION['expired']);
	$_SESSION['type'] = 0;
}

//Returns the hash value of the default root password. FOR TESTING PURPOSES ONLY-- DO NOT USE THIS AS YOUR ROOT PASSWORD
function getDefaultPasswordHash(){
	return password_hash("password", PASSWORD_DEFAULT);
}

function svc_createNewUser($username, $password, $type, $email, $phone, $firstname, $lastname){

	global $db, $debug;
	$hash = password_hash($password, PASSWORD_DEFAULT);

	$auth_query = "INSERT INTO user_authentication (`user_username`, `user_password_hash`, `user_type`, `user_locked`) VALUES ('$username', '$hash', '$type', 0);";
	if (!mysqli_query($db, $auth_query)){
		writeLog(ERROR, "Registration (admin) failed on 1st query, nothing will be inserted.");
		writeLog(ERROR, mysqli_error($db));
		return false;
	}

	$profile_query = "INSERT INTO user_profile (`prof_first_name`, `prof_last_name`, `prof_email_address`, `prof_phone_number`) VALUES ('$firstname', '$lastname', '$email', '$phone');";
	if (!mysqli_query($db, $profile_query)){
		writeLog(SEVERE, "Registration (admin) failed on 2nd query, inserting default rows to prevent database corruption.");
		writeLog(SEVERE, mysqli_error($db));
		mysqli_query($db, "INSERT INTO user_profile VALUES ()");
		mysqli_query($db, "INSERT INTO user_ranking VALUES ()");
		return false;
	}

	$rank_query = "INSERT INTO user_ranking (`rank_current`, `rank_season_high`, `rank_career_high`, `rank_placements`) VALUES (1200, 0, 0, 4);";
	if (!mysqli_query($db, $rank_query)){
		writeLog(SEVERE, "Registration (admin) failed on 3rd query, inserting default rows to prevent database corruption.");
		writeLog(SEVERE, mysqli_error($db));
		mysqli_query($db, "INSERT INTO user_ranking VALUES ()");
		return false;
	}

	writeLog(3, "Admin registered new user ".$username." with user_type = ".$type);
	return true;

}

function svc_selfRegisterUser($username, $password, $email, $phone, $firstname, $lastname, $nintendo, $xbox, $psn, $steam, $origin, $othersite, $otherid, $main, $catchphrase){
	global $db, $debug;
	$hash = password_hash($password, PASSWORD_DEFAULT);
	$initplacement = svc_getSetting("InitialPlacementMatches");
	$auth_query = "INSERT INTO user_authentication (`user_username`, `user_password_hash`, `user_type`, `user_locked`) VALUES ('$username', '$hash', 1, 0);";
	if (!mysqli_query($db, $auth_query)){
		writeLog(SEVERE, "Registration (self) failed on 1st query, nothing will be inserted.");
		writeLog(SEVERE, mysqli_error($db));
		return false;
	} else {
		$newuuid = mysqli_insert_id($db);
	}

	$profile_query = "INSERT INTO user_profile (`prof_first_name`, `prof_last_name`, `prof_email_address`, `prof_phone_number`, `prof_connect_xbox`, `prof_connect_psn`, `prof_connect_nintendo`, `prof_connect_steam`, `prof_connect_origin`, `prof_connect_other_name`, `prof_connect_other_value`, `prof_main_character`, `prof_catchphrase`) VALUES ('$firstname', '$lastname', '$email', '$phone', '$xbox', '$psn', '$nintendo', '$steam', '$origin', '$othersite', '$otherid', '$main', '$catchphrase');";
	if (!mysqli_query($db, $profile_query)){
		writeLog(SEVERE, "Registration (self) failed on 2nd query, inserting default rows to prevent database corruption.");
		writeLog(SEVERE, mysqli_error($db));
		mysqli_query($db, "INSERT INTO user_profile VALUES ()");
		mysqli_query($db, "INSERT INTO user_ranking VALUES ()");
		return false;
	}
	$rank_query = "INSERT INTO user_ranking (`rank_current`, `rank_season_high`, `rank_career_high`, `rank_placements`, `date_member_join`) VALUES (1200, 0, 0, '$initplacement', NOW());";
	if (!mysqli_query($db, $rank_query)){
		writeLog(SEVERE, "Registration (admin) failed on 3rd query, inserting default rows to prevent database corruption.");
		writeLog(SEVERE, mysqli_error($db));
		mysqli_query($db, "INSERT INTO user_ranking VALUES ()");
		return false;
	}

	writeLog(INFO, "New user ".$username." self-registered successfully, UUID = ".$newuuid);
	return $newuuid;
}

function svc_getRandomPassword($length) {
    $characters = '123456789abcdefghijkmnpqrstuvwxyzABCDEFGHJKLMNPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function svc_getAccountStatus($username){
	global $db;
	$query = "SELECT user_locked FROM user_authentication WHERE user_username = '$username'";
	return mysqli_fetch_assoc(mysqli_query($db, $query))['user_locked'];
}

function svc_getAccountStatusByID($uuid){
	global $db;
	$query = "SELECT user_locked FROM user_authentication WHERE uuid = '$uuid'";
	return mysqli_fetch_assoc(mysqli_query($db, $query))['user_locked'];
}

function svc_changePassword($username, $oldpassword, $newpassword){
	global $db;

	$checkquery = "SELECT user_password_hash FROM user_authentication WHERE user_username = '$username'";
	$oldhash = mysqli_fetch_assoc(mysqli_query($db, $checkquery))['user_password_hash'];
	if (!password_verify($oldpassword, $oldhash)){
		writeLog(WARNING, "changePassword failed because old password was not valid.");
		return false;
	}

	$pass = password_hash($newpassword, PASSWORD_DEFAULT);
	$query = "UPDATE user_authentication SET user_locked = 0, user_password_hash = '$pass' WHERE user_username = '$username'";
	if (mysqli_query($db, $query)){
		writeLog(INFO, "User ".$username." successfully changed their password");
		return true;
	}
	else {
		writeLog(SEVERE, "Password change failed! Password input is not shown for security reasons.");
		writeLog(SEVERE, "Query: ".$query);
		writeLog(SEVERE, "MySQL Error: ".mysqli_error($db));
		return false;
	}
}

function svc_changeUserRights($uuid, $level){
	global $db;
	$query = "UPDATE user_authentication SET user_type = '$level' WHERE uuid = '$uuid'";
	if (mysqli_query($db, $query)){
		writeLog(3, "User ID ".$uuid." was changed to account type ".$level." by ".$_SESSION['name']);
		return true;
	}
	else {
		writeLog(SEVERE, "changeUserRights failed!");
		writeLog(SEVERE, "Query: ".$query);
		writeLog(SEVERE, "MySQL Error: ".mysqli_error($db));
		return false;
	}
}

function svc_compareUserAccess($user, $target){
	writeLog(TRACE, "Entering compareUserAccess, user1=".$user.", user2=".$target);
	global $db;
	$query = "SELECT uuid, user_type FROM user_authentication";
	$rs = mysqli_query($db, $query);

	while ($row = mysqli_fetch_assoc($rs)){
		if ($row['uuid']==$user){
			$type1 = $row['user_type'];
		}
		if ($row['uuid']==$target){
			$type2 = $row['user_type'];
		}
	}

	writeLog(TRACE, "Running compareUserAccess, type1=".$type1.", type2=".$type2);

	if ($type1>$type2){
		return 1;
	}
	elseif ($type1=$type2){
		return 0;
	} else {
		return -1;
	}
}

function svc_resetUserPassword($uuid){
	global $db;
	$gen = svc_getRandomPassword(10);
	$pass = password_hash($gen, PASSWORD_DEFAULT);
	$query = "UPDATE user_authentication SET user_password_hash = '$pass', user_locked = 1 WHERE uuid = '$uuid'";
	if (mysqli_query($db, $query)){
		writeLog(ALERT, "User ID ".$uuid." password was reset using a temporary password. ".$_SESSION['name']." requested the reset and was shown the new password.");
		return $gen;
	}
	else {
		writeLog(SEVERE, "Password reset failed. Data will not be shown for security reasons.");
		return false;
	}
}

const STATUS_ENABLE = 0;
const STATUS_DISABLE = 2;
const STATUS_BAN = 3;
const STATUS_LOCKOUT = 4;

function svc_setAccountStatus($uuid, $status){
	global $db;
	$query = "UPDATE user_authentication SET user_locked = '$status' WHERE uuid = '$uuid'";
	$names = array("ACTIVE", "PASSWORD_EXPIRED", "DISABLED", "BANNED", "LOCKED");
	if (mysqli_query($db, $query)){
		writeLog(INFO, "User ID ".$uuid." was changed to account status: ".$names[$status]);
		return true;
	}
	else {
		writeLog(SEVERE, "setAccountStatus failed!");
		writeLog(SEVERE, "Query: ".$query);
		writeLog(SEVERE, "MySQL Error: ".mysqli_error($db));
		return false;
	}
}

function svc_getAllAccountsHTML(){
	global $db;
	$query = "SELECT uuid, user_username, user_locked FROM user_authentication WHERE user_type < 5 ORDER BY user_username ASC";

	$rs = mysqli_query($db, $query);

	while ($ent = mysqli_fetch_assoc($rs)){
		$tag="";
		switch($ent['user_locked']){
			case 2:
			$tag="(Disabled)";
			break;
			case 3:
			$tag="(Banned)";
			break;
		}
		echo "<option value='".$ent['uuid']."'>".$ent['user_username']." ".$tag."</option>";
	}
}

function svc_deleteUser($uuid){
	global $db;
	$query1 = "DELETE FROM user_authentication WHERE uuid='$uuid'";
	$query2 = "DELETE FROM user_profile WHERE uuid='$uuid'";
	$query3 = "DELETE FROM user_ranking WHERE uuid='$uuid'";

	if (!mysqli_query($db, $query1)){
		writeLog(SEVERE, "deleteUser failed on 1st query");
		writeLog(SEVERE, "Query: ".$query1);
		writeLog(SEVERE, "MySQL Error: ".mysqli_error($db));
		return false;
	}
	if (!mysqli_query($db, $query2)){
		writeLog(SEVERE, "deleteUser failed on 2nd query");
		writeLog(SEVERE, "Query: ".$query2);
		writeLog(SEVERE, "MySQL Error: ".mysqli_error($db));
		return false;
	}
	if (!mysqli_query($db, $query3)){
		writeLog(SEVERE, "deleteUser failed on 3rd query");
		writeLog(SEVERE, "Query: ".$query3);
		writeLog(SEVERE, "MySQL Error: ".mysqli_error($db));
		return false;
	}

	writeLog(ALERT, "User account ID ".$uuid." was DELETED by ".$_SESSION['name']);
	return true;
}

function svc_userIDTaken($username){
	global $db;
	$query = "SELECT user_username FROM user_authentication";
	$rs = mysqli_query($db, $query);
	while ($row = mysqli_fetch_assoc($rs)){
		if (strtolower($row['user_username'])==strtolower($username)){
			return true;
		}
	}
	return false;
}

function svc_getUsernameByID($uuid){
	global $db;
	$query = "SELECT user_username FROM user_authentication WHERE uuid = '$uuid'";
	return mysqli_fetch_assoc(mysqli_query($db, $query))['user_username'];
}

function svc_getIDByUsername($username){
	global $db;
	$query = "SELECT uuid FROM user_authentication WHERE user_username = '$username'";
	$rs = mysqli_query($db, $query);
	if(mysqli_num_rows($rs)!=1){
		return false;
	} else {
		return mysqli_fetch_assoc($rs)['uuid'];
	}
}

function svc_emailTaken($email){
	global $db;
	$query = "SELECT prof_email_address FROM user_profile";
	$rs = mysqli_query($db, $query);
	while ($row = mysqli_fetch_assoc($rs)){
		if (strtolower($row['prof_email_address'])==strtolower($email)){
			return true;
		}
	}
	return false;
}

function svc_setUsername($uuid, $username){
	global $db;
	$current = $_SESSION['name'];
	if ($current == $username){
		writeLog(DEBUG, "Cancelling setUsername as there was no change");
		return true;
	}
	$query = "UPDATE user_authentication SET user_username = '$username' WHERE uuid = '$uuid'";
	if (mysqli_query($db, $query)){
		writeLog(INFO, $current." changed their username to ".$username." - logging out to apply the change");
		showJavascriptAlert("You have changed your gamertag. For this change to take effect, you must log in again.");
		svc_logOutUser();
		sendRedirect("/");
		die();
	} else {
		writeLog(SEVERE, "setUsername FAILED");
		writeLog(SEVERE, $query);
		writeLog(SEVERE, mysqli_error($db));
		return false;
	}
}

require_once($_SERVER['DOCUMENT_ROOT']."/service/svc_mailer.php");

function svc_selfResetPassword($username, $email){
	global $db;
	$username = mysqli_real_escape_string($db, $username);
	$email = mysqli_real_escape_string($db, $email);

	$checkquery = "SELECT a.uuid FROM user_authentication a INNER JOIN user_profile p ON p.uuid = a.uuid
	WHERE p.prof_email_address = '$email' AND a.user_username = '$username' AND user_locked IN (0, 1)";
	$rs = mysqli_query($db, $checkquery);

	if(mysqli_num_rows($rs)!=1){
		writeLog(ALERT, "Password reset rejected for username ".$username.", email ".$email." - not found in database");
		return;
	} else {
		$uuid = mysqli_fetch_assoc($rs)['uuid'];
		$passwd = svc_resetUserPassword($uuid);
		if (!$passwd) return; //Don't show 500 error if this fails
		$subject = "Temporary SmashClub Password";
		$body = "You requested a password reset on SmashClub. Your temporary password: \n".$passwd.
		"\nYou will be required to change to a new password the next time you log in.\n
		IF YOU DID NOT REQUEST THIS CHANGE, CONTACT THE CLUB STAFF IMMEDIATELY.";
		svc_emailSingleUser($uuid, $subject, $body);
		writeLog(ALERT, "Self password reset performed for user ".$username);
		return;
	}
}

?>