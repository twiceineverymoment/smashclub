<html>
	<head>
		<link rel="stylesheet" href="/resource/dstyle.php" />
		<link rel="shortcut icon" href="/resource/favicon.ico" />
		<title>SmashClub</title>
	</head>
	<body>
	<?php require_once($_SERVER['DOCUMENT_ROOT']."/alertmessage_wide.php"); ?>
	<?php require_once($_SERVER['DOCUMENT_ROOT']."/service/svc_member_lookup.php"); ?>
	<?php
	if ($_SESSION['type']==0){
		writeLog(ALERT, "Form:CONTACT_CHANGE requested by unauthorized user, IP: ".$_SERVER['REMOTE_ADDR']);
		showErrorPage(401);
		die();
	}

	$profile = svc_getFullMemberProfile($_SESSION['name']);
	?>

		<div class="page-content">
			<div class="formpage-block">
				<h2>Edit Your Contact Info</h2>
				<form action="/script/contact_update.php" method="post">
					<span>First Name: </span>
					<input type="text" name="first" maxlength="10" value=<?php echo "\"".$profile['prof_first_name']."\""; ?> required />
					<span>Last Name: </span>
					<input type="text" name="last" maxlength="10" value=<?php echo "\"".$profile['prof_last_name']."\""; ?> required />
					<span>E-mail Address: </span>
					<input type="email" name="email" value=<?php echo "\"".$profile['prof_email_address']."\""; ?> required />
					<span>Phone Number: </span>
					<input type="text" name="phone" maxlength="10" value=<?php echo "\"".$profile['prof_phone_number']."\""; ?> required />
					<br/>
					<input type="checkbox" name="showeml" value="yes" <?php echo ($profile['prof_show_email']=='1') ? "checked" : "" ; ?> /> Show email address on your public profile <br/>
					<input type="checkbox" name="showphn" value="yes" <?php echo ($profile['prof_show_phone']=='1') ? "checked" : "" ; ?> /> Show phone number on your public profile <br/>
					<input type="checkbox" name="emlnot" value="yes" <?php echo ($profile['prof_receive_email']=='1') ? "checked" : "" ; ?> /> Receive e-mail notifications for events and announcements <br/>
					<input type="submit" class="sc-button" value="Save Changes" name="save" />
				</form>
			</div>
		</div>
	</body>
</html>