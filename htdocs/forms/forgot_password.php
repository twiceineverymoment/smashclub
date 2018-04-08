<html>
	<head>
		<link rel="stylesheet" href="/resource/dstyle.php" />
		<link rel="shortcut icon" href="/resource/favicon.ico" />
		<title>SmashClub</title>
	</head>
	<body>
	<?php require_once($_SERVER['DOCUMENT_ROOT']."/alertmessage_wide.php"); ?>
	<?php require_once($_SERVER['DOCUMENT_ROOT']."/service/svc_authentication.php"); ?>
	<?php
	if (isset($_POST['request'])){
		svc_selfResetPassword($_POST['username'], $_POST['email']);
		showJavascriptAlert("If the email address and gamertag matches an account we have on file, we\'ll send you a temporary password via email.");
		sendRedirect("/");
		die();
	}
	?>

		<div class="page-content">
			<div class="formpage-block">
				<h2>Forgot your Password?</h2>
				<h3>We can't recover your old password, but you can reset it.</h3>
				<form action="/forms/forgot_password.php" method="post">
					<span>Enter your Gamertag: </span>
					<input type="text" name="username" required />
					<span>Confirm your E-mail Address: </span>
					<input type="email" name="email" required />
					<input type="submit" class="sc-button" value="Request Reset" name="request" />
				</form>
			</div>
		</div>
	</body>
</html>