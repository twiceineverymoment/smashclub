<html>
	<head>
		<link rel="stylesheet" href="/resource/dstyle.php" />
		<link rel="shortcut icon" href="/resource/favicon.ico" />
		<title>Register - SmashClub</title>
	</head>
	<body>

	<script type="text/javascript">
	function validatePass(){
		var pass1 = document.getElementById('pass1').value;
		var pass2 = document.getElementById('pass2').value;
		if (pass1 != pass2){
			alert("Passwords do not match!");
			return false;
		}
		return true;
	}
	</script>

	<?php require_once($_SERVER['DOCUMENT_ROOT']."/alertmessage_wide.php"); ?>
	<?php require_once($_SERVER['DOCUMENT_ROOT']."/service/svc_event_manager.php"); ?>
	<?php

	if (isset($_POST["verify"])){
		$uuid = svc_findGuestAccount($_POST["verify-email"], $_POST["verify-phone"]);
		if (!$uuid){
			$nodata = true;
		} else {
			$confirm = true;
			$username = svc_getUsernameByID($uuid);
		}
	}

	if (isset($_POST["convert"])){
		if (svc_convertGuestToMember($_POST["convert-uuid"], $_POST["convert-username"], $_POST["convert-pass"])){
			showJavascriptAlert("Success! Your SmashClub account has been created. Log in to get started.");
			sendRedirect("/");
			die();
		} else {
			showErrorPage(500);
			die();
		}
	}

	?>

		<div class="page-content">
			<div class="formpage-block">
				<?php if (isset($confirm)) : ?>
					<h2>Welcome Back, <?php echo $username; ?></h2>
					<h3>Ready to join the club? Confirm your gamertag and set a password for your account now.</h3>
					<form action=<?php echo $_SERVER['PHP_SELF']; ?> method="post" onsubmit="return validatePass()">
						<span>Username or Gamertag:</span>
						<input type="username" name="convert-username" value=<?php echo $username; ?> required />
						<span>Password:</span>
						<input type="password" name="convert-pass" id="pass1" required />
						<span>Confirm Password:</span>
						<input type="password" id="pass2" required />
						<input type="hidden" name="convert-uuid" value=<?php echo $uuid; ?> />
						<p></p>
						<input type="submit" name="convert" value="Register" class="sc-button" />
					</form>
				<?php else : ?>
					<h2>Join The Club</h2>
					<?php if (isset($nodata)) : ?>
						<h3 style="color: lightcoral">We couldn't find a guest RSVP with that information. Please try again. If you cannot remember your information, please contact the event organizer.</h3>
					<?php else : ?>
						<h3>To convert your existing guest account into a full member account, start by verifying the e-mail and phone number you signed up with. If you cannot remember, you'll need to contact the organizer.</h3>
					<?php endif; ?>
					<form action=<?php echo $_SERVER['PHP_SELF']; ?> method="post">
						<span>E-mail Address:</span>
						<input type="email" name="verify-email" required />
						<span>Phone Number:</span>
						<input type="text" name="verify-phone" maxlength="10" required />
						<p></p>
						<input type="submit" name="verify" value="Find My RSVP" class="sc-button" />
					</form>
				<?php endif; ?>
			</div>
		</div>
	</body>
</html>