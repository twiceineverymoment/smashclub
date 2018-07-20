<html>
	<head>
		<link rel="stylesheet" href="/resource/dstyle.php" />
		<link rel="shortcut icon" href="/resource/favicon.ico" />
		<title>Ranking Records - SmashClub</title>
	</head>
	<body>
	<?php require_once($_SERVER['DOCUMENT_ROOT']."/navigation.php"); ?>
		<div id="banner">
			<img src="/customization/banner.png" class="banner-img" /> 
		</div>

	<?php

	require_once($_SERVER['DOCUMENT_ROOT']."/alertmessage.php");
	require_once($_SERVER['DOCUMENT_ROOT']."/service/svc_player_ranks.php");
	require_once($_SERVER['DOCUMENT_ROOT']."/service/svc_member_lookup.php");
	$season = $_GET['season-id'];

	if (!isset($_GET['season-id'])){
		writeLog(WARNING, "Page:RECORDS/RANKINGS loaded with missing season-id parameter");
		sendRedirect("/records");
		die();
	}

	if (isset($_POST['sortbutton'])){
		$ranks = svc_getRankHistoryBySeason($season, $_POST['order']);
	}
	else {
		$ranks = svc_getRankHistoryBySeason($season, 0);
	}

	$count=1;

	?>

		<div id="main" class="page-content">
			<h1 id="rankheader">Ranking Records</h1>
			<div class="legend-link">
				<a href="/leaderboard/tierlegend/">
				<img src="/resource/icons/ico_tier_legend.png" />
				Tier Legend
				</a>
			</div>
			<hr />
			<form action=<?php echo "\"/records/rankings/?season-id=".$_GET['season-id']."\""; ?> method="post">
				Sort By:
				<select name="order" value="0">
					<option value="0">Final Rank (High to Low)</option>
					<option value="1">Final Rank (Low to High)</option>
					<option value="2">Season High (High to Low)</option>
					<!--<option value="3">All-Time High (High to Low)</option>-->
					<option value="4">Username (A to Z)</option>
				</select>
				<input type="submit" class="sc-button" value="Sort" name="sortbutton" />
			</form>

			<h3><b>Note: </b>Members who did not complete placement during this season are not shown.</h3>
			<table class="rank-list">

				<tr id="rank-list-head" />
					<th>Rank</th>
					<th>Tier</th>
					<th>Username</th>
					<th>Rating</th>
					<th>Season High</th>
				</tr>

				<?php while($row = mysqli_fetch_assoc($ranks)) : ?>
					<tr>
						<td><?php echo $count; ?></td>
						<td><img src=<?php echo svc_getEmblemByRank($row['rec_rank_final'], $row['rec_rank_season_high']); ?> /></td>
						<td><a href=<?php echo "'/profile/?u=".$row['user_username']."'" ?>><?php 
							if ($row['user_type']==2) { echo "<b style='color: forestgreen'>&#9873; </b>"; }
							elseif ($row['user_type']==3) { echo "<b style='color: gold'>&#10030; </b>"; }
							elseif ($row['user_type']==4) { echo "<b style='color: dodgerblue'>&#10026; </b>"; }
							echo $row['user_username'];
							?></a></td>
						<td><?php echo $row['rec_rank_final']; ?></td>
						<td><?php echo $row['rec_rank_season_high']; ?></td>
					</tr>
				<?php $count++; endwhile; ?>

			</table>
		</div>
	</body>
</html>