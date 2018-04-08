<html>
	<head>
		<link rel="stylesheet" href="/resource/dstyle.php" />
		<link rel="shortcut icon" href="/resource/favicon.ico" />
		<title>Score Entry - SmashClub</title>
	</head>
	<body>
	<?php require_once($_SERVER['DOCUMENT_ROOT']."/navigation.php"); ?>
		<div id="banner">
			<img src="/customization/banner.png" class="banner-img" /> 
		</div>

	<?php
	require_once($_SERVER['DOCUMENT_ROOT']."/alertmessage.php");
	require_once($_SERVER['DOCUMENT_ROOT']."/service/svc_player_ranks.php");
	require_once($_SERVER['DOCUMENT_ROOT']."/service/svc_match_manager.php");
	require_once($_SERVER['DOCUMENT_ROOT']."/service/svc_authentication.php");

	if ($_SESSION['type']<2){
		writeLog(ALERT, "Page:SCORING requested by unauthorized user, IP: ".$_SERVER['REMOTE_ADDR']);
		showErrorPage(403);
		die();
	}
	$status = svc_getSetting("TourneyStatus");
	if ($status==3 or $status==4){
		$fpqueue = svc_getFreeplayQueue();
	}
	?>

		<div id="main" class="page-content">
		<h2>Score Entry</h2>
		<hr />
		<h2 style="margin: 0 auto !important; text-align: center">Available Matches</h2>
		<?php if ($status==3 or $status==4) : ?> <!--Freeplay event-->
			<table class="rank-list">
				<?php if (mysqli_num_rows($fpqueue)==0) : ?>
					<tr id="rank-list-head">
						<th>
							<h3>The matchmaking queue is empty!</h3>
						</th>
					</tr>
				<?php else : ?>
					<tr id="rank-list-head">
						<th colspan="3">
							<h3>Matchmaking Queue</h3>
						</th>
					</tr>
				<?php endif; ?>
				<?php while($fpmatch = mysqli_fetch_assoc($fpqueue)) : ?>
					<tr>
						<form action="/script/score_report_mm.php" method="post" style="margin-bottom: 0px">
							<td style="text-align: center">
								<h3 style="display: inline-block"><?php echo svc_getUsernameByID($fpmatch['match_p1_uuid']); ?></h3>
								<input type="number" style="width: 36px !important" name="score1" value="0" min="0" />
								&nbsp;-&nbsp;
								<input type="number" style="width: 36px !important" name="score2" value="0" min="0" />
								<h3 style="display: inline-block"><?php echo svc_getUsernameByID($fpmatch['match_p2_uuid']); ?></h3>
							</td>
							<?php if ($fpmatch['match_type']==1) : ?>
							<td>
								<img style="width: 36px; height: 36px" src="/resource/icons/ico_playwithfriends.png" alt="Play With Friends" />
							</td>
							<?php else : ?>
							<td>&nbsp;</td>
							<?php endif; ?>
							<td>
								<input type="hidden" name="match_id" value=<?php echo $fpmatch['match_id']; ?> />
								<input type="hidden" name="uuid1" value=<?php echo "\"".$fpmatch['match_p1_uuid']."\""; ?> />
								<input type="hidden" name="uuid2" value=<?php echo "\"".$fpmatch['match_p2_uuid']."\""; ?> />
								<input type="button" class="sc-button" value="Cancel" style="background-color: firebrick;" onclick="window.location='/script/mm_manage.php?action=close&mid=<?php echo $fpmatch['match_id']; ?>'" />
								<input type="submit" class="sc-button" name="submit" value="Submit" />
							</td>
						</form>
					</tr>
				<?php endwhile; ?>
			</table>
		<?php elseif ($status==2) : ?>
			<h3>A tourney is preparing to start! When it begins, scores will appear here.</h3>
		<?php endif; ?>
		<?php if ($status==1 or $status==4) : ?>
			<h4 style="text-align: center">Use the radio buttons to select the winner before marking a match complete.</h4>

			<?php
			require_once($_SERVER['DOCUMENT_ROOT']."/service/svc_tourney_manager.php");
			$fullmatchlist = svc_getAllMatchData();
			function getPlayerNameWithRef($uuid, $ref){
				if (empty($uuid)){
					$data = explode(":", $ref);
					if ($data[0]=="W"){
						return "<i>Winner of ".$data[1]."</i>";
					} elseif ($data[0]=="F"){
						return "<i>Loser of ".$data[1]." (if necessary)</i>";
					} else {
						return "<i>Loser of ".$data[1]."</i>";
					}
				} else {
					return "<b>".svc_getUsernameByID($uuid)."</b>";
				}
			}
			?>

			<table class="rank-list" id="tourney-score-table">
				<tr id="rank-list-head">
					<th>No.</th>
					<th>Contestant 1</th>
					<th>&nbsp;</th>
					<th>&nbsp;</th>
					<th>Contestant 2</th>
					<th>Status</th>
					<th>Update</th>
				</tr>

				<?php while($match = mysqli_fetch_assoc($fullmatchlist)) : ?>
					<?php if($match['match_status']==0) : ?>
						<tr>
						<form action="/script/score_report_tourney.php" method="post">
							<td><?php echo $match['match_order']; ?></td>
							<td><?php echo getPlayerNameWithRef($match['match_p1_uuid'], $match['match_p1_ref']); ?></td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td><?php echo getPlayerNameWithRef($match['match_p2_uuid'], $match['match_p2_ref']); ?></td>
							<td>Pending</td>
							<td>N/A</td>
						</form>
						</tr>
					<?php elseif($match['match_status']==1) : ?>
						<tr>
						<form action="/script/score_report_tourney.php" method="post">
							<td><?php echo $match['match_order']; ?></td>
							<td><?php echo getPlayerNameWithRef($match['match_p1_uuid'], $match['match_p1_ref']); ?></td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td><?php echo getPlayerNameWithRef($match['match_p2_uuid'], $match['match_p2_ref']); ?></td>
							<td>Ready to Play</td>
							<td><input type="submit" class="sc-button" name="startmatch" value="Start"></td>
							<input type="hidden" name="match_no" value=<?php echo $match['match_order']; ?> />
						</form>
						</tr>
					<?php elseif($match['match_status']==2) : ?>
						<tr>
						<form action="/script/score_report_tourney.php" method="post">
							<td><?php echo $match['match_order']; ?></td>
							<td>
								<input type="radio" name="winner" value="1" />
								<?php echo getPlayerNameWithRef($match['match_p1_uuid'], $match['match_p1_ref']); ?>
							</td>
							<td><input type="number" name="score1" value=<?php echo $match['match_p1_score']; ?> min="0" style="width: 36px !important"/></td>
							<td><input type="number" name="score2" value=<?php echo $match['match_p2_score']; ?> min="0" style="width: 36px !important"/></td>
							<td>
								<input type="radio" name="winner" value="2" />
								<?php echo getPlayerNameWithRef($match['match_p2_uuid'], $match['match_p2_ref']); ?>
							</td>
							<td>Now Playing</td>
							<td>
								<input type="submit" class="sc-button" name="update" value="Save" />
								<input type="submit" class="sc-button" name="endmatch" style="background-color: limegreen" value="Finish" />
								<input type="hidden" name="match_no" value=<?php echo $match['match_order']; ?> />
								<input type="hidden" name="uuid1" value=<?php echo $match['match_p1_uuid']; ?> />
								<input type="hidden" name="uuid2" value=<?php echo $match['match_p2_uuid']; ?> />
								<input type="hidden" name="isfinal" value=<?php echo $match['match_is_final']; ?> />
							</td>
						</form>
						</tr>
					<?php elseif($match['match_status']==3) : ?>
						<tr>
						<form action="/script/score_report_tourney.php" method="post">
							<td><?php echo $match['match_order']; ?></td>
							<td>
								<?php echo getPlayerNameWithRef($match['match_p1_uuid'], $match['match_p1_ref']); ?>
							</td>
							<td><?php echo $match['match_p1_score']; ?></td>
							<td><?php echo $match['match_p2_score']; ?></td>
							<td>
								<?php echo getPlayerNameWithRef($match['match_p2_uuid'], $match['match_p2_ref']); ?>
							</td>
							<td>Complete</td>
							<td>
								<input type="submit" class="sc-button" name="reopen" style="background-color: gray" value="Reopen" />
								<input type="hidden" name="match_no" value=<?php echo $match['match_order']; ?> />
							</td>
						</form>
						</tr>

					<?php endif; ?>
				<?php endwhile; ?>
			</table>

		<?php else : ?>
			<h3>There is no tourney or event active.</h3>
		<?php endif; ?>
		<hr />
			<h2 style="margin: 0 auto !important; text-align: center">Manual Score Entry</h2>
			<div class="activity-block" id="freeplay-scoring" style="text-align: center">
				<h3>Didn't schedule an event? Just messing around? Report individual scores manually using this form.</h3>
				<form action="/script/score_report_fp.php" method="post" onsubmit="return validateParticipants()" />
				<div style="width: 45%; display: inline-block; text-align: left">
					<select name="player1a" id="uid1"><?php svc_getEligiblePlayersHTML(); ?></select>
					<input name="score1" type="text" size="3" maxlength="2" required/><br/>
					<select name="player1b" id="dbl1" style="display:none"><?php svc_getEligiblePlayersHTML(); ?></select>
				</div>
				-
				<div style="width: 45%; display: inline-block; text-align: right">
					<input name="score2" type="text" size="3" maxlength="2" required/>
					<select name="player2a" id="uid2"><?php svc_getEligiblePlayersHTML(); ?></select><br/>
					<select name="player2b" id="dbl2" style="display:none"><?php svc_getEligiblePlayersHTML(); ?></select>
				</div>
				<br/>
				<input name="doubles" id="doubles" name="doubles" type="checkbox" value="false" onChange="enableDisableDoubles()" />Doubles Match<br/>
				<input type="submit" class="sc-button" value="Submit Score" name="confirm" />
				</form>
			</div>
			<hr />
			<div class="acp-block">
				<h2>Scorekeeper Tools</h2>
				<div class="acp-icon">
					<a href="/register/">
					<img src="/resource/admincp/create_user.png" />
					New Member
					</a>
				</div>
				<div class="acp-icon">
					<a href="/livescore/">
					<img src="/resource/admincp/scoreboard.png" />
					Scoreboard
					</a>
				</div>
					
				</div>
		</div>

		<script type="text/javascript">
			function enableDisableDoubles(){
				if (document.getElementById("doubles").checked){
					document.getElementById("dbl1").style="display: inline";
					document.getElementById("dbl2").style="display: inline";
				}
				else {
					document.getElementById("dbl1").style="display: none";
					document.getElementById("dbl2").style="display: none";
				}
			}
			function validateParticipants(){
				if (document.getElementById("doubles").checked){
					var participants = [
						document.getElementById("uid1").selectedIndex,
						document.getElementById("uid2").selectedIndex,
						document.getElementById("dbl1").selectedIndex,
						document.getElementById("dbl2").selectedIndex
					];
					if ((new Set(participants)).size !== participants.length){
						alert("You have the same player in multiple slots. Please correct this issue before submitting.");
						return false;
					} else {
						return true;
					}
				} else {
					if (document.getElementById("uid1").selectedIndex == document.getElementById("uid2").selectedIndex){
						alert("Players cannot face themselves!");
						return false;
					} else {
						return true;
					}
				}
			}
		</script>
	</body>
</html>