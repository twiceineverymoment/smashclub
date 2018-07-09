<html>
	<head>
		<link rel="stylesheet" href="/resource/dstyle.php" />
		<link rel="shortcut icon" href="/resource/favicon.ico" />
		<title>SmashClub</title>
	</head>
	<body>
	<?php require_once($_SERVER['DOCUMENT_ROOT']."/alertmessage_wide.php"); ?>
	<?php require_once($_SERVER['DOCUMENT_ROOT']."/service/svc_event_manager.php"); ?>
	<?php
	if ($_SESSION['type']<3){
		writeLog(ALERT, "Form:TOURNEY_START requested by unauthorized user, IP: ".$_SERVER['REMOTE_ADDR']);
		showErrorPage(403);
		die();
	}

	if (isset($_POST['event-select'])){
		$eventdata = svc_getEventDataById($_POST['event-id']);
		$datetime = new DateTime($eventdata['event_time']);
	}

	?>

		<div class="page-content">
			<div class="formpage-block">
				<h2>Start Tourney</h2>
				<form action="tourney_start.php" method="post">
					<span>Select Event:</span>
					<select name="event-id" id="event-id">
						<?php svc_getEventListAsOptions(true, true); ?>
					</select>
					<input type="submit" class="sc-button" name="event-select" value="Continue" />
				</form>
				<hr/>
				<?php if(isset($_POST['event-select'])) : ?>
				<form action="/script/tourney_update.php?action=start" method="post">
					<h3>Prepare Tournament: <?php echo $eventdata['event_title']; ?></h3>
					<p>To begin, choose a bracket system for your tournament and enter the rules to display on the site. Click Next Step to move to the Registration phase.</p>
					<input type="radio" name="ranked" value="1" id="ranked">
					<label for="ranked"><span>Ranked Tournament (must be your featured game this season)</span></label>
					<input type="radio" name="ranked" value="0" id="unranked">
					<label for="unranked"><span>Unranked Tournament (select if you are playing a different game)</span></label>
					<hr/>
					<h3>Tournament Rules</h3>
					<p>Describe the rules - stock, timer, legal stages and characters, rules for sudden death, etc. Be specific!</p>
					<textarea rows="3" cols="20" name="rules"></textarea>
					<hr/>
					<input type="radio" name="bracket" value="0" required>
					<span><b>Single Elimination (4-32 players) - </b>Good for very large groups. Winners move forward to the next round, and losers are eliminated, until only one contestant remains. If the number of contestants is not a power of 2 (8, 16, 32, etc) then some players will receive byes.</span>
					<hr/>
					<input type="radio" name="bracket" value="1" required>
					<span><b>Double Elimination (4-32 players) - </b>Players are eliminated when they have lost twice. The first loss moves a player into the Losers Bracket, where they can reach the finals by defeating other one-time losers. The losers bracket winner must defeat the winners bracket finalist twice to claim the championship. If the number of contestants is not a power of 2 (8, 16, 32, etc) then some players will receive byes.</span>
					<hr/>
					<input type="radio" name="bracket" value="2" required>
					<span><b>Round Robin (3-10 players) - </b>Every player faces every other player exactly once, and the winner is the one with the most total points. This format has no eliminations, but can take a very long time with any moderately large group.</span>
					<hr/>
					<input type="radio" name="bracket" value="3" disabled required>
					<span><b>Grouped Round Robin (8-64 players) - </b>Players are separated into groups of 4 and play in smaller round-robin tournaments. Each group will have a winner. This tournament can "feed" winners into an elimination tournament to save time with very large numbers of contestants. <b>Number of contestants must be a multiple of 4.</b></span>
					<hr/>
					<input type="hidden" name="event" value=<?php echo "\"".$eventdata['event_id']."\""; ?> />
					<input type="submit" class="sc-button" name="update" value="Next Step" />
				</form>
				<?php endif; ?>
			</div>
		</div>
	</body>
</html>