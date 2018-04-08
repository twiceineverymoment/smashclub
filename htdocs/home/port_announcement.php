<?php require_once($_SERVER['DOCUMENT_ROOT']."/customization/smashclub_theme.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT']."/service/svc_activity_feed.php"); ?>
<style type="text/css">
.port_announcement {
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
.port_announcement h3 {
	margin-top: 2px;
	margin-bottom: 2px;
}
.port_announcement h2 {
	display: block;
	margin: 0 auto;
}
</style>
<?php
	$data = svc_getLatestAnnouncement();
?>
<div class="port_announcement">
	<h3>LATEST ANNOUNCEMENT</h3>
	<hr/>
	<div style="text-align: center;" />
	<?php if (!$data) : ?>
		<h3>There are no recent announcements.</h3>
	<?php else : ?>
		<h2><?php echo $data['activity_header_html']; ?></h2>
		<p><?php echo $data['activity_body_html']; ?></p>
	<?php endif; ?>
	</div>
</div>