<html>
	<head>
		<link rel="stylesheet" href="/resource/dstyle.php" />
		<link rel="shortcut icon" href="/resource/favicon.ico" />
		<title>Competitor Profile - SmashClub</title>
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
		require_once($_SERVER['DOCUMENT_ROOT']."/service/svc_records_lookup.php");

		if ($_SESSION['type']==0){
			sendRedirect("/");
			die();
		}
		if (isset($_GET['id'])){
			if ($_SESSION['type']>1){
				$uuid = $_GET['id'];
			} else {
				writeLog(ALERT, "User attempted to access another member's profile without permission");
				showErrorPage(403);
				die();
			}
		} else {
			$uuid = $_SESSION['uuid'];
		}
		if (isset($_POST["season_id"])){
			if ($_POST["season_id"] == "CURRENT"){
				unset($_POST["season_id"]); //Unset this post argument when selecting the 'back to current season' option
			}
		}
		if (isset($_POST["season_id"])){
			$season_id = $_POST["season_id"];
			$seasonRecords = svc_getPlayerRankInfoBySeason($uuid, $season_id);
		} else {
			$season_id = svc_getSetting("CurrentSeasonNumber");
		}
		$profile = svc_getMemberInfoByID($uuid);
		$joindate = date_format(new DateTime($profile['date_member_join']), "F j, Y");
		$gameIndex = svc_getCurrentSeasonGameNo();
		global $games_long;
		if (isset($_POST["game_id"])){
			$gametext = $games_long[$_POST["game_id"]];
		} else {
			$gametext = $games_long[$gameIndex];
		}

		//Data by game
		if (isset($_POST["game_id"])){
			$gameRecords = svc_getRecordsByGame($uuid, $_POST["game_id"]);
		} else {
			$gameRecords = svc_getRecordsByGame($uuid, $gameIndex);
		}

		//Calculated values
		$careerwinrate = round(($profile['rank_career_wins'] / $profile['rank_career_games']) * 100.0, 2);
		$gamewinrate = round(($gameRecords["wins"] / ($gameRecords["losses"]+$gameRecords["wins"])) * 100.0, 2);
		if (isset($_POST["season_id"])){
			$seasonwinrate = round(($seasonRecords['rec_season_wins'] / ($seasonRecords['rec_season_losses']+$seasonRecords['rec_season_wins']) * 100.0), 2);
		} else {
			$seasonwinrate = round(($profile['rank_season_wins'] / ($profile['rank_season_losses']+$profile['rank_season_wins']) * 100.0), 2);
		}

		//Emblems
		$careerHighEmblem = svc_getEmblemByRank($profile['rank_career_high'], $profile['rank_career_high']);

		if (is_nan($seasonwinrate)){
			$seasonwinrate = "N/A";
		} else {
			$seasonwinrate .= "%";
		}
		if (is_nan($careerwinrate)){
			$careerwinrate = "N/A";
		} else {
			$careerwinrate .= "%";
		}
		if (is_nan($gamewinrate)){
			$gamewinrate = "N/A";
		} else {
			$gamewinrate .= "%";
		}

		function drawRankDelta($a, $b){
			if ($a == $b){
				echo "<td>0 -</td>";
			} elseif ($a > $b){
				echo "<td style='color: red'>&#x25BC; ".($a-$b)."</td>";
			} else {
				echo "<td style='color: limegreen'>&#x25B2; ".($b-$a)."</td>";
			}
		}

		?>
		<div class="competitor-block">
			<h2><?php echo $_SESSION['name']; ?></h2>
			<h3>Member Since <?=$joindate;?></h3>
			<hr />
			<h3>CAREER RECORDS</h3>
			<table>
				<tr>
					<td>Highest Skill Rating</td>
					<td><?=$profile['rank_career_high'];?> <img style="width: 24px; height: 24px; vertical-align: middle" src=<?=svc_getEmblemByRank($profile['rank_career_high'], $profile['rank_career_high']);?> /></td>
				</tr>
				<tr>
					<td>Total Matches Played</td>
					<td><?=$profile['rank_career_games'];?></td>
				</tr>
				<tr>
					<td>Total Events Attended</td>
					<td><?=$profile['rank_total_events']?></td>
				</tr>
				<tr>
					<td>Total Tournaments Attended</td>
					<td><?=$profile['rank_tourney_count']?></td>
				</tr>
				<tr>
					<td>Rating Decay Status</td>
					<td><?=svc_getRatingDecayStatus($uuid);?></td>
				</tr>
				<tr><td colspan="2" class="competitor-table-spacer">&nbsp;</td></tr>
				<tr>
					<td>Wins</td>
					<td><?=$profile['rank_career_wins'];?></td>
				</tr>
				<tr>
					<td>Losses</td>
					<td><?=$profile['rank_career_losses'];?></td>
				</tr>
				<tr>
					<td>Win Percentage</td>
					<td><?=$careerwinrate?></td>
				</tr>
				<tr>
					<td>Longest Winning Streak</td>
					<td><?=$profile['rank_consec_max']?></td>
				</tr>
				<tr><td colspan="2" class="competitor-table-spacer">&nbsp;</td></tr>
				<tr>
					<td>Tournament Wins</td>
					<td><?=$profile['rank_tourney_wins']?></td>
				</tr>
			</table>
			<hr />
			<h3>THIS SEASON</h3>
			<form id="seasonSelect" action=<?=$_SERVER['PHP_SELF'];?> method="post">
				<select name="season_id" onchange="document.getElementById('seasonSelect').submit()" style="display: block; margin: 0 auto">
					<?php if (isset($_POST["season_id"])) : ?>
						<option value="CURRENT">Back to Current Season</option>
						<?php svc_echoSeasonList(false, $season_id); ?>
					<?php else : ?>
						<option value="" selected>View Other Seasons...</option>
						<?php svc_echoSeasonList(false); ?>
					<?php endif; ?>
				</select>
			</form>
			<?php if (isset($_POST["season_id"]) && !$seasonRecords) : ?>
				<h3>No data is available for this season. You must have completed placement during this season for records to be retained.</h3>
			<?php else : ?>
				<table>
				<?php if(isset($_POST["season_id"])) : ?>
				<tr>
					<td>Final Rating</td>
					<td><?=$seasonRecords['rec_rank_final'];?> <img style="width: 24px; height: 24px; vertical-align: middle" src=<?=svc_getEmblemByRank($seasonRecords['rec_rank_final'], $seasonRecords['rec_rank_season_high']);?> /></td>
				</tr>
				<?php else : ?>
				<tr>
					<td>Current Rating</td>
					<?php if($profile['rank_placements']==0) : ?>
					<td><?=$profile['rank_current'];?> <img style="width: 24px; height: 24px; vertical-align: middle" src=<?=svc_getEmblemByRank($profile['rank_current'], $profile['rank_season_high']);?> /></td>
					<?php else : ?>
					<td>Not Placed</td>
					<?php endif; ?>
				</tr>
				<?php endif; ?>
				<tr>
					<td>Season High</td>
					<?php if(isset($_POST["season_id"])) : ?>
					<td><?=$seasonRecords['rec_rank_season_high'];?> <img style="width: 24px; height: 24px; vertical-align: middle" src=<?=svc_getEmblemByRank($seasonRecords['rec_rank_season_high'], $seasonRecords['rec_rank_season_high']);?> /></td>
					<?php else : ?>
					<td><?=$profile['rank_season_high'];?> <img style="width: 24px; height: 24px; vertical-align: middle" src=<?=svc_getEmblemByRank($profile['rank_season_high'], $profile['rank_season_high']);?> /></td>
					<?php endif; ?>
				</tr>
				<tr>
					<td>Placement Rating</td>
					<?php if(isset($_POST["season_id"])) : ?>
					<td><?=$seasonRecords['rec_rank_initial'];?> <img style="width: 24px; height: 24px; vertical-align: middle" src=<?=svc_getEmblemByRank($seasonRecords['rec_rank_initial'], $seasonRecords['rec_rank_initial']);?> /></td>
					<?php else : ?>
						<?php if($profile['rank_placements']==0) : ?>
							<td><?=$profile['rank_initial'];?> <img style="width: 24px; height: 24px; vertical-align: middle" src=<?=svc_getEmblemByRank($profile['rank_initial'], $profile['rank_initial']);?> /></td>
						<?php else : ?>
							<td>Not Placed</td>
						<?php endif; ?>
					<?php endif; ?>
				</tr>
				<tr>
					<td>Rating Change Since Placement</td>
					<?php if(isset($_POST["season_id"])) : ?>
					<?php drawRankDelta($seasonRecords['rec_rank_initial'], $seasonRecords['rec_rank_final']); ?>
					<?php else : ?>
						<?php if($profile['rank_placements']==0) {
							drawRankDelta($profile['rank_initial'], $profile['rank_current']);
						} else {
							echo "<td>N/A</td>";
						} ?>
					<?php endif; ?>
				</tr>
				<tr><td colspan="2" class="competitor-table-spacer">&nbsp;</td></tr>
				<tr>
					<td>Wins</td>
					<?php if(isset($_POST["season_id"])) : ?>
					<td><?=$seasonRecords['rec_season_wins'];?></td>
					<?php else : ?>
					<td><?=$profile['rank_season_wins'];?></td>
					<?php endif; ?>
				</tr>
				<tr>
					<td>Losses</td>
					<?php if(isset($_POST["season_id"])) : ?>
					<td><?=$seasonRecords['rec_season_losses'];?></td>
					<?php else : ?>
					<td><?=$profile['rank_season_losses'];?></td>
					<?php endif; ?>
				</tr>
				<tr>
					<td>Win Percentage</td>
					<td><?=$seasonwinrate?></td>
				</tr>
				</table>
			<?php endif; ?>
			<hr />
			<h3 style="text-transform: uppercase">Stats for <?=$gametext;?></h3>
			<form id="gameSelect" action=<?=$_SERVER['PHP_SELF'];?> method="post">
				<select name="game_id" onchange="document.getElementById('gameSelect').submit()" style="display: block; margin: 0 auto">
					<?php if (isset($_POST["game_id"])) : ?>
						<?php svc_echoGamesList($_POST["game_id"]); ?>
					<?php else : ?>
						<?php svc_echoGamesList($gameIndex); ?>
					<?php endif; ?>
				</select>
			</form>
			<table>
				<tr>
					<td>Seasons Played</td>
					<td><?=$gameRecords["seasons"];?></td>
				</tr>
				<tr>
					<td>Highest Rating</td>
					<td><?=$gameRecords["highest"];?> <img style="width: 24px; height: 24px; vertical-align: middle" src=<?=svc_getEmblemByRank($gameRecords['highest'], $gameRecords['highest']);?> /></td>
				</tr>
				<tr>
					<td>Average Final Rating</td>
					<td><?=$gameRecords["average-final"];?> <img style="width: 24px; height: 24px; vertical-align: middle" src=<?=svc_getEmblemByRank($gameRecords['average-final'], $gameRecords['average-final']);?> /></td>
				</tr>
				<tr>
					<td>Average Initial Rating</td>
					<td><?=$gameRecords["average-init"];?> <img style="width: 24px; height: 24px; vertical-align: middle" src=<?=svc_getEmblemByRank($gameRecords['average-init'], $gameRecords['average-init']);?> /></td>
				</tr>
				<tr>
					<td>Wins</td>
					<td><?=$gameRecords["wins"];?></td>
				</tr>
				<tr>
					<td>Losses</td>
					<td><?=$gameRecords["losses"];?></td>
				</tr>
				<tr>
					<td>Win Percentage</td>
					<td><?=$gamewinrate;?></td>
				</tr>
			</table>
		</div>
		</div>
	</body>
</html>