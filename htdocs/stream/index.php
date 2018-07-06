<html>
	<head>
		<link rel="stylesheet" href="/resource/dstyle.php" />
		<link rel="shortcut icon" href="/resource/favicon.ico" />
		<title>SmashClub Live Stream</title>
	</head>
	<body style="background-color: black !important">
	<?php require_once($_SERVER['DOCUMENT_ROOT']."/navigation.php"); ?>

		<div id="main" class="page-content" style="background-color: black !important">

		<?php if (svc_getSetting("TwitchOnAir")==1) : ?>

		<div id="twitch-embed" style="margin: 0 !important"></div>
		<script src="https://embed.twitch.tv/embed/v1.js"></script>

		<script type="text/javascript">
			new Twitch.Embed("twitch-embed", {

				width: "100%",
				height: "90%",
				channel: <?php echo "\"".svc_getSetting("TwitchChannelID")."\""; ?>,
				allowfullscreen: true,
				theme: "dark",		

			});
		</script>

		</div>

		<?php else : ?>
			<h2 style="color: white">Off Air</h2>
			<h3 style="color: white">The club livestream is unavailable because the admin has not opened it yet. When an event is being streamed, it will appear here!</h3>
		<?php endif; ?>
	</body>
</html>