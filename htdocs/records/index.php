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

		<div id="recs-left" class="rec-menu" style="border-right: 1px solid #222222">
			<h2>Tournament Results</h2>
			<h3>This feature coming soon!</h3><!--TODO Remove this-->
			<!--
			<form action="/records/results/" method="get">
			<h3>View tournament results by event:</h3>
			<select name="event-id" value="0">
			<?php
				//TODO - Tournament event selection service when this feature exists.
			?>
			</select>
			<input type="submit" class="sc-button" value="Go!" />
			</form>
			-->
		</div>
		<div id="recs-right" class="rec-menu">
			<h2>Rank History</h2>
			<form action="/records/rankings/" method="get">
			<h3>View previous rankings by season:</h3>
			<select name="season-id" value="0" />
			<?php
				require_once($_SERVER['DOCUMENT_ROOT']."/service/svc_records_lookup.php");
				$seasons = svc_getSeasonListWithGameTitles();
				$games=array("Mixed", "N64", "Melee", "Brawl", "Wii U");
				while ($opt = mysqli_fetch_assoc($seasons)){
					if ($opt['season_id']==svc_getSetting("CurrentSeasonNumber")) continue; //Added for issue #29
					echo "<option value='".$opt['season_id']."'>";
					echo $opt['season_title']." (".$games[$opt['season_game']].")";
					echo "</option>";
				}

			?>
			</select>
			<input type="submit" class="sc-button" value="Go!" />
			</form>
		</div>
		</div>
	</body>
</html>