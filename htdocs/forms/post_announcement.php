<html>
	<head>
		<link rel="stylesheet" href="/resource/dstyle.php" />
		<link rel="shortcut icon" href="/resource/favicon.ico" />
		<title>SmashClub</title>
	</head>
	<body>
	<?php require_once($_SERVER['DOCUMENT_ROOT']."/alertmessage_wide.php"); ?>
	<?php require_once($_SERVER['DOCUMENT_ROOT']."/service/svc_activity_feed.php"); ?>
	<?php
	if ($_SESSION['type']<3){
		writeLog(ALERT, "Form:POST_ANNOUNCEMENT requested by unauthorized user, IP: ".$_SERVER['REMOTE_ADDR']);
		showErrorPage(403);
		die();
	}
	?>

		<div class="page-content">
			<div class="formpage-block">
				<h2>Post Announcement</h2>
				<form action="/script/announcement.php" method="post">
					<span>Headline:</span>
					<input type="text" name="header" required/>
					Enter announcement text here (1024 characters max) - You may use HTML formatting, but it may not be visible in e-mails.
					<textarea name="body" rows="3"></textarea><br/>
					<input type="submit" class="sc-button" name="post" value="Post" />
				</form>
			</div>
		</div>
	</body>
</html>