<html>
	<head>
		<link rel="stylesheet" href="/resource/dstyle.php" />
		<link rel="shortcut icon" href="/resource/favicon.ico" />
		<title>SmashClub</title>
		<script type="text/javascript">
		function validatePWs(){
			var pw1 = document.getElementById('new1').value;
			var pw2 = document.getElementById('new2').value;
			if (pw1==pw2){
				return true;
			} else {
				alert("Passwords do not match!");
				return false;
			}
		}
		</script>
	</head>
	<body>
	<?php require_once($_SERVER['DOCUMENT_ROOT']."/alertmessage_wide.php"); ?>
	<?php require_once($_SERVER['DOCUMENT_ROOT']."/service/svc_site_settings.php"); ?>
		<div class="page-content" style="text-align: center">
			<div style="width: 50%; margin: 0 auto;">
				<h1>SmashClub</h1>
				<h3>Version <?php echo svc_getSetting("Version"); ?></h3>
				<p>SmashClub is a PHP-based web application for managing Super Smash Bros. competitive leagues and clubs. It is developed by Derek Elam and is not affiliated with Nintendo, HAL, or the Super Smash Bros. franchise.</p>
				<h3>Features:</h3>
				<ul type="disc">
					<li>Customizable home page with information about your group and a custom banner image</li>
					<li>Communicate with your members using announcements and polls</li>
					<li>Schedule events, email out invitations, and collect signups using one-click RSVP</li>
					<li>Localized social network where each member can customize their player profile with a main character, catchphrase, and user ID's on popular gaming networks</li>
					<li>Tiered ranking system based on wins and losses to help members find suitable opponents</li>
				</ul>
				<h3>Upcoming Features:</h3>
				<ul type="disc">
					<li>Organize and run tournaments using one of several bracket systems</li>
					<li>Players can track detailed win/loss stats on their profile</li>
				</ul>
				<h2>Acknowledgements</h2>
				<p>Super Smash Bros. is copyright Nintendo and HAL Laboratories.</p>
				<p>All player character images are copyright Nintendo and are not included as part of the SmashClub package.</p>
				<p>All user interface icons are from FlatIcon <a>http://www.flaticon.com/</a> for non-commercial use only.</p>
				<p> 
			</div>
		</div>
	</body>
</html>