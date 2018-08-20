<html>
	<head>
		<link rel="stylesheet" href="/resource/dstyle.php" />
		<link rel="shortcut icon" href="/resource/favicon.ico" />
		<title>Match Log - SmashClub</title>
	</head>
	<body>
	<?php require_once($_SERVER['DOCUMENT_ROOT']."/navigation.php"); ?>
		<div id="banner">
			<img src="/customization/banner.png" class="banner-img" /> 
		</div>

	<?php require_once($_SERVER['DOCUMENT_ROOT']."/alertmessage.php"); ?>

		<div id="main" class="page-content">
		<?php

		if ($_SESSION["type"]==0){
			writeLog(ALERT, "Page:MATCH_LOG requested by unauthorized user, IP: ".$_SERVER["REMOTE_ADDR"]);
			showErrorPage(401);
			die();
		}

		require_once($_SERVER['DOCUMENT_ROOT']."/service/svc_records_lookup.php");
		require_once($_SERVER['DOCUMENT_ROOT']."/service/svc_authentication.php");
		require_once($_SERVER['DOCUMENT_ROOT']."/service/svc_player_ranks.php");
		require_once($_SERVER['DOCUMENT_ROOT']."/service/svc_event_manager.php");

		if (isset($_POST["filter"])){
			$results = svc_searchMatchLog($_POST["user"], $_POST["opponent"], $_POST["season_id"], $_POST["event_id"]);
			$selectedUser = $_POST["user"];
			$selectedSeason = $_POST["season_id"];
		} else {
			$results = svc_searchMatchLog($_SESSION["uuid"], "", svc_getSetting("CurrentSeasonNumber"), "");
			$selectedUser = $_SESSION["uuid"];
			$selectedSeason = svc_getSetting("CurrentSeasonNumber");
		}

		function drawMatchLogRow($arr){
			if ($arr["match_p2_uuid"] == $_SESSION["uuid"]){
				if ($arr["match_p2_score"] > $arr["match_p1_score"]){
					echo "<tr style='background-color: palegreen !important'>";
				} elseif ($arr["match_p2_score"] < $arr["match_p1_score"]){
					echo "<tr style='background-color: lightcoral !important'>";
				} else {
					echo "<tr>";
				}
				echo "<td>".svc_getUsernameByID($arr["match_p2_uuid"])."</td>";
				echo "<td>".$arr["match_p2_score"]."&nbsp;-&nbsp;".$arr["match_p1_score"]."</td>";
				echo "<td>".svc_getUsernameByID($arr["match_p1_uuid"])."</td>";
			} elseif ($arr["match_p1_uuid"] == $_SESSION["uuid"]) {
				if ($arr["match_p1_score"] > $arr["match_p2_score"]){
					echo "<tr style='background-color: palegreen !important'>";
				} elseif ($arr["match_p1_score"] < $arr["match_p2_score"]){
					echo "<tr style='background-color: lightcoral !important'>";
				} else {
					echo "<tr>";
				}
				echo "<td>".svc_getUsernameByID($arr["match_p1_uuid"])."</td>";
				echo "<td>".$arr["match_p1_score"]."&nbsp;-&nbsp;".$arr["match_p2_score"]."</td>";
				echo "<td>".svc_getUsernameByID($arr["match_p2_uuid"])."</td>";
			} else {
				echo "<tr>";
				echo "<td>".svc_getUsernameByID($arr["match_p1_uuid"])."</td>";
				echo "<td>".$arr["match_p1_score"]."&nbsp;-&nbsp;".$arr["match_p2_score"]."</td>";
				echo "<td>".svc_getUsernameByID($arr["match_p2_uuid"])."</td>";
			}
			if ($arr["match_is_ranked"]==1){
				echo "<td><img src='/resource/icons/podium.png' style='width: 24px !important; height: 24px !important' alt='Ranked Match' /></td>";
			} else {
				echo "<td></td>";
			}
			$eventName = svc_getEventDataById($arr["event_id"]);
			if (!$eventName){
				echo "<td>(Free Play)</td>";
			} else {
				echo "<td>".$eventName["event_title"]."</td>";
			}
			echo "<td>".svc_formatTimestamp($arr["match_time"]);
			echo "<td>".svc_getUsernameByID($arr["match_reported_by_uuid"])."</td>";
			echo "</tr>";
		}

		?>

		<div style="float: right" />
		<form action=<?php echo $_SERVER["PHP_SELF"]; ?> method="post">
		<h3>Filter Matches</h3>
			<p>
				<?php if ($_SESSION["type"] > 1) : ?>
				<select name="user">
					<option value="">Anyone</option>
					<?php svc_getEligiblePlayersHTML($selectedUser); ?>
				</select>
				vs.
				<select name="opponent">
					<option value="">Anyone</option>
					<?php svc_getEligiblePlayersHTML($_POST["opponent"]); ?>
				</select>
				<?php else : ?>
				<input type="hidden" name="user" value=<?=$_SESSION["uuid"];?> />
				<select name="opponent">
					<option value="">All Opponents</option>
					<?php svc_getEligiblePlayersHTML($_POST["opponent"]); ?>
				</select>
				<?php endif; ?>
				&nbsp;|&nbsp;
				<select name="event_id">
					<option value="">All Events</option>
					<option value="0">Free-Play Matches</option>
					<?php svc_getEventListAsOptions(true, false, $_POST["event_id"]); ?>
				</select>
				<select name="season_id">
					<option value="">All Seasons</option>
					<option value="0">Off-Season</option>
					<?php svc_echoSeasonList(true, $selectedSeason); ?>
				</select>
				<input type="submit" class="sc-button" name="filter" value="Search" />
				<!--<input type="reset" class="sc-button" name="reset" style="background-color: gray" value="Reset Filter" />-->
			</p>
		</form>	
		</div>
		<h2>SmashClub Match Log</h2>
		<h3>Search for previous matches you've participated in.</h3>
		<hr />
		<table class="rank-list">
			<tr id="rank-list-head">
				<th>Player 1</th>
				<th>-</th>
				<th>Player 2</th>
				<th colspan="2">Event</th>
				<th>Match Time</th>
				<th>Recorded By</th>
			</tr>
			<?php if(mysqli_num_rows($results)==0) : ?>
				<tr>
				<td colspan="7">No matches found.</td>
				</tr>
			<?php else : while($result = mysqli_fetch_assoc($results)) : ?>
			<?php drawMatchLogRow($result); ?>
			<?php endwhile; endif; ?>
		</table>
		</div>
	</body>
</html>