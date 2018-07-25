<html>
	<head>
		<link rel="stylesheet" href="/resource/dstyle.php" />
		<link rel="shortcut icon" href="/resource/favicon.ico" />
		<title>Activity Feed - SmashClub</title>
	</head>
	<body>
	<?php require_once($_SERVER['DOCUMENT_ROOT']."/navigation.php"); ?>
		<div id="banner">
			<img src="/customization/banner.png" class="banner-img" /> 
		</div>

	<?php require_once($_SERVER['DOCUMENT_ROOT']."/alertmessage.php"); ?>

		<div id="main" class="page-content">
		<?php

		require_once($_SERVER['DOCUMENT_ROOT']."/service/svc_activity_feed.php");

		$results = svc_getActivityItems(20);

		?>

		<div class="activity-block" style="width: 75%">
		<h2>Activity Feed</h2>
		<h3>Announcements, milestones, and scores</h3>
		<?php include($_SERVER["DOCUMENT_ROOT"]."/activity/activity_table.php"); ?>
		</div>
		</div>
	</body>
</html>