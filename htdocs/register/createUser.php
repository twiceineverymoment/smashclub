<html>
	<head>
		<link rel="stylesheet" href="/resource/dstyle.php" />
		<link rel="shortcut icon" href="/resource/favicon.ico" />
		<title>Start Season - SmashClub</title>
	</head>
	<body>
	<?php require_once($_SERVER['DOCUMENT_ROOT']."/alertmessage_wide.php"); ?>
	<?php require_once($_SERVER['DOCUMENT_ROOT']."/service/svc_event_manager.php"); ?>

		<div class="page-content">
			<div class="formpage-block">
				<h2>Join <?php echo svc_getSetting("OrganizationName"); ?></h2>
				<h3>
					If you have attended a tournament before and signed up as a guest, you can convert your guest gamertag into a full account. Otherwise, you can create a brand new account.
				</h3>
				<form action="/register/verifyGuest.php">
					<input type="submit" value="Convert My Guest Account" class="sc-button">
				</form>
				<form action="/register/">
					<input type="submit" value="Create a New Account" class="sc-button">
				</form>
			</div>
		</div>
	</body>
</html>