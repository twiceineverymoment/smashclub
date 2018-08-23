<html>
	<head>
		<link rel="stylesheet" href="/resource/dstyle.php" />
		<link rel="shortcut icon" href="/resource/favicon.ico" />
		<title>SmashClub</title>
	<script type="text/javascript">
	function startEvent(){
		if (document.getElementById('manual').checked){
			window.location = "/forms/manual_bracket.php";
		} else if (document.getElementById('rating-low').checked){
			window.location = "/script/autogen_elimination.php?order=0";
		}
		else if (document.getElementById('rating-high').checked){
			window.location = "/script/autogen_elimination.php?order=1";
		}
		else if (document.getElementById('random').checked){
			window.location = "/script/autogen_elimination.php?order=2";
		} else {
			alert("Please select a bracket mode.");
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
		writeLog(ALERT, "Form:START_GAME_TOURNEY requested by unauthorized user, IP: ".$_SERVER['REMOTE_ADDR']);
		showErrorPage(403);
		die();
	}

	if (isset($_POST['purge'])){
		if (!svc_purgeSignups($_POST['entries'])){
			showErrorPage(500);
			die();
		}
	}

	$event_id = svc_getSetting("MatchMakingEvent");
	$list = svc_getGuestListByEvent($event_id);
	
	?>

		<div class="page-content">
			<div class="formpage-block">
			
			<h2>Build Tournament Bracket</h2>

				<hr />
				<h3>Review Event: <?php echo svc_getEventDataById($event_id)['event_title']; ?></h3>
				<p>Please review the event guest list before starting gameplay. <br/>
				<b>NOTE: Signups will be locked once you click Start Tournament. Members cannot join a tournament once it has already started. Make sure everyone is signed up before starting!</b><br/>
				</p>
				<form action="/forms/start_game_event.php" method="post" onsubmit="return confirm('Are you sure you want to delete the selected signups? This cannot be undone.')">
					<table class="rank-list">
						<tr>
							<th colspan="4"><input type="submit" class="sc-button" style="background-color: firebrick" value="Delete Selected" name="purge"/>
							<input type="button" class="sc-button" style="background-color: limegreen" value="&#9658; Start Tournament" onclick="startEvent()" /></th>
							<input type="hidden" name="view" value="1" />
							<input type="hidden" name="event_id" value=<?php echo $event_id; ?> />
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
				<h3>Bracket Seeding Method</h3>
				<hr />
					<input type="radio" id="rating-low" name="mode" />
					<span><b>Ascending -</b> Lower-ranked players will play first, and higher-ranked players will get byes in the first round.</span>
					<hr />
					<input type="radio" id="rating-high" name="mode" />
					<span><b>Descending -</b> Higher-ranked players will play first, and lower-ranked players will get byes in the first round.</span>
					<hr />
					<input type="radio" id="random" name="mode" />
					<span><b>Random -</b> The bracket will be seeded randomly. This may result in some one-sided matches.</span>
					<hr />
					<input type="radio" id="manual" name="mode" />
					<span><b>Manual Entry -</b> Create the entire bracket manually using the SmashClub match list syntax. Do this if you want more control over variations in the bracket.</span>
			<input id="eid" type="hidden" value=<?php echo (isset($_POST['view'])) ? $_POST['event_id'] : 0 ; ?> />
			</div>
		</div>
	</body>
</html>