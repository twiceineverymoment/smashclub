<html>
	<head>
		<link rel="stylesheet" href="/resource/dstyle.php" />
		<link rel="shortcut icon" href="/resource/favicon.ico" />
		<title>SmashClub</title>
	</head>
	<body>
	<?php require_once($_SERVER['DOCUMENT_ROOT']."/alertmessage_wide.php"); ?>
	<?php require_once($_SERVER['DOCUMENT_ROOT']."/service/svc_site_settings.php"); ?>
		<div class="page-content" style="text-align: center">
			<div style="width: 50%; margin: 0 auto;">
				<h2>SmashClub Version History and Change Log</h2>
				<div>
					<h3>SmashClub 2.0.525</h3>
					<p>Release Date: TBD</p>
					<ul type="disc">
						<li>Fixed an issue where the "Contact Host" button on events would not send messages to the correct person</li>
						<li>Fixed an issue where the Signup button on events would sometimes appear outside of its event box and mess up the layout of the page</li>
					</ul>
				</div>
				<div>
					<h3>SmashClub 2.0.5</h3>
					<p>Release Date: Sept 7, 2017</p>
					<ul type="disc">
						<li>Introduced a new matchmaking system to coordinate casual and competitive events</li>
						<li style="margin-left: 20px">Players can search for an opponent by skill level, or choose someone specifically to play</li>
						<li style="margin-left: 20px">Events can be casual or competitive - casual events do not enforce the pairing rules</li>
						<li style="margin-left: 20px">Added "Start Event Play" and "Start Free Play" commands in the Admin panel</li>
						<li style="margin-left: 20px">The Score Entry tab now shows a queue of pending matches with the option to enter a score or cancel the match</li>
						<li>Fixed several high-priority security risks</li>
						<li>Admins can now delete signup entries while reviewing the guest list for an event</li>
						<li>Improvements to registration, including detection of duplicate e-mail accounts</li>
						<li>Real names of members are now hidden from view unless logged in</li>
						<li>Fixed Diddy Jong, along with several other cosmetic issues</li>
					</ul>
				</div>
				<div>
					<h3>SmashClub 2.0.236</h3>
					<p>Release Date: Aug 25, 2017</p>
					<ul type="disc">
						<li>Fixed an issue causing slow loading times when accessing forms that send mass emails</li>
						<li>Fixed an issue where some of the game character images were not showing</li>
						<li>Fixed an issue where the Hall of Records page would display an empty list if the Sort By field is used</li>
						<li>Members can now search for friends on the Members page by real name or gamertag</li>
						<li>Various minor fixes and improvements</li>
					</ul>
				</div>
			</div>
		</div>
	</body>
</html>