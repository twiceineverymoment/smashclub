<html>
	<head>
		<link rel="stylesheet" href="/resource/dstyle.php" />
		<link rel="shortcut icon" href="/resource/favicon.ico" />
		<title>Guest Event Signup - SmashClub</title>
	</head>
	<body>

	<?php require_once($_SERVER['DOCUMENT_ROOT']."/alertmessage_wide.php"); ?>
	<?php require_once($_SERVER['DOCUMENT_ROOT']."/service/svc_event_manager.php"); ?>

	<?php
		if (!isset($_GET['eid']) or $_SESSION['type']>0){
			writeLog(2, "Unrecognized attempt to load GUEST RSVP form");
			showErrorPage(400);
			die();
		}

		$eventdata = svc_getEventDataById($_GET['eid']);

	?>

		<div id="ctlpage" class="page-content">
			<h2>Sign up as a Guest</h2>
			<h3>NOTE: You will need to contact the event host in order to change or cancel your signup. <b>If you have an account, please go back and log in!</b></h3>
			<div class="formpage-block">
				<form action="/script/event_rsvp.php" method="post">
					<h2><?php echo $eventdata['event_title']; ?></h2>
					<h3><?php echo $eventdata['event_location']; ?></h3>
					<h3><?php echo svc_longFormatDate(new DateTime($eventdata['event_time'])); ?></h3>
					<b>Please fill in your information below: </b><br/>
					<span>Your Name:</span>
					<input type="text" name="rsvp-name" required/><br/>
					<span>Contact (Email or phone#):</span>
					<input type="text" name="rsvp-contact" required/><br/>
					<input type="hidden" name="event-id" value=<?php echo $_GET['eid']; ?> />
					<br/>
					<input type="submit" name="guest-confirm" class="sc-button" value="Sign Up Now" />
				</form>
			</div>
		</div>
	</body>
</html>