<html>
	<head>
		<link rel="stylesheet" href="/resource/dstyle.php" />
		<link rel="shortcut icon" href="/resource/favicon.ico" />
		<title>SmashClub</title>
	</head>
	<body>
	<?php require_once($_SERVER['DOCUMENT_ROOT']."/alertmessage_wide.php"); ?>
	<?php require_once($_SERVER['DOCUMENT_ROOT']."/service/svc_event_manager.php"); ?>
	<?php
	if ($_SESSION['type']<3){
		writeLog(ALERT, "Form:EVENT_CREATE requested by unauthorized user, IP: ".$_SERVER['REMOTE_ADDR']);
		showErrorPage(403);
		die();
	}
	?>

		<div class="page-content">
			<div class="formpage-block">
				<h2>Create New Event</h2>
				<form action="/script/event_update.php" method="post">
					<span>Event Title:</span>
					<input type="text" name="title" size="30" maxlength="128" required/>
					<span>Type of Event:</span>
					<select name="type">
						<option value="4">Club Meeting</option>
						<option value="0">Tournament</option>
						<option value="2">Casual Play</option>
						<option value="1">Competitive Play</option>
						<option value="3">Training</option>
						<option value="5">Other</option>
					</select>
					<h3>Trying to create a tournament? Use <a>This Form</a> instead!</h3>
					<hr/>
					<span>Event Date and Time:</span>
					<input type="datetime-local" name="datetime" required/>
					<span>Event Location:</span>
					<input type="text" name="location" maxlength="128" />
					<h3>Give a brief description of your event. Include rule sets for competitive events (1024 characters max)</h3>
					<textarea rows="3" name="description"></textarea>
					<input type="checkbox" name="private" />
					Private Event (Not visible unless logged in)<br/>
					<input type="checkbox" name="sendemails" />
					Send Email notification to members about this event<br/>
					<input type="submit" class="sc-button" name="create" value="Create Event" />
				</form>
			</div>
		</div>
	</body>
</html>