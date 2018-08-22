<html>
	<head>
		<link rel="stylesheet" href="/resource/dstyle.php" />
		<link rel="shortcut icon" href="/resource/favicon.ico" />
		<title>Tourney Bracket - SmashClub</title>
	</head>
	<body>
	<?php require_once($_SERVER['DOCUMENT_ROOT']."/navigation.php"); ?>
		<div id="banner">
			<img src="/customization/banner.png" class="banner-img" /> 
		</div>

	<?php require_once($_SERVER['DOCUMENT_ROOT']."/alertmessage.php"); ?>
	<?php require_once($_SERVER['DOCUMENT_ROOT']."/service/svc_tourney_manager.php"); ?>
	<?php require_once($_SERVER['DOCUMENT_ROOT']."/service/svc_authentication.php"); ?>
	<?php require_once($_SERVER['DOCUMENT_ROOT']."/service/svc_member_lookup.php"); ?>
	<?php require_once($_SERVER['DOCUMENT_ROOT']."/service/svc_event_manager.php"); ?>

	<?php
	if ($_SESSION['type']==0) {
		writeLog(ALERT, "Page:TOURNEY requested by unauthorized user, IP: ".$_SERVER['REMOTE_ADDR']);
		showErrorPage(401);
		die();
	}
	$status = svc_getSetting("TourneyStatus");
	if ($status==0 or $status==3){
		writeLog(INFO, "User attempted to access the Tourney bracket but there is no tournament open. Redirecting to homepage.");
		sendRedirect("/");
		die();
	}

	?>

		<div id="main" class="page-content">

		<h2><?php echo svc_getEventDataByID(svc_getSetting("MatchMakingEvent"))['event_title']; ?>
			[<?php
			$mode = svc_getSetting("TourneyBracketStyle");
			switch($mode){
				case 0: echo "Single Elimination"; break;
				case 1: echo "Double Elimination"; break;
				case 2: echo "Round Robin"; break;
				case 3: echo "Swiss System"; break;
			}
			?>]
		</h2>
		<h2 style="font-size: 16px"><?php echo svc_getSetting("CompMatchRules"); ?></h2>
		<hr/>
			<?php
			$mode = svc_getSetting("TourneyBracketStyle");

			function drawPlayerName($uuid){
				$info = svc_getMemberInfoByID($uuid);
				$emblem = svc_getEmblemByRank($info['rank_current'], $info['rank_season_high']);
				return "<img class='rank-img-tiny' src=".$emblem." /> ".$info['user_username'];
			}

			function drawMatchBlock($assoc){

				if ($assoc['match_status']==0) { //Pending match
					echo "<div class='tourney-match-block'>";
					echo "<table class='tourney-match-innertable' style='color: gray !important'>";
					echo "<tr>";
						echo "<td rowspan='2' width='15%'><h2>".$assoc['match_order']."</h2></td>";
						if (empty($assoc['match_p1_uuid'])){
							$ref1 = explode(":", $assoc['match_p1_ref']);
							if ($ref1[0]=="W"){
								echo "<td><i>Winner of ".$ref1[1]."</i></td>";
							} else {
								echo "<td><i>Loser of ".$ref1[1]."</i></td>";
							}
						} else {
							echo "<td>".drawPlayerName($assoc['match_p1_uuid'])."</td>";
						}
						echo "<td rowspan='2' width='15%'><img src='/resource/icons/ico_match_pending.png' /></td>";
					echo "</tr>";
					echo "<tr>";
						if (empty($assoc['match_p2_uuid'])){
							$ref2 = explode(":", $assoc['match_p2_ref']);
							if ($ref2[0]=="W"){
								echo "<td><i>Winner of ".$ref2[1]."</i></td>";
							} else {
								echo "<td><i>Loser of ".$ref2[1]."</i></td>";
							}
						} else {
							echo "<td>".drawPlayerName($assoc['match_p2_uuid'])."</td>";
						}
					echo "</tr>";
					echo "</table>";
					echo "</div>";
				}

				elseif($assoc['match_status']==1) { //Ready match
					echo "<div class='tourney-match-block'>";
					echo "<table class='tourney-match-innertable'>";
					echo "<tr>";
						echo "<td rowspan='2' width='15%'><h2>".$assoc['match_order']."</h2></td>";
						if (empty($assoc['match_p1_uuid'])){
							$ref1 = explode(":", $assoc['match_p1_ref']);
							if ($ref1[0]=="W"){
								echo "<td><i>Winner of ".$ref1[1]."</i></td>";
							} else {
								echo "<td><i>Loser of ".$ref1[1]."</i></td>";
							}
						} else {
							echo "<td>".drawPlayerName($assoc['match_p1_uuid'])."</td>";
						}
						echo "<td rowspan='2' width='15%'><img src='/resource/icons/ico_match_ready.png' /></td>";
					echo "</tr>";
					echo "<tr>";
						if (empty($assoc['match_p2_uuid'])){
							$ref2 = explode(":", $assoc['match_p2_ref']);
							if ($ref2[0]=="W"){
								echo "<td><i>Winner of ".$ref2[1]."</i></td>";
							} else {
								echo "<td><i>Loser of ".$ref2[1]."</i></td>";
							}
						} else {
							echo "<td>".drawPlayerName($assoc['match_p2_uuid'])."</td>";
						}
					echo "</tr>";
					echo "</table>";
					echo "</div>";
				}

				elseif($assoc['match_status']==2) { //In-Progress Match
					echo "<div class='tourney-match-block' style='background-color: darkred !important'>";
					echo "<table class='tourney-match-innertable'>";
					echo "<tr>";
						echo "<td rowspan='2' width='15%'><h2>".$assoc['match_order']."</h2></td>";
						echo "<td>".drawPlayerName($assoc['match_p1_uuid'])."</td>";
						echo "<td width='10%'><h3>".$assoc['match_p1_score']."</h3></td>";
						echo "<td rowspan='2' width='15%'><img src='/resource/icons/ico_match_inprogress.png' /></td>";
					echo "</tr>";
					echo "<tr>";
						echo "<td>".drawPlayerName($assoc['match_p2_uuid'])."</td>";
						echo "<td width='10%'><h3>".$assoc['match_p2_score']."</h3></td>";
					echo "</tr>";
					echo "</table>";
					echo "</div>";
				}

				elseif($assoc['match_status']==3) { //Completed Match
					echo "<div class='tourney-match-block' style='background-color: #074923 !important'>";
					echo "<table class='tourney-match-innertable'>";
					echo "<tr>";
						echo "<td rowspan='2' width='15%'><h2>".$assoc['match_order']."</h2></td>";
						if ($assoc['match_winner_uuid']==$assoc['match_p1_uuid']){
							echo "<td><b>".drawPlayerName($assoc['match_p1_uuid'])."</b></td>";
							echo "<td width='10%'><b><h3>".$assoc['match_p1_score']."</h3></b></td>";
						} else {
							echo "<td>".drawPlayerName($assoc['match_p1_uuid'])."</td>";
							echo "<td width='10%'><h3>".$assoc['match_p1_score']."</h3></td>";
						}					
						echo "<td rowspan='2' width='15%'><img src='/resource/icons/ico_match_finished.png' /></td>";
					echo "</tr>";
					echo "<tr>";
						if ($assoc['match_winner_uuid']==$assoc['match_p2_uuid']){
							echo "<td><b>".drawPlayerName($assoc['match_p2_uuid'])."</b></td>";
							echo "<td width='10%'><b><h3>".$assoc['match_p2_score']."</h3></b></td>";
						} else {
							echo "<td>".drawPlayerName($assoc['match_p2_uuid'])."</td>";
							echo "<td width='10%'><h3>".$assoc['match_p2_score']."</h3></td>";
						}
					echo "</tr>";
					echo "</table>";
					echo "</div>";
				}

			}

			?>
			<!--Pregame message-->
			<?php if($status==2) : ?>
				<div align="center">
					<h2>Get Ready!</h2>
					<h3>The tournament hasn't started yet! When it starts, the bracket will appear here.</h3>
				</div>
			<?php die(); endif; ?>

			<!--BEGIN WINNERS BRACKET-->
			<?php if($mode==0 or $mode==1) : ?>
				<?php
					$Wrounds = svc_getBracketRounds(0); //Winners bracket
					if ($mode==1){
						echo "<h2>Winners' Bracket</h2>";
					} else {
						echo "<h2>Bracket</h2>";
					}
				?>

				<table class="tourney-match-table">
				<tr>
					<?php while($Wcol = mysqli_fetch_assoc($Wrounds)) : ?>
						<td class="tourney-match-cell">
						<h3><?php echo $Wcol['round_name']; ?></h3>
						<?php $Wmatches = svc_getBracketMatches(0, $Wcol['round_no']); ?>
						<?php
							while($Wmatch = mysqli_fetch_assoc($Wmatches)){
								drawMatchBlock($Wmatch);
							}
						?>
						</td>
					<?php endwhile; ?>
				</tr>
				</table>

			<?php endif; ?>
			<!--END WINNERS BRACKET-->
			<hr/>
			<!--BEGIN LOSERS BRACKET-->
			<?php if($mode==1) : ?>
				<?php
					$Lrounds = svc_getBracketRounds(1); //Losers bracket
					echo "<h2>Losers' Bracket</h2>";
				?>

				<table class="tourney-match-table">
				<tr>
					<?php while($Lcol = mysqli_fetch_assoc($Lrounds)) : ?>
						<td class="tourney-match-cell">
						<h3><?php echo $Lcol['round_name']; ?></h3>
						<?php $Lmatches = svc_getBracketMatches(1, $Lcol['round_no']); ?>
						<?php
							while($Lmatch = mysqli_fetch_assoc($Lmatches)){
								drawMatchBlock($Lmatch);
							}
						?>
						</td>
					<?php endwhile; ?>
				</tr>
				</table>

			<?php endif; ?>
			<!--END LOSERS BRACKET-->


		</div>
	</body>
</html>