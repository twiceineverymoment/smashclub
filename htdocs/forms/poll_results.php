<html>
	<head>
		<link rel="stylesheet" href="/resource/dstyle.php" />
		<link rel="shortcut icon" href="/resource/favicon.ico" />
		<title>Poll Results - SmashClub</title>
	</head>
	<body>
	<?php require_once($_SERVER['DOCUMENT_ROOT']."/alertmessage_wide.php"); ?>
	<?php require_once($_SERVER['DOCUMENT_ROOT']."/service/svc_polling.php"); ?>
	<?php
	if ($_SESSION['type']<3){
		writeLog(ALERT, "Form:POLL_RESULTS requested by unauthorized user, IP: ".$_SERVER['REMOTE_ADDR']);
		showErrorPage(403);
		die();
	}
	$type = svc_getSetting("PollStatus");
	if ($type==1){
		$results = svc_getMCPollResults();
		$choices = svc_getPollChoices();
		$total = svc_getTotalPollResponses();
	}
	if ($type==2){
		$results = svc_getTextPollResults();
	}
	?>

		<div class="page-content">
			<div class="formpage-block">
				<h2>Poll Responses</h2>
				<?php if ($type==1) : ?>
					<h3><?php echo svc_getSetting("PollQuestion"); ?></h3>
					<table class="rank-list">
						<tr class="rank-list-head">
							<th>Choice</th>
							<th># Responses</th>
							<th>% Responses</th>
						</tr>
						<?php for($i=0; $i<sizeof($choices); $i++) : ?>
						<tr>
							<td><?php echo $choices[$i]; ?></td>
							<td><?php echo $results[$i]; ?></td>
							<td><?php echo round(($results[$i] / $total) * 100); ?>%</td>
						</tr>
						<?php endfor; ?>
					</table>

				<?php elseif ($type==2) : ?>
					<h3><?php echo svc_getSetting("PollQuestion"); ?></h3>
					<table class="rank-list">
					<?php while($row = mysqli_fetch_assoc($results)) : ?>
						<tr>
							<td><?php echo "&quot;".$row['response_text']."&quot;"; ?></td>
						</tr>
					<?php endwhile; ?>
					</table>
				<?php else : ?>

				<?php endif; ?>
			</div>
		</div>
	</body>
</html>