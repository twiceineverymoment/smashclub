<html>
	<head>
		<link rel="stylesheet" href="/resource/dstyle.php" />
		<link rel="shortcut icon" href="/resource/favicon.ico" />
		<title>Rankings - SmashClub</title>
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

	if ($_SESSION['type']==0){
		writeLog(ALERT, "Page:RANKINGS requested by unauthorized user, IP: ".$_SERVER['REMOTE_ADDR']);
		sendRedirect("/");
		die();
	}

	if (isset($_POST['sortbutton'])){
		$ranks = svc_getAllCurrentRankData($_POST['order']);
	}
	else {
		$ranks = svc_getAllCurrentRankData(svc_getSetting("DefaultRankSortOrder"));
	}

	$count=1;

	?>

		<div id="main" class="page-content">

		<?php if(svc_getSetting("CurrentSeasonNumber")=="0") : ?>
			<h2>Off-Season</h2>
			<h3>The leaderboard is not available during the off-season. Looking for a past season? Visit the <a href="/records/">Hall of Records</a>.</h3>
		<?php else : ?>
			<h1 id="rankheader">Current Rankings</h1>
			<div class="legend-link">
				<a href="/leaderboard/tierlegend/">
				<img src="/resource/icons/ico_tier_legend.png" />
				Tier Legend
				</a>
			</div>
			<div class="legend-link">
				<a href="/leaderboard/faq/">
				<img src="/resource/icons/ico_rating_faq.png" />
				Rankings FAQ
				</a>
			</div>
			<hr />
			<form action="/leaderboard/" method="post">
				Sort By:
				<select name="order" value="0">
					<option value="0">Current Rank (High to Low)</option>
					<option value="1">Current Rank (Low to High)</option>
					<option value="2">Season High (High to Low)</option>
					<option value="3">All-Time High (High to Low)</option>
					<option value="4">Username (A to Z)</option>
				</select>
				<input type="submit" class="sc-button" value="Sort" name="sortbutton" />
			</form>

			<table class="rank-list">

				<tr id="rank-list-head" />
					<?php if(svc_getSetting("ShowRankColumn")==1) : ?><th>Rank</th><?php endif; ?>
					<th>Tier</th>
					<th>Username</th>
					<th>Rating</th>
					<th>Season High</th>
					<th>All-Time High</th>
				</tr>

				<?php while($row = mysqli_fetch_assoc($ranks)) : ?>
					<?php if ($row['user_username']==$_SESSION['name']) : ?>
						<tr style="font-weight: bold">
					<?php else : ?>
						<tr>
					<?php endif; ?>
						<?php if(svc_getSetting("ShowRankColumn")==1) : ?><td><?php echo $count; ?></td><?php endif; ?> <!--Added IF tags for Request 76: Hide Rank column-->
						<td><img src=<?php echo svc_getEmblemByRank($row['rank_current'], $row['rank_season_high']); ?> /></td>
						<td><a href=<?php echo "'/profile/?u=".$row['user_username']."'" ?>><?php 
							if ($row['user_type']==2) { echo "<b style='color: forestgreen'>&#9873; </b>"; }
							elseif ($row['user_type']==3) { echo "<b style='color: gold'>&#10030; </b>"; }
							elseif ($row['user_type']==4) { echo "<b style='color: dodgerblue'>&#10026; </b>"; }
							echo $row['user_username'];
							if ($row['rank_consec_games'] >= svc_getSetting("WinningStreakInterval")){
								echo " &#x1F525;";
								echo "<span style='font-weight: bold'>".$row['rank_consec_games']."</span>";
							}
							?></a></td>
						<td><?php echo $row['rank_current']; ?></td>
						<td><?php echo $row['rank_season_high']; ?></td>
						<td><?php echo $row['rank_career_high']; ?></td>
					</tr>
				<?php $count++; endwhile; ?>

			</table>

			<h3>Players still in placement are not shown.</h3>
			<h3>Head over to <a href="/records/">Records</a> to see previous seasons.</h3>

		<?php endif; ?>
		</div>
	</body>
</html>