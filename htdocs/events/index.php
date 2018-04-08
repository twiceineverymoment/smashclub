<html>
	<head>
		<link rel="stylesheet" href="/resource/dstyle.php" />
		<link rel="shortcut icon" href="/resource/favicon.ico" />
		<title>Events - SmashClub</title>
	</head>
	<script type="text/javascript">
	function contactHost(id){
		window.location="/contact/?member="+id;
	}
	</script>
	<body>
	<?php require_once($_SERVER['DOCUMENT_ROOT']."/navigation.php"); ?>
		<div id="banner">
			<img src="/customization/banner.png" class="banner-img" /> 
		</div>

	<?php require_once($_SERVER['DOCUMENT_ROOT']."/alertmessage.php"); ?>
	<?php require_once($_SERVER['DOCUMENT_ROOT']."/service/svc_event_manager.php");
	$userid = $_SESSION['uuid'];
	$signedUpIds = svc_getEventIdsByUser($userid);

	?>

		<div id="main" class="page-content">

		<?php if(svc_getSetting("TourneyStatus")>0) : ?>

			<?php if (svc_getSetting("TourneyStatus")==2) : ?>
				<h2 style="text-align: center">An event is starting!</h2>
			<?php else : ?>
				<h2 style="text-align: center">An event is currently in progress!</h2>
			<?php endif; ?>
			<?php $eactive = svc_getEventDataById(svc_getSetting("MatchMakingEvent")) ; ?>

			<div class="event-block" style="background-color: #074923">
			<h1><?php echo $eactive['event_title']; ?></h1>
			<h2><img src="/resource/icons/ico_event_date.png" /> <?php echo svc_longFormatDate(new DateTime($eactive['event_time'])); ?></h2>
			<h2 class="event-label"><?php echo $eactive['event_location']; ?> <img src="/resource/icons/ico_event_location.png" /></h2>
			<p><?php echo $eactive['event_description']; ?></p>
			<table style="width: 100%; border-collapse: collapse;">
			<tr>
				<td width="50%">
					<h2 class="event-type">
					<?php
					if ($eactive['event_type']==0){
						echo "<span style='color: orangered'>Tournament</span>";
					}
					elseif ($eactive['event_type']==1){
						echo "<span style='color: orange'>Competitive Play</span>";
					}
					elseif ($eactive['event_type']==2){
						echo "<span style='color: mediumseagreen'>Casual Play</span>";
					}
					elseif ($eactive['event_type']==3){
						echo "<span style='color: skyblue'>Training Session</span>";
					}
					elseif ($eactive['event_type']==4){
						echo "<span style='color: #888'>Meeting</span>";
					} else {
						echo "<span>&nbsp;</span>";
					}
					?>
				</h2>
				</td>
				<td width="50%" style="text-align: right !important">
					<form action="/script/event_rsvp.php" method="post">
					<input type="hidden" name="event-id" value=<?php echo "'".$eactive['event_id']."'"; ?> />
					<?php if($eactive['event_signup_open']==0) : ?>
						<span style="color: white; display: inline-block">Sign-up is locked for this event.</span>
					<?php elseif($_SESSION['type']==0) : ?>
						<span style="color: white; display: inline-block">Log in to join this event.</span>
						<input type="submit" class="sc-button" name="guest-rsvp" style="display: inline-block; width: 150px; background-color: #888;" value="&#10004; Sign Up" disabled/>
					<?php elseif(in_array($eactive['event_id'], $signedUpIds)) : ?>
						<span style="color: white; display: inline-block">You are signed up for this event!</span>
						<input type="submit" class="sc-button" name="cancel" style="background-color: firebrick; display: inline-block; width: 150px" value="&#128473; Leave Event" />
					<?php else : ?>
						<input type="submit" class="sc-button" name="member-rsvp" style="background-color: limegreen; display: inline-block; width: 150px" value="&#10004; Join Event" />
					<?php endif; ?>

					<input type="button" class="sc-button" value="&#9993; Contact Host" style="display: inline-block; width: 150px" onclick=<?php echo "\"contactHost(".$eactive['event_owner_uuid'].")\""; ?> />
					</form>

				</td>
			</tr>
			</table>
			</div>
			<hr />
		<?php endif; ?>

		<h1>Upcoming Events</h1>
		<?php if($_SESSION['type']>0) : ?>
		<h3>Click "Sign Up" to put your name on the list in one click!</h3>
		<?php else : ?>
		<h3>You are browsing as a guest. Click "Sign Up" to fill in your information. If you have an account, log in to make signing up much quicker!</h3>
		<?php endif; ?>
		<hr />
		<?php

		$showprivate = ($_SESSION['type']>0) ? true : false ;
		$results1 = svc_getAllUpcomingEvents($showprivate);
		if (mysqli_num_rows($results1)==0){
			echo "<h3>There are no upcoming events to show right now.</h3>";
		}

		?>

		<?php while($e = mysqli_fetch_assoc($results1)) : ?>

			<div class="event-block">
			<h1><?php echo $e['event_title']; ?></h1>
			<h2><img src="/resource/icons/ico_event_date.png" /> <?php echo svc_longFormatDate(new DateTime($e['event_time'])); ?></h2>
			<h2 class="event-label"><?php echo $e['event_location']; ?> <img src="/resource/icons/ico_event_location.png" /></h2>
			<p><?php echo $e['event_description']; ?></p>

			<table style="width: 100%; border-collapse: collapse;">
			<tr>
				<td width="50%">
					<h2 class="event-type">
					<?php
					if ($e['event_type']==0){
						echo "<span style='color: orangered'>Tournament</span>";
					}
					elseif ($e['event_type']==1){
						echo "<span style='color: orange'>Competitive Play</span>";
					}
					elseif ($e['event_type']==2){
						echo "<span style='color: mediumseagreen'>Casual Play</span>";
					}
					elseif ($e['event_type']==3){
						echo "<span style='color: skyblue'>Training Session</span>";
					}
					elseif ($e['event_type']==4){
						echo "<span style='color: #888'>Meeting</span>";
					} else {
						echo "<span>&nbsp;</span>";
					}
					?>
				</h2>
				</td>
				<td width="50%" style="text-align: right !important">
					<form action="/script/event_rsvp.php" method="post">
					<input type="hidden" name="event-id" value=<?php echo "'".$e['event_id']."'"; ?> />
					<?php if($e['event_signup_open']==0) : ?>
						<span style="color: white; display: inline-block">Sign-up is locked for this event.</span>
					<?php elseif($_SESSION['type']==0) : ?>
						<input type="submit" class="sc-button" name="guest-rsvp" style="display: inline-block; width: 150px" value="&#10004; Sign Up" />
					<?php elseif(in_array($e['event_id'], $signedUpIds)) : ?>
						<span style="color: white; display: inline-block">You are signed up for this event!</span>
						<input type="submit" class="sc-button" name="cancel" style="background-color: firebrick; display: inline-block; width: 150px" value="&#128473; Cancel" />
					<?php else : ?>
						<input type="submit" class="sc-button" name="member-rsvp" style="background-color: limegreen; display: inline-block; width: 150px" value="&#10004; Sign Up" />
					<?php endif; ?>

					<input type="button" class="sc-button" value="&#9993; Contact Host" style="display: inline-block; width: 150px" onclick=<?php echo "\"contactHost(".$e['event_owner_uuid'].")\""; ?> />
					</form>

				</td>
			</tr>
			</table>
			
			</div>

		<?php endwhile; ?>
		<hr/>
		<h2>Past Events</h2>
		<?php
		$results2 = svc_getAllPastEvents($showprivate);
		if (mysqli_num_rows($results2)==0){
			echo "<h3>There are no past events to display.</h3>";
		}
		?>


		<?php while($e = mysqli_fetch_assoc($results2)) : ?>

			<div class="event-block">
			<h1><?php echo $e['event_title']; ?></h1>
			<h2><img src="/resource/icons/ico_event_date.png" /> <?php echo svc_longFormatDate(new DateTime($e['event_time'])); ?></h2>
			<h2 class="event-label"><?php echo $e['event_location']; ?> <img src="/resource/icons/ico_event_location.png" /></h2>
			<p><?php echo $e['event_description']; ?></p>
			<table style="width: 100%; border-collapse: collapse;">
			<tr>
				<td width="50%">
					<h2 class="event-type">
					<?php
					if ($e['event_type']==0){
						echo "<span style='color: orangered'>Tournament</span>";
					}
					elseif ($e['event_type']==1){
						echo "<span style='color: orange'>Competitive Play</span>";
					}
					elseif ($e['event_type']==2){
						echo "<span style='color: mediumseagreen'>Casual Play</span>";
					}
					elseif ($e['event_type']==3){
						echo "<span style='color: skyblue'>Training Session</span>";
					}
					elseif ($e['event_type']==4){
						echo "<span style='color: #888'>Meeting</span>";
					} else {
						echo "<span>&nbsp;</span>";
					}
					?>
				</h2>
				</td>
				<td width="50%" style="text-align: right !important">
					<form action="/script/event_rsvp.php" method="post">

					<input type="button" class="sc-button" value="&#9993; Contact Host" style="display: inline-block; width: 150px" onclick=<?php echo "\"contactHost(".$e['event_owner_uuid'].")\""; ?> />
					</form>

				</td>
			</tr>
			</table>
			</div>

		<?php endwhile; ?>

		</div>
	</body>
</html>