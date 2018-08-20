<html>
	<head>
		<link rel="stylesheet" href="/resource/dstyle.php" />
		<link rel="shortcut icon" href="/resource/favicon.ico" />
		<title>Home - SmashClub</title>
	</head>
	<body>
	<style type="text/css">
	hr {
		/*Affects all heading HR tags in portlets*/
		border: 0;
    	height: 1px;
    	background-image: linear-gradient(to right, rgba(0, 0, 0, 0), rgba(255, 255, 255, 1.0), rgba(0, 0, 0, 0));
    }
	</style>
	<?php require_once($_SERVER['DOCUMENT_ROOT']."/navigation.php"); ?>
		<div id="banner">
			<img src="/customization/banner.png" class="banner-img" /> 
		</div>

	<?php require_once($_SERVER['DOCUMENT_ROOT']."/alertmessage.php"); ?>
	<?php include($_SERVER['DOCUMENT_ROOT']."/home/alert_event.php"); ?>

		<div id="main" class="page-content">

			
			<?php include($_SERVER['DOCUMENT_ROOT']."/home/port_season.php"); ?>
			<?php include($_SERVER['DOCUMENT_ROOT']."/home/port_about.php"); ?>
			<?php include($_SERVER['DOCUMENT_ROOT']."/home/port_event.php"); ?>
			<?php include($_SERVER['DOCUMENT_ROOT']."/home/port_announcement.php"); ?>
			<?php include($_SERVER['DOCUMENT_ROOT']."/home/port_activity.php"); ?>
			<?php include($_SERVER['DOCUMENT_ROOT']."/home/port_social.php"); ?>

		</div>
	</body>
</html>