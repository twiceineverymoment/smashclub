<html>
	<head>
		<link rel="stylesheet" href="/resource/dstyle.php" />
		<link rel="shortcut icon" href="/resource/favicon.ico" />
		<title>Matchmaking - SmashClub</title>
	</head>
	<body>
	<?php require_once($_SERVER['DOCUMENT_ROOT']."/navigation.php"); ?>
		<div id="banner">
			<img src="/customization/banner.png" class="banner-img" /> 
		</div>

	<?php require_once($_SERVER['DOCUMENT_ROOT']."/alertmessage.php"); ?>
	<?php require_once($_SERVER['DOCUMENT_ROOT']."/service/svc_match_manager.php"); ?>
	<?php require_once($_SERVER['DOCUMENT_ROOT']."/service/svc_event_manager.php"); ?>
	<?php require_once($_SERVER['DOCUMENT_ROOT']."/service/svc_member_lookup.php"); ?>

	<?php
	if ($_SESSION['type']==0) {
		writeLog(ALERT, "Page:MATCHMAKING requested by unauthorized user, IP: ".$_SERVER['REMOTE_ADDR']);
		showErrorPage(401);
		die();
	}
	if (svc_getSetting("TourneyStatus")<3){
		writeLog(INFO, "User attempted to access Matchmaking but there is no matchmaking event currently open. Redirecting to homepage.");
		sendRedirect("/");
		die();
	}

	$event_id = svc_getSetting("MatchMakingEvent");
	if ($event_id!=0 and !svc_isUserSignedUp($_SESSION['uuid'], $event_id)){
		showJavascriptAlert("You cannot enter matchmaking because you are not signed up for the event. Please sign up on the Events page and try again!");
		sendBack();
		die();
	}

	if (isset($_POST['add_pf'])){
		if (!svc_addSinglesMatchToQueue($_SESSION['uuid'], $_POST['opponent_id'], 1)){
			showErrorPage(500);
			die();
		}
	}

	if (isset($_POST['searchopp'])){
		$oppfound = svc_getMatchProposal($_SESSION['uuid'], $event_id, $_POST['oppcounter'], svc_getSetting("EventIsRanked"));
	}

	if (isset($_POST['acceptopp'])){
		if (!svc_addSinglesMatchToQueue($_SESSION['uuid'], $_POST['oppid'], 0)){
			showErrorPage(500);
			die();
		}
	}

	?>

		<div id="main" class="page-content">

		<h1>Matchmaking</h1>

		<div class="records-display">
		<div id="recs-left" class="rec-menu" style="border-right: 1px solid #222222">
			<h2>Find An Opponent</h2>
			<?php $mm_order = svc_getQueueOrder($_SESSION['uuid'], 0); ?>
			<?php if ($mm_order == 0) : ?>
				<?php if(!isset($_POST['oppcounter'])) : ?>
					<?php if(svc_getSetting("MatchMakingQueueFreeze")==0) : ?>
						<p>Search for a suitable opponent based on your current rating.</p>
						<form action="/matchmaking/" method="post">
						<input type="submit" name="searchopp" class="sc-button" value="Start Search" style="width: 200px"/>
						<input type="hidden" name="oppcounter" value="0" />
						</form>
					<?php else : ?>
						<p>The queue is currently frozen. New matches are not being accepted.</p>
					<?php endif; ?>
				<?php else : ?>
					<?php if ($oppfound==null) : ?>
					<h3>We couldn't find any good opponents right now. Please try again later or play with a friend.</h3>
					<input type="button" onclick="window.location='/matchmaking/'" value="Start Over" class="sc-button" style="background-color: firebrick; width: 200px;" />
					<?php else : ?>
					<h3>Suggested opponent:</h3>
					<h2>
					<?php echo $oppfound['user_username']; ?>
					<img src=<?php echo svc_getEmblemByRank($oppfound['rank_current'], $oppfound['rank_season_high']); ?> style="width: 64px; height: 64px; display: inline-block; vertical-align: middle" />
					</h2>
					<form action="/matchmaking/" method="post">
					<input type="submit" name="searchopp" class="sc-button" value="Search Again" style="width: 200px"/>
					<input type="hidden" name="oppcounter" value=<?php echo $_POST['oppcounter']+1; ?> />
					</form>
					<form action="/matchmaking/" method="post">
					<input type="submit" name="acceptopp" class="sc-button" value="Accept Match" style="background-color: limegreen; width: 200px;" />
					<input type="hidden" name="oppid" value=<?php echo $oppfound['uuid']; ?> />
					</form>
					<input type="button" onclick="window.location='/matchmaking/'" value="Start Over" class="sc-button" style="background-color: firebrick; width: 200px;" />
					<?php endif; ?>
				<?php endif; ?>
			<?php else : ?>
				<h3>You are number <b><?php echo $mm_order; ?></b> in the queue against <b><?php echo svc_getQueuedOpponent($_SESSION['uuid'], 0); ?></b></h3>
			<?php endif; ?>
		</div>
		<div id="recs-right" class="rec-menu">
			<h2>Play With A Friend</h2>
			<?php 
			$pf_order = svc_getQueueOrder($_SESSION['uuid'], 1);
			?>
			<?php if (svc_getSetting("MatchMakingQueueFreeze")==1) : ?>
				<p>The queue is currently frozen. New matches are not being accepted.</p>
			<?php elseif ($pf_order == 0) : ?>
				<p>Select an opponent from the dropdown menu and click <b>Confirm</b> to enter the queue.</p>
				<?php if (svc_getSetting("EventIsRanked")==1) : ?>
					<p style="color: gray; font-size: 9px; font-style: italic">Grayed-out players are already in the queue.<br/>
					<b>&uarr; &darr; Arrows</b> next to a player indicate a much higher or lower rating, and you probably won't have a fair fight.</p>
				<?php endif; ?>
				<form action="/matchmaking/" method="post">
					<select name="opponent_id" style="width:200px">
					<?php svc_getViableOpponentsAsOptions($_SESSION['uuid'], $event_id, svc_getSetting("EventIsRanked")); ?>
					</select><br/><br/>
					<input type="submit" value="Confirm Match" class="sc-button" name="add_pf" style="background-color: limegreen; width: 200px" />
				</form>
			<?php else : ?>
				<h3>You are number <b><?php echo $pf_order; ?></b> in the queue against <b><?php echo svc_getQueuedOpponent($_SESSION['uuid'], 1); ?></b></h3>
			<?php endif; ?>
		</div>
		</div>
		</div>
	</body>
</html>