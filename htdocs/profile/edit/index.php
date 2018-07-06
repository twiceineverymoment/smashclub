<html>
	<head>
		<link rel="stylesheet" href="/resource/dstyle.php" />
		<link rel="shortcut icon" href="/resource/favicon.ico" />
		<title>Edit Your Profile - SmashClub</title>
	</head>
	<body>
	<?php require_once($_SERVER['DOCUMENT_ROOT']."/alertmessage_wide.php"); ?>
	<?php require_once($_SERVER['DOCUMENT_ROOT']."/service/svc_member_lookup.php"); ?>
	<?php
	if ($_SESSION['type']==0){
		writeLog(2, "Anonymous user attempted to load EDIT PROFILE form");
		showErrorPage(401);
		die();
	}

	$profile = svc_getFullMemberProfile($_SESSION['name']);
	?>

		<div class="page-content">
			<div class="formpage-block">
				<h2>Edit Your Profile Details</h2>
				<form action="/script/profile_update.php" method="post">
					<span>Username/Gamertag:</span>
					<input type="text" name="username" size="30" value=<?php echo "\"".$profile['user_username']."\""; ?>/>
					<span>Who's Your Main?</span>
					<select name="main">
						<option value=<?php echo "\"".$profile['prof_main_character']."\""; ?> selected>Change...</option>
						<option value="unknown">(Unknown)</option>
						<option value="63">Bayonetta</option>
						<option value="14">Bowser</option>
						<option value="58">Bowser Jr.</option>
						<option value="11">Capt. Falcon</option>
						<option value="35">Charizard</option>
						<option value="61">Cloud</option>
						<option value="62">Corrin</option>
						<!--<option value="13a">Daisy</option>-->
						<option value="28a">Dark Pit</option>
						<option value="36">Diddy Kong</option>
						<option value="02">Donkey Kong</option>
						<option value="18">Dr. Mario</option>
						<option value="59">Duck Hunt</option>
						<option value="20">Falco</option>
						<option value="07">Fox</option>
						<option value="23">Ganondorf</option>
						<option value="50">Greninja</option>
						<option value="15">Ice Climbers</option>
						<option value="32">Ike</option>
						<!--<option value="64">Inkling</option>-->
						<option value="34">Ivysaur</option>
						<option value="12">Jigglypuff</option>
						<option value="39">King Dedede</option>
						<option value="06">Kirby</option>
						<option value="03">Link</option>
						<option value="49">Little Mac</option>
						<option value="41">Lucario</option>
						<option value="37">Lucas</option>
						<option value="21a">Lucina</option>
						<option value="09">Luigi</option>
						<option value="01">Mario</option>
						<option value="21">Marth</option>
						<option value="46">Mega Man</option>
						<option value="28">Meta Knight</option>
						<option value="24">Mewtwo</option>
						<option value="51">Mii Brawler</option>
						<option value="52">Mii Swordfighter</option>
						<option value="53">Mii Gunner</option>
						<option value="26">Mr.Game &amp; Watch</option>
						<option value="10">Ness</option>
						<option value="40">Olimar</option>
						<option value="55">Pac-Man</option>
						<option value="54">Palutena</option>
						<option value="13">Peach</option>
						<option value="19">Pichu</option>
						<option value="08">Pikachu</option>
						<option value="28">Pit</option>
						<!--<option value="65">Ridley</option>-->
						<option value="42">R. O. B.</option>
						<option value="56">Robin</option>
						<option value="48">Rosalina &amp; Luma</option>
						<option value="25">Roy</option>
						<option value="60">Ryu</option>
						<option value="04">Samus</option>
						<option value="16">Sheik</option>
						<option value="57">Shulk</option>
						<option value="31">Snake</option>
						<option value="38">Sonic</option>
						<option value="33">Squirtle</option>
						<option value="43">Toon Link</option>
						<option value="45">Villager</option>
						<option value="30">Wario</option>
						<option value="47">Wii Fit Trainer</option>
						<option value="44">Wolf</option>
						<option value="05">Yoshi</option>
						<option value="22">Young Link</option>
						<option value="17">Zelda</option>
						<option value="29">Zero Suit Samus</option>
					</select><br/>
					<span>Nintendo Network ID:</span>
					<input type="text" name="id_nnw" size="30" value=<?php echo "\"".$profile['prof_connect_nintendo']."\""; ?>/>
					<span>Xbox Live Gamertag:</span>
					<input type="text" name="id_xbl" size="30" value=<?php echo "\"".$profile['prof_connect_xbox']."\""; ?>/>
					<span>PSN ID:</span>
					<input type="text" name="id_psn" size="30" value=<?php echo "\"".$profile['prof_connect_psn']."\""; ?>/>
					<span>Steam Profile Name:</span>
					<input type="text" name="id_stm" size="30" value=<?php echo "\"".$profile['prof_connect_steam']."\""; ?>/>
					<span>Origin ID:</span>
					<input type="text" name="id_org" size="30" value=<?php echo "\"".$profile['prof_connect_origin']."\""; ?>/>
					<span>Other ID (Site/type):</span>
					<input type="text" name="id_oths" size="30" value=<?php echo "\"".$profile['prof_connect_other_name']."\""; ?>/>
					<span>Other ID:</span>
					<input type="text" name="id_othn" size="30" value=<?php echo "\"".$profile['prof_connect_other_value']."\""; ?>/>
					<h3>Favorite Quote or Catchphrase</h3>
					<textarea rows="3" name="catchphrase"><?php echo $profile['prof_catchphrase']; ?></textarea>
					<br/>
					<input type="submit" class="sc-button" value="Save Changes" name="save" />
				</form>
			</div>
			<a 
		</div>
	</body>
</html>