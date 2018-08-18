<html>
	<head>
		<link rel="stylesheet" href="/resource/dstyle.php" />
		<link rel="shortcut icon" href="/resource/favicon.ico" />
		<title>Sign Up - SmashClub</title>
	</head>
	<body>
	<?php require_once($_SERVER['DOCUMENT_ROOT']."/alertmessage_wide.php"); ?>
	<?php require_once($_SERVER['DOCUMENT_ROOT']."/service/svc_event_manager.php"); ?>

	<?php
		if (!isset($_GET['eid'])){
			writeLog(WARNING, "Form:GUEST_REG_CONFIRM requested without proper context");
			showErrorPage(400);
			die();
		}

		if (svc_getSetting("EnableSelfRegister")==0){
			writeLog(DEBUG, "Guest confirm page is redirecting to the old guest RSVP form because self registration is turned off.");
			sendRedirect("/events/guestrsvp/?eid=".$_GET['eid']);
		}
	?>

		<div class="page-content">
			<div class="formpage-block">
				<h2>Guest Sign-Up</h2>
				<h3>
					In order to use the matchmaking system and log your scores, you need a SmashClub account. You can go ahead and create one now. If you continue as a guest, depending on the type of event, you may be asked to create an account when you arrive.
				</h3>
				<form action="/register" method="post">
					<input type="submit" value="Create an Account" class="sc-button">
				</form>
				<form action="/events/guestrsvp/" method="get">
					<input type="hidden" name="eid" value=<?php echo $_GET['eid']; ?> />
					<input type="submit" value="Continue as Guest" class="sc-button">
				</form>
			</div>
		</div>
	</body>
</html>