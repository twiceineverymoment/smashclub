<html>
	<head>
		<link rel="stylesheet" href="/resource/dstyle.php" />
		<link rel="shortcut icon" href="/resource/favicon.ico" />
		<title>Inbox - SmashClub</title>
	</head>
	<body>
	<?php require_once($_SERVER['DOCUMENT_ROOT']."/navigation.php"); ?>
		<div id="banner">
			<img src="/customization/banner.png" class="banner-img" /> 
		</div>

	<?php require_once($_SERVER['DOCUMENT_ROOT']."/alertmessage.php"); ?>

		<div id="main" class="page-content">
		<?php

		if ($_SESSION["type"]==0){
			writeLog(ALERT, "Page:INBOX requested by unauthorized user, IP: ".$_SERVER["REMOTE_ADDR"]);
			showErrorPage(401);
			die();
		}

		require_once($_SERVER['DOCUMENT_ROOT']."/service/svc_messaging.php");

		$results = svc_getInboxByUser($_SESSION['uuid']);

		function drawInboxRow($assoc){
			if ($assoc['from_uuid']==0){ //Notification

			} else { //Private Message

			}
		}

		?>

		<h2>Inbox</h2>
		<hr />
		<form action=<?=$_SERVER['PHP_SELF'];?> method="post">
		<div style="text-align: center">
			<input type="submit" name="delete" class="sc-button" style="background-color: firebrick" value="Delete" />
			<input type="submit" name="delete" class="sc-button" value="Mark As Read" />
			<br /><br />
		</div>
		<table class="rank-list">
			<tr id="rank-list-head">
				<th>&#x25BC;</th>
				<th>From</th>
				<th>Subject</th>
				<th>Received</th>
			</tr>
			<?php if(count($results)==0) : ?>
				<tr>
				<td colspan="7">No messages found</td>
				</tr>
			<?php else : while ($result = mysqli_fetch_assoc($results)) : ?>
			<?php drawInboxRow($result); ?>
			<?php endwhile; endif; ?>
		</table>
		</form>
		</div>
	</body>
</html>