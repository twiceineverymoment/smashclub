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
						<option value="unknown">(None)</option>
						<option value="bayonetta">Bayonetta</option>
						<option value="bowser">Bowser</option>
						<option value="bowserjr">Bowser Jr.</option>
						<option value="cptfalcon">Capt. Falcon</option>
						<option value="charizard">Charizard</option>
						<option value="cloud">Cloud</option>
						<option value="corrin">Corrin</option>
						<option value="darkpit">Dark Pit</option>
						<option value="diddykong">Diddy Kong</option>
						<option value="donkeykong">Donkey Kong</option>
						<option value="drmario">Dr. Mario</option>
						<option value="duckhunt">Duck Hunt</option>
						<option value="falco">Falco</option>
						<option value="fox">Fox</option>
						<option value="ganondorf">Ganondorf</option>
						<option value="greninja">Greninja</option>
						<option value="iceclimbers">Ice Climbers</option>
						<option value="ike">Ike</option>
						<option value="jigglypuff">Jigglypuff</option>
						<option value="dedede">King Dedede</option>
						<option value="kirby">Kirby</option>
						<option value="link">Link</option>
						<option value="littlemac">Little Mac</option>
						<option value="lucario">Lucario</option>
						<option value="lucas">Lucas</option>
						<option value="lucina">Lucina</option>
						<option value="luigi">Luigi</option>
						<option value="mario">Mario</option>
						<option value="marth">Marth</option>
						<option value="megaman">Mega Man</option>
						<option value="metaknight">Meta Knight</option>
						<option value="mewtwo">Mewtwo</option>
						<option value="gamewatch">Mr.Game &amp; Watch</option>
						<option value="ness">Ness</option>
						<option value="olimar">Olimar</option>
						<option value="pacman">Pac-Man</option>
						<option value="palutena">Palutena</option>
						<option value="peach">Peach</option>
						<!--<option value="pichu">Pichu</option> (Couldn't find a good image)-->
						<option value="pikachu">Pikachu</option>
						<option value="pit">Pit</option>
						<option value="pokemon">Pokemon Trainer</option>
						<option value="rob">R. O. B.</option>
						<option value="robin1">Robin (M)</option>
						<option value="robin2">Robin (F)</option>
						<option value="rosalina">Rosalina</option>
						<option value="roy">Roy</option>
						<option value="ryu">Ryu</option>
						<option value="samus">Samus</option>
						<option value="sheik">Sheik</option>
						<option value="shulk">Shulk</option>
						<option value="snake">Snake</option>
						<option value="sonic">Sonic</option>
						<option value="toonlink">Toon Link</option>
						<option value="villager">Villager</option>
						<option value="wario">Wario</option>
						<option value="wiifit">Wii Fit Trainer</option>
						<option value="wolf">Wolf</option>
						<option value="yoshi">Yoshi</option>
						<option value="zelda">Zelda</option>
						<option value="zerosuit">Zero Suit Samus</option>
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