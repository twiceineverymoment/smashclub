<html>
	<head>
		<link rel="stylesheet" href="/resource/dstyle.php" />
		<link rel="shortcut icon" href="/resource/favicon.ico" />
		<title>Polls - SmashClub</title>
	</head>
	<body>

	<script type="text/javascript">
	function closePoll(){
		if (confirm("Closing the poll will clear all responses. Are you sure?")){
			window.location = "/script/poll_update.php?close";
		}
	}
	</script>
	<?php require_once($_SERVER['DOCUMENT_ROOT']."/navigation.php"); ?>
		<div id="banner">
			<img src="/customization/banner.png" class="banner-img" /> 
		</div>

	<?php require_once($_SERVER['DOCUMENT_ROOT']."/alertmessage.php"); ?>

	<?php
		require_once($_SERVER['DOCUMENT_ROOT']."/service/svc_polling.php");

		if ($_SESSION['type']==0){
		writeLog(ALERT, "Page:POLLS requested by unauthorized user, IP: ".$_SERVER['REMOTE_ADDR']);
		sendRedirect("/");
		die();
		}

		$mode = svc_getSetting("PollStatus");
		$choices = svc_getPollChoices(); //Returns an array of possible responses
		$question = svc_getSetting("PollQuestion");
		$max = sizeof($choices);

		writeLog(DEBUG, "PollChoices size=".$max.", value=".implode(",", $choices));
		?>

		<div id="main" class="page-content">

		<div style="float: right">
			<?php if($_SESSION["type"] >= 3) : ?>
			<?php if($mode=="0") : ?>
				<input type="button" class="sc-button" value="Create Poll" onClick="window.location='/forms/poll_create.php'" />
			<?php else : ?>
				<input type="button" class="sc-button" value="Poll Results" onClick="window.location='/forms/poll_results.php'" />
				<input type="button" class="sc-button" value="Close Poll" style="background-color: firebrick" onClick="closePoll()" />
			<?php endif; ?>
			<?php endif; ?>
		</div>

		<h1>Polls</h1>
		<hr />

		<?php if($mode=="0") : ?>
			<h2>There is no open poll to display.</h2>
			<h3>The club organizer does not currently have an open poll. Check back here to give your feedback later!</h3>
		<?php elseif(svc_userAlreadyResponded($_SESSION['uuid'])) : ?>
			<h2>Your response has been recorded!</h2>
			<h3>Thank you for your feedback. Responses are anonymous and officers will not know who sent which response. Please check back later for a new poll.</h3>
		<?php elseif($mode=="1") : ?>
			<div class="activity-block">
				<h2><?php echo $question; ?></h2><h3>Your responses are anonymous</h3>
				<form action="/script/poll_response.php" method="post"> 
				<?php for($i=0; $i<$max; $i++) : ?>
					<input type="radio" name="respchoice" value=<?php echo "'".$i."'"; ?>><?php echo $choices[$i]; ?><br/>
				<?php endfor; ?>
				<br/>
				<input type="submit" class="sc-button" name="respsubmit" value="Submit Response" />
				</form>
			</div>
		<?php else : ?>
			<div class="activity-block">
				<h2><?php echo $question; ?></h2><h3>Your responses are anonymous</h3>
				<form action="/script/poll_response.php" method="post"> 
				<textarea rows="6" cols="60" name="resptext"></textarea><br/><br/>
				<input type="submit" class="sc-button" name="respsubmit" value="Submit Response" />
				</form>
			</div>
		<?php endif; ?>
		
		</div>
	</body>
</html>