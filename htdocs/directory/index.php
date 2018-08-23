<html>
	<head>
		<link rel="stylesheet" href="/resource/dstyle.php" />
		<link rel="shortcut icon" href="/resource/favicon.ico" />
		<title>Members - SmashClub</title>
	</head>
	<body>
	<?php require_once($_SERVER['DOCUMENT_ROOT']."/navigation.php"); ?>
		<div id="banner">
			<img src="/customization/banner.png" class="banner-img" /> 
		</div>

	<?php
	require_once($_SERVER['DOCUMENT_ROOT']."/alertmessage.php");
	$sq = (isset($_GET['q'])) ? $_GET['q'] : "";
	?>

		<div id="main" class="page-content">

		<h1 style="display: inline-block;">Member Directory</h1>

		<form action="/directory/" method="get" style="display: inline-block; float: right;">
			<input type="text" size="30" class="searchbox" name="q" value=<?php echo "\"".$sq."\""; ?> />
			<input type="submit" class="sc-button" value="Search" />
		</form>
		<?php if($_SESSION['type']==0) : ?>
		<h3>Note: Some members' information may not be displayed due to privacy reasons.</h3>
		<?php endif; ?>
		<hr />
		
		<div class="directory-grid">
		<?php

		require_once($_SERVER['DOCUMENT_ROOT']."/service/svc_member_lookup.php");

		function printProfileBlock($username, $main, $firstname, $lastname, $catchphrase, $type, $streak){
			echo "<table class='profile-block'><tr>";
			if ($streak <= (-2 * svc_getSetting("WinningStreakInterval"))){
				echo "<td width='30%' rowspan='2'><img src='/resource/waaah.png' class='character-image' /></td>";
			} else {
				echo "<td width='30%' rowspan='2'><img src='/resource/character/ultimate/".$main.".png' class='character-image' /></td>";
			}
			echo "<td width='70%'><h2><a class='profile-name' href='/profile/?u=".$username."'>".$username."</a></h2></td></tr>";
			echo "<tr><td width='70%'>";
			if ($type==2){
				echo "<h3 style='color: forestgreen'>&#9873; REFEREE</h3>";
			} elseif ($type==3){
				echo "<h3 style='color: gold'>&#10030; OFFICER</h3>";
			} elseif ($type==4){
				echo "<h3 style='color: dodgerblue'>&#10026; ADMIN</h3>";
			}
			if ($_SESSION['type']>0){
				echo "<h3>".$firstname." ".$lastname."</h3></td></tr>";
			} else {
				echo "</td></tr>";
			}
			if (!empty($catchphrase)){
				echo "<tr><td class='catchphrase-cell' colspan='2'><p><i>&quot;".$catchphrase."&quot;</i></p></td></tr>";
			}
			echo "</table>";
		}

		$staffonly = true;
		if (svc_getSetting("GuestEnableFullMemberList")=="1" or $_SESSION['type']>0){
			$staffonly = false;
		}

		if (isset($_GET['q'])){
			$rs = svc_getProfilesByUsername($_GET['q'], $staffonly);
		} else {
			$rs = svc_getProfilesByUsername(null, $staffonly);
		}

		while ($profile = mysqli_fetch_assoc($rs)){
			printProfileBlock($profile['user_username'], $profile['prof_main_character'], $profile['prof_first_name'], $profile['prof_last_name'], $profile['prof_catchphrase'], $profile['user_type'], $profile['rank_consec_games']);
			echo "&nbsp;&nbsp;";
		}

		global $db, $debug;
		if ($debug and !$rs){
			echo "SQL Error!";
			echo mysqli_error($db);
		}

		?>
		</div>
		</div>
	</body>
</html>