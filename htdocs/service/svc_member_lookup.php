<?php

require_once($_SERVER['DOCUMENT_ROOT']."/service/app_properties.php");

//Returns the SQL result set of all member profiles that match the search criteria.
//If staffonly=1, only returns Organizer profiles.
function svc_getProfilesByUsername($search, $staffonly){

	global $db, $debug;

	$searchquery = "%".$search."%";
	$query = "SELECT p.prof_first_name, p.prof_last_name, p.prof_main_character, p.prof_catchphrase, a.user_username, a.user_type 
	FROM user_profile p 
	INNER JOIN user_authentication a on p.UUID = a.UUID 
	WHERE a.user_locked in (0, 1, 4) ";

	if ($staffonly){
		$query .= " AND 1 < a.user_type < 5";
	} else {
		$query .= " AND a.user_type < 5";
	}

	if ($search != null){
		$query .= " AND (a.user_username LIKE '$searchquery' OR p.prof_first_name LIKE '$searchquery' OR p.prof_last_Name LIKE '$searchquery')";
	}

	$query .= " ORDER BY a.user_username ASC";

	$result = mysqli_query($db, $query);

	if (!$result){
		writeLog(SEVERE, "getProfilesByUsername FAILED with search=".$search.", staffonly=".$staffonly);
		writeLog(SEVERE, "Query: ".$query);
		writeLog(SEVERE, "MySQL Error: ".mysqli_error($db));
	} else {
		writeLog(DEBUG, "getProfilesByUsername called with search=".$search.", staffonly=".$staffonly);
	}

	return $result;

}

//Returns the full SQL associative array of a member profile by their username.
//Returns the string "404" if member is not found in user_authentication.
function svc_getFullMemberProfile($username){
	global $db, $debug;
	$query = "SELECT * FROM user_profile p
	INNER JOIN user_authentication a ON a.uuid = p.uuid
	INNER JOIN user_ranking r ON a.uuid = r.uuid
	WHERE a.user_username = '$username'";

	$result = mysqli_query($db, $query);

	if (!$result and $debug) echo mysqli_error($db);

	if (mysqli_num_rows($result)==1){
		return mysqli_fetch_assoc($result);
	} else {
		return "404";
	}
}

function svc_getMemberInfoByID($uuid){
	global $db, $debug;
	$query = "SELECT * FROM user_profile p
	INNER JOIN user_authentication a ON a.uuid = p.uuid
	INNER JOIN user_ranking r ON a.uuid = r.uuid
	WHERE a.uuid = '$uuid'";

	$result = mysqli_query($db, $query);

	if (!$result and $debug) echo mysqli_error($db);

	if (mysqli_num_rows($result)==1){
		return mysqli_fetch_assoc($result);
	} else {
		return "404";
	}
}

//Returns the image emblem URL based on a member's current and high rank values.
//Returns the placement emblem if high = 0, which means the player hasn't completed placement.
function svc_getEmblemByRank($current, $high){
	$emblem = "placement";
	if ($high>=2200){
		if ($current>=2500){
			$emblem="grandmaster";
		}
		elseif ($current>=2200){
			$emblem="master";
		}
		else {
			$emblem="diamond";
		}
	} else {
		if ($high>=2000){
			$emblem="diamond";
		}
		elseif ($high>=1800){
			$emblem="platinum";
		}
		elseif ($high>=1600){
			$emblem="gold";
		}
		elseif ($high>=1400){
			$emblem="silver";
		}
		elseif ($high>=1200){
			$emblem="bronze";
		}
		elseif ($high>=1000){
			$emblem="A";
		}
		elseif ($high>=800){
			$emblem="B";
		}
		elseif ($high>=600){
			$emblem="C";
		}
		elseif ($high>=400){
			$emblem="D";
		}
		elseif ($high>=1){
			$emblem="E";
		}
	}
	return "'/resource/emblem/".$emblem.".png'";
}

function svc_changeProfileDetails($uuid, $main, $catch, $n, $x, $p, $s, $o, $on, $ov){
	global $db;
	$query = "UPDATE user_profile SET 
	prof_main_character = '$main', 
	prof_catchphrase = '$catch', 
	prof_connect_nintendo = '$n',
	prof_connect_xbox = '$x',
	prof_connect_psn = '$p',
	prof_connect_steam = '$s',
	prof_connect_origin = '$o',
	prof_connect_other_name = '$on',
	prof_connect_other_value = '$ov' 
	WHERE uuid = '$uuid'";

	writeLog(TRACE, "ProfileDetails Query: ".$query);

	if (mysqli_query($db, $query)){
		writeLog(INFO, "User ".$_SESSION['name']." updated profile information");
		return true;
	}
	else {
		writeLog(SEVERE, "changeProfileDetails FAILED with uuid=".$uuid);
		writeLog(SEVERE, "Query: ".$query);
		writeLog(SEVERE, "MySQL Error: ".mysqli_error($db));
	}
}

function svc_changeContactInfo($uuid, $first, $last, $email, $phone, $showeml, $showphn, $emlnot){
	global $db;
	$query = "UPDATE user_profile SET 
	prof_first_name = '$first', 
	prof_last_name = '$last', 
	prof_email_address = '$email',
	prof_phone_number = '$phone',
	prof_show_phone = '$showphn',
	prof_show_email = '$showeml', 
	prof_receive_email = '$emlnot' 
	WHERE uuid = '$uuid'";

	if (mysqli_query($db, $query)){
		writeLog(INFO, "User ".$_SESSION['name']." updated contact information");
		writeLog(TRACE, "Query: ".$query);
		return true;
	}
	else {
		writeLog(SEVERE, "changeContactInfo FAILED with uuid=".$uuid);
		writeLog(SEVERE, "Query: ".$query);
		writeLog(SEVERE, "MySQL Error: ".mysqli_error($db));
	}
}

?>