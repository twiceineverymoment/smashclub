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
		writeLog(ALERT, "Form:EVENT_MANAGE requested by unauthorized user, IP: ".$_SERVER['REMOTE_ADDR']);
		showErrorPage(403);
		die();
	}

	if (isset($_POST['event-select'])){
		$selectedEvent = $_POST['event-id'];
		$eventdata = svc_getEventDataById($_POST['event-id']);
		$datetime = new DateTime($eventdata['event_time']);
	}

	?>
	<script type="text/javascript">
	function deleteEvent(){
		if (confirm('Are you sure you want to delete this event?')){
			var form = document.getElementById('topForm');
			form.action = '/script/event_update.php';
			form.submit();
		}
	}
	</script>

		<div class="page-content">
			<div class="formpage-block">
				<h2>Manage Events</h2>
				<form action="event_manage.php" method="post" id="topForm">
					<span>Select Event:</span>
					<select name="event-id" id="event-id">
						<?php svc_getEventListAsOptions(true, false, $selectedEvent); ?>
					</select>
					<span>What would you like to do?</span><br/>
					<input type="submit" class="sc-button" name="event-select" value="Edit Event" />
					<input type="submit" class="sc-button" name="delete" style="background-color: firebrick" value="Delete Event" onClick="deleteEvent()" />
				</form>
				<hr/>
				<?php if(isset($_POST['event-select'])) : ?>
				<form action="/script/event_update.php" method="post">
					<span>Event Title:</span>
					<input type="text" name="title" size="30" maxlength="128" value=<?php echo "\"".$eventdata['event_title']."\""; ?> />
					<span>Event Date and Time:</span>
					<input type="datetime-local" name="datetime" value="<?= $datetime->format('Y-m-d\TH:i:s'); ?>" />
					<span>Event Location:</span>
					<input type="text" name="location" maxlength="128" value=<?php echo "\"".$eventdata['event_location']."\""; ?>/>
					<h3>Give a brief description of your event. Include rule sets for competitive events (1024 characters max)</h3>
					<textarea rows="3" name="description"><?php echo $eventdata['event_description']; ?></textarea>
					<input type="checkbox" name="private" />
					Private Event (Not visible unless logged in)<br/>
					<input type="hidden" name="eid" value=<?php echo $_POST['event-id']; ?> />
					<input type="submit" class="sc-button" name="update" value="Save Changes" />
				</form>
				<?php endif; ?>
			</div>
		</div>
	</body>
</html>