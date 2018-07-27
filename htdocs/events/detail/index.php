<html>
	<head>
		<link rel="stylesheet" href="/resource/dstyle.php" />
		<link rel="shortcut icon" href="/resource/favicon.ico" />
		<title>User: <?php echo $_GET['u']; ?> - SmashClub</title>
	</head>
	<body>
	<?php require_once($_SERVER['DOCUMENT_ROOT']."/navigation.php"); ?>
		<div id="banner">
			<img src="/customization/banner.png" class="banner-img" /> 
		</div>
		<?php require_once($_SERVER['DOCUMENT_ROOT']."/alertmessage.php"); ?>
		<div id="main" class="page-content">
		<?php
		require_once($_SERVER['DOCUMENT_ROOT']."/service/svc_member_lookup.php");
		require_once($_SERVER['DOCUMENT_ROOT']."/service/svc_event_manager.php");

		$data = svc_getEventDataById($_GET['id']);
		if (!isset($_GET['id'])){
			writeLog(ALERT, "Page:EVENT_DETAIL loaded with no event_id");
			showErrorPage(400);
			die();
		}
		
		?>

		<?php if($_SESSION['type']==0 and (svc_getSetting("EnableGuestBrowsing")==0 or $data["event_signup_access"]==1)) : ?>
			<h1>Private Event</h1>
			<h3>You don't have permission to view this event. Please log in or <a href="/register/">Register</a>.</h3>
		<?php elseif(!$data) : ?>
			<?php http_response_code(404); ?>
			<h1>Ummm...</h1>
			<h3>That event was not found. The link you followed may have expired.</h3>
		<?php else : ?>

			<div class="event-block">
			<h1><?php echo $data['event_title']; ?></h1>
			<h2><img src="/resource/icons/ico_event_date.png" /> <?php echo svc_longFormatDate(new DateTime($data['event_time'])); ?></h2>
			<h2 class="event-label"><?php echo $data['event_location']; ?> <img src="/resource/icons/ico_event_location.png" /></h2>
			<p><?php echo $data['event_description']; ?></p>

			<table style="width: 100%; border-collapse: collapse;">
			<tr>
				<td width="50%">
					<h2 class="event-type">
					<?php
					if ($data['event_type']==0){
						echo "<span style='color: orangered'>Tournament</span>";
					}
					elseif ($data['event_type']==1){
						echo "<span style='color: orange'>Competitive Play</span>";
					}
					elseif ($data['event_type']==2){
						echo "<span style='color: mediumseagreen'>Casual Play</span>";
					}
					elseif ($data['event_type']==3){
						echo "<span style='color: skyblue'>Training Session</span>";
					}
					elseif ($data['event_type']==4){
						echo "<span style='color: #888'>Meeting</span>";
					} else {
						echo "<span>&nbsp;</span>";
					}
					?>
				</h2>
				</td>
				<td width="50%" style="text-align: right !important">
					<form action="/script/event_rsvp.php" method="post">
					<input type="hidden" name="event-id" value=<?php echo "'".$data['event_id']."'"; ?> />
					<?php if($data['event_signup_open']==0) : ?>
						<span style="color: white; display: inline-block">Sign-up is locked for this event.</span>
					<?php elseif($_SESSION['type']==0) : ?>
						<?php if (svc_isEventFull($data['event_id'])) : ?>
							<span style="color: white; display: inline-block">This event is full. Please contact the organizer.</span>
						<?php elseif($data['event_type']==0 and svc_getSetting("EnableGuestAccounts")==1) : ?>
							<input type="submit" class="sc-button" name="register-guest" style="display: inline-block; width: 150px; background-color: purple" value="&#10004; Guest Sign Up" />
						<?php else : ?>
							<input type="submit" class="sc-button" name="guest-rsvp" style="display: inline-block; width: 150px" value="&#10004; Sign Up" />
						<?php endif; ?>
					<?php elseif(svc_isUserSignedUp($_SESSION["uuid"], $_GET["id"])) : ?>
						<span style="color: white; display: inline-block">You are signed up for this event!</span>
						<input type="submit" class="sc-button" name="cancel" style="background-color: firebrick; display: inline-block; width: 150px" value="&#128473; Cancel" />
					<?php elseif(svc_isEventFull($data['event_id'])) : ?>
						<span style="color: white; display: inline-block">This event is full. Please contact the organizer.</span>
					<?php else : ?>
						<input type="submit" class="sc-button" name="member-rsvp" style="background-color: limegreen; display: inline-block; width: 150px" value="&#10004; Sign Up Now" />
					<?php endif; ?>

					<input type="button" class="sc-button" value="&#9993; Contact Host" style="display: inline-block; width: 150px" onclick=<?php echo "\"contactHost(".$data['event_owner_uuid'].")\""; ?> />
					</form>

				</td>
			</tr>
			</table>
			
			</div>

		<?php endif; ?>
		</div>
	</body>
</html>