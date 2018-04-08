<?php require_once($_SERVER['DOCUMENT_ROOT']."/customization/smashclub_theme.php"); ?>
<style type="text/css">
.port_about {
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
	$clubName = svc_getSetting("OrganizationName");
	$subtitle = svc_getSetting("AboutPageSubtitle");
	$body = svc_getSetting("AboutPageBody");
?>
<div class="port_about">
	<h3>WELCOME TO <?php echo strtoupper($clubName); ?></h3>
	<hr/>
	<div id='slideshow-parent' align='center'>
	<?php include("slideshow.php"); ?>
	</div>
	<h2><?php echo $subtitle; ?></h2>
	<p>
	<?php echo $body; ?>
	</p>
</div>