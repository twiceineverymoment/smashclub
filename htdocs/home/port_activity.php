<?php require_once($_SERVER['DOCUMENT_ROOT']."/customization/smashclub_theme.php"); ?>
<style type="text/css">
.port_activity {
	width: 50%;
	display: inline;
	float: left;
	margin: 5px;
	background-color: <?php echo $theme['BlockBackgroundColor']; ?> ;
	font-family: MavenPro;
	color: <?php echo $theme['BlockTextColor']; ?> ;
	box-shadow: 0px 0px 10px #222222;
	padding: 3px 3px 3px 3px;
	border-radius: 5px;
}
.port_about img {
	display: block;
}
.port_about h3 {
	margin-top: 2px;
	margin-bottom: 2px;
}
#slideshow-parent {
	background-color: black;
}
</style>
<?php
	require_once($_SERVER["DOCUMENT_ROOT"]."/service/svc_activity_feed.php");
	$results = svc_getActivityItems(3);


?>
<div class="port_activity">
	<h3>RECENT ACTIVITY</h3>
	<hr/>
	<?php include($_SERVER["DOCUMENT_ROOT"]."/activity/activity_table.php"); ?>
	<p></p>
	<input type="button" onClick="window.location='/activity'" class="sc-button" value="See All Activity" style="display: block; margin: 0 auto" />
</div>