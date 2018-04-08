<?php require_once($_SERVER['DOCUMENT_ROOT']."/customization/smashclub_theme.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT']."/service/svc_event_manager.php"); ?>
<style type="text/css">
.port_event {
	width: 45%;
	display: inline;
	float: right;
	margin: 5px;
	background-color: <?php echo $theme['BlockBackgroundColor']; ?> ;
	font-family: MavenPro;
	color: <?php echo $theme['BlockTextColor']; ?> ;
	box-shadow: 0px 0px 10px #222222;
	padding: 3px 3px 3px 3px;
	border-radius: 5px;
}
.port_event h3 {
	margin-top: 2px;
	margin-bottom: 2px;
}
.port_event img {
	width: 128px;
	display: block;
	margin: 0 auto;
}
.port_event h2 {
	display: block;
	margin: 0 auto;
}
</style>
<?php
	$event_rs = svc_getAllUpcomingEvents(false);
	$event_assoc = mysqli_fetch_assoc($event_rs); //Fetches the first row which is the next upcoming event
?>
<div class="port_event">
	<h3>OUR NEXT EVENT</h3>
	<hr/>
	<div style="text-align: center;" />
	<?php if (mysqli_num_rows($event_rs)==0) : ?>
		<h3>There are no upcoming events right now.</h3>
		Check the <a href="/events/">Events</a> page for past events.
	<?php else : ?>
		<h2><?php echo $event_assoc['event_title']; ?></h2>
		<h3><?php echo svc_longFormatDate(new DateTime($event_assoc['event_time'])); ?></h3>
		<h3><?php echo $event_assoc['event_location']; ?></h3>
		See details and sign up on the <a href="/events/">Events</a> page.
	<?php endif; ?>
	</div>
</div>