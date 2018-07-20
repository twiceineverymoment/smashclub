<html>
	<head>
		<link rel="stylesheet" href="/resource/dstyle.php" />
		<link rel="shortcut icon" href="/resource/favicon.ico" />
		<title>Competitor Profile - SmashClub</title>
	</head>
	<body>
	<?php require_once($_SERVER['DOCUMENT_ROOT']."/navigation.php"); ?>
		<div id="banner">
			<img src="/customization/banner.png" class="banner-img" /> 
		</div>
		<?php require_once($_SERVER['DOCUMENT_ROOT']."/alertmessage.php"); ?>
		<div id="main" class="page-content">
		<?php
		require_once($_SERVER['DOCUMENT_ROOT']."/service/svc_member_lookup.php");

		if ($_SESSION['type']==0){
			//Access error
		}
		$profile = svc_getFullMemberProfile($_SESSION['name']);
		$joindate = date_format(new DateTime($profile['date_member_join']), "F Y");
		$pmleft = $profile['rank_placements'];
		$pminit = svc_getSetting("InitialPlacementMatches");
		$imagesrc = "/resource/character/ultimate/".$profile['prof_main_character'].".png";
		if ($profile['rank_consec_games'] <= (-2 * svc_getSetting("WinningStreakInterval"))){
			$imagesrc = "/resource/waaah.png";
		}
		?>

		<h2>Competitor Profile: <?php echo $_SESSION['name']; ?></h2>


		</div>
	</body>
</html>