<?php require_once($_SERVER['DOCUMENT_ROOT']."/customization/smashclub_theme.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT']."/service/svc_activity_feed.php"); ?>
<style type="text/css">
.port_social {
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
.port_social h3 {
	margin-top: 2px;
	margin-bottom: 2px;
}
.social-row {
	width: 48%;
	display: inline-block;
	margin-bottom: 5px;
}
.social-row img {
	width: 32px;
	height: 32px;
	vertical-align: middle;
}
.social-row a:link, .social-row a:visited {
	color: <?php echo $theme['BlockTextColor']; ?> ;
	text-decoration: none;
}
.social-row a:hover {
	text-decoration: underline;
}
</style>
<?php
	$fbname = svc_getSetting("Facebook.PageName");
	$fblink = svc_getSetting("Facebook.Handle");
	$ytlink = svc_getSetting("YouTube.Handle");
	$twlink = svc_getSetting("Twitter.Handle");
	$twitch = svc_getSetting("TwitchChannelID");

?>
<div class="port_social">
	<h3>FIND US ON SOCIAL MEDIA</h3>
	<hr/>
	<?php if (!empty($fbname)) : ?>	
	<div class="social-row">
	<img src="/resource/connect/facebook.png" />&nbsp;
	<h3 style="display: inline"><a href=<?="https://www.facebook.com/".$fblink;?> target="_blank"><?php echo $fbname; ?></a></h3>
	</div>
	<?php endif; ?>
	<?php if (!empty($twlink)) : ?>	
	<div class="social-row">
	<img src="/resource/connect/twitter.png" />&nbsp;
	<h3 style="display: inline"><a href=<?="https://www.twitter.com/".$twlink;?> target="_blank"><?php echo $twlink; ?></a></h3>
	</div>
	<?php endif; ?>
	<?php if (!empty($ytlink)) : ?>	
	<div class="social-row">
	<img src="/resource/connect/youtube.png" />&nbsp;
	<h3 style="display: inline"><a href=<?="https://www.youtube.com/".$ytlink;?> target="_blank"><?php echo $ytlink; ?></a></h3>
	</div>
	<?php endif; ?>
	<?php if (!empty($twitch)) : ?>	
	<div class="social-row">
	<img src="/resource/connect/twitch.png" />&nbsp;
	<h3 style="display: inline"><a href=<?="https://www.twitch.tv/".$twitch;?> target="_blank"><?php echo $twitch; ?></a></h3>
	</div>
	<?php endif; ?>
</div>