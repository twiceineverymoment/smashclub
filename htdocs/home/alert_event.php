<?php

require_once($_SERVER['DOCUMENT_ROOT']."/service/svc_event_manager.php");

$evtstatus = svc_getSetting("TourneyStatus");

if ($evtstatus > 0){
	if (svc_getSetting("MatchMakingEvent")==0){
		$evttitle = "Free Play";
	} else {
		$evttitle = svc_getEventDataById(svc_getSetting("MatchMakingEvent"))['event_title'];
	}
}

?>

<?php if ($evtstatus==3) : ?>

	<?php if (svc_getSetting("EventIsRanked")==1) : ?>
		<div id="eventalert" style="background-color: orange">
	<?php else : ?>
		<div id="eventalert" style="background-color: mediumseagreen">
	<?php endif; ?>
		<h2>An event is currently in progress!</h2>
		<?php if ($_SESSION['type']>0) : ?>
			<h3>Click <a href="/matchmaking/">Matchmaking</a> to join: <?php echo $evttitle; ?></h3>
		<?php else : ?>
			<h3>Log in to join!</h3>
		<?php endif; ?>
	</div>

<?php elseif ($evtstatus==2) : ?>

	<div id="eventalert" style="background-color: orangered">
		<h2>A tournament is starting!</h2>
		<?php if ($_SESSION['type']>0) : ?>
			<h3>Click the <a href="/tourney/">Events</a> tab to register for <?php echo $evttitle; ?></h3>
		<?php else : ?>
			<h3>Log in to sign up for the tournament!</h3>
		<?php endif; ?>
	</div>

<?php elseif ($evtstatus==1) : ?>

	<div id="eventalert" style="background-color: orangered">
		<h2>A tournament is currently in progress!</h2>
		<?php if ($_SESSION['type']>0) : ?>
			<h3>Click the <a href="/tourney/">Tournament</a> tab to view the bracket for <?php echo $evttitle; ?></h3>
		<?php else : ?>
			<h3>Log in to see the bracket!</h3>
		<?php endif; ?>
	</div>

<?php endif; ?>