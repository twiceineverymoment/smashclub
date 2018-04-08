<html>
	<head>
		<link rel="stylesheet" href="/resource/dstyle.php" />
		<link rel="shortcut icon" href="/resource/favicon.ico" />
		<title>SmashClub</title>
	</head>
	<body>
	<?php require_once($_SERVER['DOCUMENT_ROOT']."/alertmessage_wide.php"); ?>
	<?php require_once($_SERVER['DOCUMENT_ROOT']."/service/svc_match_manager.php"); ?>
	<?php require_once($_SERVER['DOCUMENT_ROOT']."/service/svc_site_settings.php"); ?>
	<?php
	if ($_SESSION['type']<3){
		writeLog(ALERT, "Form:START_GAME_FREEPLAY requested by unauthorized user, IP: ".$_SERVER['REMOTE_ADDR']);
		showErrorPage(403);
		die();
	}

	if (isset($_POST['start'])){
		if ($_POST['ranked']==1 and svc_getSetting("CurrentSeasonNumber")==0){
			showJavascriptAlert("You cannot play ranked during the off-season. Please start a season or select Casual mode.");
		} else {
			if (svc_startFreePlayEvent($_POST['ranked'])){
				sendRedirect("/scoring");
				die();
			} else {
				showErrorPage(500);
				die();
			}
		}
	}
	?>

		<div class="page-content">
			<div class="formpage-block">
				<h2>Free Play</h2>
				<form action="/forms/start_game_freeplay.php" method="post">
					<p>Free Play does not use an event guest list. Matchmaking will use the entire club roster (excluding banned or disabled accounts) to select from.</p>
					<h3>Select Play Mode:</h3>
					<hr />
					<input type="radio" name="ranked" value="1" required/>
					<span><b>Competitive -</b> Ranked, Opponents will be selected based on rank</span>
					<hr />
					<input type="radio" name="ranked" value="0" required/>
					<span><b>Casual -</b> Unranked, Opponents will be selected randomly, pairing rules not enforced</span>
					<hr />
					<input type="submit" class="sc-button" style="background-color: limegreen" value="&#9658; Start Game" name="start" />
				</form>
			</div>
		</div>
	</body>
</html>