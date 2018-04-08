<html>
	<head>
		<link rel="stylesheet" href="/resource/dstyle.php" />
		<link rel="shortcut icon" href="/resource/favicon.ico" />
		<title>SmashClub</title>
	</head>
	<body>
	<?php require_once($_SERVER['DOCUMENT_ROOT']."/alertmessage_wide.php"); ?>
	<?php require_once($_SERVER['DOCUMENT_ROOT']."/service/svc_tourney_manager.php"); ?>
	<?php require_once($_SERVER['DOCUMENT_ROOT']."/service/svc_event_manager.php"); ?>
	<?php
	if ($_SESSION['type']<3){
		writeLog(ALERT, "Form:MANUAL_BRACKET requested by unauthorized user, IP: ".$_SERVER['REMOTE_ADDR']);
		showErrorPage(403);
		die();
	}

	if (isset($_POST['build'])){
		$result = svc_buildBracket($_POST['rounds'], $_POST['matches']);
		if ($result === true){
			svc_putSetting("TourneyStatus", 1);
			svc_setSignupLock(svc_getSetting("MatchMakingEvent"), true); //Lock the event signup
			sendRedirect("/tourney/");
			die();
		} else {
			showJavascriptAlert("The bracket builder encountered an error. ".$result);
		}
	}
	?>

		<div class="page-content">
			<div class="formpage-block">
				<h2>Manual Bracket Entry</h2>
				<h3 style="color: yellow">NOTE: Refer to the SmashClub documentation for instructions on how to use this form.</h3>
				<form action="/forms/manual_bracket.php" method="post">
					<h3>Round Descriptors:</h3>
					<textarea name="rounds" rows="10" cols="40"></textarea>
					<h3>Manual Match Data:</h3>
					<textarea name="matches" rows="30" cols="40"></textarea>
					<br />
					<input type="submit" name="build" value="Build Bracket" class="sc-button" />
				</form>
			</div>
		</div>
	</body>
</html>