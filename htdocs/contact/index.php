<html>
	<head>
		<link rel="stylesheet" href="/resource/dstyle.php" />
		<link rel="shortcut icon" href="/resource/favicon.ico" />
		<title>Contact Us - SmashClub</title>
	</head>
	<body>
	<?php require_once($_SERVER['DOCUMENT_ROOT']."/navigation.php"); ?>
		<div id="banner">
			<img src="/customization/banner.png" class="banner-img" /> 
		</div>

	<?php
	require_once($_SERVER['DOCUMENT_ROOT']."/alertmessage.php");
	require_once($_SERVER['DOCUMENT_ROOT']."/service/svc_member_lookup.php");

	if (isset($_GET['member'])){
		$rec_id = $_GET['member'];
		$name = svc_getMemberInfoByID($rec_id)['user_username'];
	} elseif (isset($_GET['event'])){
		if ($_SESSION['type']<3){
			writeLog(ALERT, "Page:CONTACT [Event Guests] requested by unauthorized user, IP: ".$_SERVER['REMOTE_ADDR']);
			showErrorPage(403);
			die();
		}
		$rec_id = -1;
		$name = "Event Guests";
	} else {
		$rec_id = 0;
	}
	?>

		<div id="main" class="page-content">

			<div class="activity-block">
				<?php if ($rec_id==0) : ?>
				<h2>Contact Us</h2>
				<p>Questions? Comments? Concerns? Use this form to send a message directly to the club officers.</p>
				<?php else : ?>
				<h2>Compose Message To <?php echo $name; ?></h2>
				<?php endif; ?>
				<form name="contactform" action="/script/contact.php" method="post" style="text-align:right">
				Your Name: <input type="text" name="name" size="20" /><br/>
				Reply To: <input type="text" name="from" size="20" /><br/>
				Message:
				<textarea rows="5" cols="30" name="message" required></textarea><br/>
				<input type="hidden" name="recipient" value=<?php echo $rec_id; ?> />
				<input type="hidden" name="event" value=<?php echo $_GET['event']; ?> />
				<input type="submit" value="Send Message" class="sc-button" name="send"/>
				</form>
			</div>

		</div>
	</body>
</html>