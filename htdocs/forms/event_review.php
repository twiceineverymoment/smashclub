<html>
	<head>
		<link rel="stylesheet" href="/resource/dstyle.php" />
		<link rel="shortcut icon" href="/resource/favicon.ico" />
		<title>Review Event - SmashClub</title>
	</head>
	<body>
	<?php require_once($_SERVER['DOCUMENT_ROOT']."/alertmessage_wide.php"); ?>
	<?php require_once($_SERVER['DOCUMENT_ROOT']."/service/svc_event_manager.php"); ?>
	<?php require_once($_SERVER['DOCUMENT_ROOT']."/service/svc_member_lookup.php"); ?>
	<?php require_once($_SERVER['DOCUMENT_ROOT']."/service/svc_mailer.php"); ?>
	<?php
	if ($_SESSION['type']<3){
		writeLog(ALERT, "Form:EVENT_REVIEW requested by unauthorized user, IP: ".$_SERVER['REMOTE_ADDR']);
		showErrorPage(403);
		die();
	}

	if (isset($_POST['purge'])){
		if (!svc_purgeSignups($_POST['entries'])){
			showErrorPage(500);
			die();
		}
	}

	if (isset($_POST['massmail'])){
		sendRedirect("/contact/?event=".$_POST['event_id']);
		die();
	}

	if (isset($_POST['view'])){
		$list = svc_getGuestListByEvent($_POST['event_id']);
	}
	
	?>

		<div class="page-content">
			<div class="formpage-block">
			
			<h2>Event Guest List</h2>

			<form action="/forms/event_review.php" method="post">
			<span>Select event:</span>
			<select name="event_id"><option>Select...</option><?php echo svc_getEventListAsOptions(true, false); ?></select>
			<input type="submit" name="view" value="View Signups" class="sc-button"/>
			</form>

			<?php if (isset($_POST['view'])) : ?>
				<hr />
				<h3>Guest List For <?php echo svc_getEventDataById($_POST['event_id'])['event_title']; ?></h3>
				<form action="/forms/event_review.php" method="post">
					<table class="rank-list">
						<tr>
							<td colspan="4"><input type="submit" class="sc-button" style="background-color: firebrick" value="Delete Selected" name="purge" onclick="return confirm('Are you sure you want to delete the selected signups? This cannot be undone.')"/>
							<input type="submit" class="sc-button" value="&#9993; Message Guests" name="massmail" /></td>
							<input type="hidden" name="view" value="1" />
							<input type="hidden" name="event_id" value=<?php echo $_POST['event_id']; ?> />
						</tr>
						<?php while($row = mysqli_fetch_assoc($list)) : ?>
							<tr>
								<td><input type="checkbox" name="entries[]" value=<?php echo $row['signup_id']; ?> /></td>
								<?php if ($row['uuid']==null) : ?>
									<td><?php echo $row['signup_name']; ?> (Guest)</td>
									<td colspan="2"><?php echo $row['signup_contact']; ?>
								<?php else : ?>
									<?php $data = svc_getMemberInfoByID($row['uuid']); ?>
									<td><?php echo $row['user_username']; ?></td>
									<td><?php echo $data['prof_email_address']; ?></td>
									<td><?php echo $data['prof_phone_number']; ?></td>
								<?php endif; ?>
							</tr>
						<?php endwhile; ?>
					</table>
				</form>
			<?php endif; ?>	

			</div>
		</div>
	</body>
</html>