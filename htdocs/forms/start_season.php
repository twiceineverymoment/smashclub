<html>
	<head>
		<link rel="stylesheet" href="/resource/dstyle.php" />
		<link rel="shortcut icon" href="/resource/favicon.ico" />
		<title>Start Season - SmashClub</title>
	</head>
	<body>
	<?php require_once($_SERVER['DOCUMENT_ROOT']."/alertmessage_wide.php"); ?>
	<?php require_once($_SERVER['DOCUMENT_ROOT']."/service/svc_event_manager.php"); ?>
	<?php
	if ($_SESSION['type']<4){
		writeLog(ALERT, "Form:START_SEASON requested by unauthorized user, IP: ".$_SERVER['REMOTE_ADDR']);
		showErrorPage(403);
		die();
	}
	?>

		<div class="page-content">
			<div class="formpage-block">
				<h2>Start New Season</h2>
				<form action="/script/begin_season.php" method="post">
					<span>Season Title:</span>
					<input type="text" name="season-title" size="30" maxlength="128" />
					<span>Smash Bros. Game:</span>
					<select name="season-game">
						<option value="0">Mixed</option>
						<option value="1">Super Smash Bros. (N64)</option>
						<option value="2">Super Smash Bros. Melee</option>
						<option value="3">Super Smash Bros. Brawl</option>
						<option value="4">Super Smash Bros. Wii U / 3DS</option>
					</select>
					<span>Initialize Rankings To:</span>
					<select name="seed-method">
						<option value="0">Previous Related Season</option>
						<option value="1" disabled>Average of Related Seasons</option><!--TODO Unlock this option-->
						<option value="2">Fresh Start</option>
					</select>
					<span>Number of Placement Matches (1 to 10):</span>
					<input type="number" name="placements" value="4" min="1" max="10" />
					<input type="submit" class="sc-button" name="create" value="Create Event" />
				</form>
			</div>
		</div>
	</body>
</html>