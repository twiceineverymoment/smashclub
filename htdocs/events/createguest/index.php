<html>
	<head>
		<link rel="stylesheet" href="/resource/dstyle.php" />
		<link rel="shortcut icon" href="/resource/favicon.ico" />
		<title>Guest Event Signup - SmashClub</title>
	</head>
	<body>

	<script type="text/javascript">
	function validateGuestForm(){
		var phoneno = document.getElementById('guest-phone').value;
		if (phoneno.length>0 && phoneno.length != 10){
			alert("Your phone number should be 10 digits including the area code.");
			return false;
		}
		return true;
	}
	</script>

	<?php require_once($_SERVER['DOCUMENT_ROOT']."/alertmessage_wide.php"); ?>
	<?php require_once($_SERVER['DOCUMENT_ROOT']."/service/svc_event_manager.php"); ?>

	<?php
		if (!isset($_GET['eid']) or $_SESSION['type']>0){
			writeLog(ALERT, "Unrecognized attempt to load GUEST REGISTER form");
			showErrorPage(400);
			die();
		}

		$eventdata = svc_getEventDataById($_GET['eid']);

	?>

		<div id="ctlpage" class="page-content">
			<h2>Create a Guest Account</h2>
			<h3><b>If you already have an account, please go back and log in!</b></h3>
			<h3>Use this form to create a guest account for <b><?php echo $eventdata['event_title']; ?></b>. You can convert your guest account to a full membership later if you attend future events or tournaments.</h3>
			<div class="formpage-block">
				<form action="/script/guest_register.php" method="post" onsubmit="return validateGuestForm()">
					<h2><?php echo $eventdata['event_title']; ?></h2>
					<h3><?php echo $eventdata['event_location']; ?></h3>
					<h3><?php echo svc_longFormatDate(new DateTime($eventdata['event_time'])); ?></h3>
					<b>Please fill in your information below: </b><br/>
					<span>Username or Gamertag:</span>
					<input type="text" name="guest-username" required/><br/>
					<span>First Name:</span>
					<input type="text" name="guest-firstname" required/><br/>
					<span>Last Name:</span>
					<input type="text" name="guest-lastname" required/><br/>
					<span>E-mail Address:</span>
					<input type="email" name="guest-email" required/><br/>
					<span>Phone Number:</span>
					<input type="text" name="guest-phone" id="guest-phone" maxlength="10" required/><br/>
					<input type="hidden" name="event-id" value=<?php echo $_GET['eid']; ?> />
					<br/>
					<input type="submit" name="guest-submit" class="sc-button" value="Create Guest Account" />
					<p style="color: yellow">Note: Guests cannot log into the site, so if you need to change or cancel your signup, you'll need to create a full member account or contact the organizer.</p>
				</form>
			</div>
		</div>
	</body>
</html>