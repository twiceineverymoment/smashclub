<?php require_once($_SERVER['DOCUMENT_ROOT']."/customization/smashclub_theme.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT']."/service/svc_home_portal.php"); ?>
<style type="text/css">
.port_season {
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
.port_season h3 {
	margin-top: 2px;
	margin-bottom: 2px;
}
.port_season img {
	width: 128px;
	display: block;
	margin: 0 auto;
}
.port_season h2 {
	display: block;
	margin: 0 auto;
}
</style>
<?php
	$season_assoc = svc_getSeasonPortletData();
	$game = "";
?>
<div class="port_season">
	<h3>CURRENT SEASON</h3>
	<hr/>
	<div style="text-align: center;" />
	<img src=
	<?php
		switch($season_assoc['season_game']){
			case 0:
			echo "/resource/game/mixed.png";
			$game = "MIXED GAME";
			break;
			case 1:
			echo "/resource/game/n64.png";
			$game = "SMASH 64";
			break;
			case 2:
			echo "/resource/game/melee.png";
			$game = "MELEE";
			break;
			case 3:
			echo "/resource/game/brawl.png";
			$game = "BRAWL";
			break;
			case 4:
			echo "/resource/game/wiiu.png";
			$game = "SMASH 4";
			break;
			case 5:
			echo "/resource/game/switch.png";
			$game = "ULTIMATE";
			break;
		}
	?>
	/>
	<h2><?php echo $season_assoc['season_title']; ?></h2>
	<h3><?php if (svc_getSetting("CurrentSeasonNumber")!=0) echo $game; ?></h3>
	</div>
</div>