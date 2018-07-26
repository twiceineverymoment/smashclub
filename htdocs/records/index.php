<html>
	<head>
		<link rel="stylesheet" href="/resource/dstyle.php" />
		<link rel="shortcut icon" href="/resource/favicon.ico" />
		<title>Hall of Records - SmashClub</title>
	</head>
	<body>
	<?php require_once($_SERVER['DOCUMENT_ROOT']."/navigation.php"); ?>
		<div id="banner">
			<img src="/customization/banner.png" class="banner-img" /> 
		</div>

	<?php require_once($_SERVER['DOCUMENT_ROOT']."/alertmessage.php"); ?>

		<div id="main" class="page-content">

		<h1>Hall of Records</h1>

		<div class="records-display">
		<div id="recs-left" class="rec-menu" style="border-right: 1px solid #222222">
			<h2>Match Results</h2>
			<form action="/records/results/" method="get">
			<h3>View brackets from past tournaments.</h3>
			<select name="event_id" value="0">
			<?php
				require_once($_SERVER['DOCUMENT_ROOT']."/service/svc_event_manager.php");
				svc_getEventListAsOptions(2, true);
			?>
			</select>
			<input type="submit" class="sc-button" value="Go!" />
			</form>
			<h3>Find previous matches you played against specific people from any point in time.</h3>
			<input type="button" class="sc-button" onclick="window.location = '/records/matchlog/'" value="View Match Log" />
		</div>
		<div id="recs-right" class="rec-menu">
			<h2>Rank Details</h2>
			<form action="/records/rankings/" method="get">
			<h3>View the ranks from previous seasons.</h3>
			<select name="season-id" value="0" />
			<?php
				require_once($_SERVER['DOCUMENT_ROOT']."/service/svc_records_lookup.php");
				require_once($_SERVER['DOCUMENT_ROOT']."/service/svc_member_lookup.php");
				svc_echoSeasonList(false);
			?>
			</select>
			<input type="submit" class="sc-button" value="Go!" />
			</form>
			<h3>Check your rank history, personal bests, win/loss ratio, and more.</h3>
			<input type="button" class="sc-button" onclick="window.location = '/profile/stats-detail/'" value="View Competitor Profile" />
		</div>
		</div>
		<div class="records-display">
			<h2>Club Records</h2>
			<?php $records = svc_getLandingPageRecordData(); ?>
			<table class="hall-of-records">
				<tr>
					<td rowspan="2">
						<h3 class="records-header">Highest Rank This Season</h3>
						<div class="records-text">
						<?php if (svc_getSetting("CurrentSeasonNumber")==0) : ?>
							<h3>Not available during off-season</h3>
						<?php elseif (!isset($records["HighestRankThisSeason"])) : ?>
							<h3>Insufficient Data</h3>
						<?php else : ?>
							<img class="records-emblem" src=<?php echo svc_getEmblemByRank($records["HighestRankThisSeason"]["rank"], $records["HighestRankThisSeason"]["rank"]); ?> />
							<h1><?php echo $records["HighestRankThisSeason"]["rank"]; ?></h1>
							<h3><?php echo $records["HighestRankThisSeason"]["user"]; ?></h3>
						<?php endif; ?>
						</div>
					</td>
					<td>
						<h3 class="records-header">Highest Rank of All-Time</h3>
						<div class="records-text">
							<?php if (!isset($records["HighestRankAllTime"])) : ?>
								<h3>Insufficient Data</h3>
							<?php else : ?>
								<h2><?php echo $records["HighestRankAllTime"]["rank"]; ?></h2>
								<h3><?php echo $records["HighestRankAllTime"]["user"]; ?></h3>
							<?php endif; ?>
						</div>
					</td>
					<td>
						<h3 class="records-header">Longest Winning Streak</h3>
						<div class="records-text">
							<?php if (!isset($records["LongestWinningStreak"])) : ?>
								<h3>Insufficient Data</h3>
							<?php else : ?>
								<h2><?php echo $records["LongestWinningStreak"]["streak"]; ?></h2>
								<h3><?php echo $records["LongestWinningStreak"]["user"]; ?></h3>
							<?php endif; ?>
						</div>
					</td>
				</tr>
				<tr>
					<td>
						<h3 class="records-header">Most Matches Won</h3>
						<div class="records-text">
							<?php if (!isset($records["MostMatchesWon"])) : ?>
								<h3>Insufficient Data</h3>
							<?php else : ?>
								<h2><?php echo $records["MostMatchesWon"]["wins"]; ?></h2>
								<h3><?php echo $records["MostMatchesWon"]["user"]; ?></h3>
							<?php endif; ?>
						</div>
					</td>
					<td>
						<h3 class="records-header">Most Tournaments Won</h3>
						<div class="records-text">
							<?php if (!isset($records["MostTournamentsWon"])) : ?>
								<h3>Insufficient Data</h3>
							<?php else : ?>
								<h2><?php echo $records["MostTournamentsWon"]["wins"]; ?></h2>
								<h3><?php echo $records["MostTournamentsWon"]["user"]; ?></h3>
							<?php endif; ?>
						</div>
					</td>
				</tr>
			</table>
		</div>
		</div>
	</body>
</html>