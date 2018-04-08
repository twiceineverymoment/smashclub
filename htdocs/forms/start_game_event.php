<html>
	<head>
		<link rel="stylesheet" href="/resource/dstyle.php" />
		<link rel="shortcut icon" href="/resource/favicon.ico" />
		<title>Review Event - SmashClub</title>
	<script type="text/javascript">
	function startEvent(){
		if (document.getElementById('ranked').checked){
			var eventid = document.getElementById('eid').value;
			window.location = "/script/mm_manage.php?action=start&eid="+eventid+"&mode=1";
		} else if (document.getElementById('unranked').checked){
			var eventid = document.getElementById('eid').value;
			window.location = "/script/mm_manage.php?action=start&eid="+eventid+"&mode=0";
		} else {
			alert("Please select a game mode.");
		}
	}
	</script>
	</head>
	<body>
	<?php require_once($_SERVER['DOCUMENT_ROOT']."/alertmessage_wide.php"); ?>
	<?php require_once($_SERVER['DOCUMENT_ROOT']."/service/svc_event_manager.php"); ?>
	<?php require_once($_SERVER['DOCUMENT_ROOT']."/service/svc_member_lookup.php"); ?>
	<?php
	if ($_SESSION['type']<3){
		writeLog(ALERT, "Form:START_GAME_EVENT requested by unauthorized user, IP: ".$_SERVER['REMOTE_ADDR']);
		showErrorPage(403);
		die();
	}

	if (isset($_POST['purge'])){
		if (!svc_purgeSignups($_POST['entries'])){
			showErrorPage(500);
			die();
		}
	}

	if (isset($_POST['view'])){
		$list = svc_getGuestListByEvent($_POST['event_id']);
	}
	
	?>

		<div class="page-content">
			<div class="formpage-block">
			
			<h2>Event Play</h2>
			<h3>Play matchmaking with members signed up for an event.</h3>
			<form action="/forms/start_game_event.php" method="post">
			<span>Select event:</span>
			<select name="event_id" id="eventselect"><option>Select...</option><?php echo svc_getMatchmakingEventsAsOptions(); ?></select>
			<input type="submit" name="view" value="Continue" class="sc-button"/>
			</form>

			<?php if (isset($_POST['view'])) : ?>
				<hr />
				<h3>Review Event: <?php echo svc_getEventDataById($_POST['event_id'])['event_title']; ?></h3>
				<p>Please review the event guest list before starting gameplay. <b style="color: yellow">NOTE: An account is required to participate in gameplay. Guest signups will NOT be included! Please have these guests register accounts and sign up before starting!</b></p>
				<form action="/forms/start_game_event.php" method="post" onsubmit="return confirm('Are you sure you want to delete the selected signups? This cannot be undone.')">
					<table class="rank-list">
						<tr>
							<th colspan="4"><input type="submit" class="sc-button" style="background-color: firebrick" value="Delete Selected" name="purge"/>
							<input type="button" class="sc-button" style="background-color: limegreen" value="&#9658; Start Game" onclick="startEvent()" /></th>
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

				<h3>Confirm Game Mode</h3>
				Confirm the game mode you want to use.
				<hr />
					<input type="radio" id="ranked" name="mode" />
					<span><b>Competitive -</b> Ranked, Opponents will be selected based on rank</span>
					<hr />
					<input type="radio" id="unranked" name="mode" />
					<span><b>Casual -</b> Unranked, Opponents will be selected randomly, pairing rules not enforced</span>
					<hr />
			<?php endif; ?>	
			<input id="eid" type="hidden" value=<?php echo (isset($_POST['view'])) ? $_POST['event_id'] : 0 ; ?> />
			</div>
		</div>
	</body>
</html>