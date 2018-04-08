<html>
	<head>
		<link rel="stylesheet" href="/resource/dstyle.php" />
		<link rel="shortcut icon" href="/resource/favicon.ico" />
		<title>User: <?php echo $_GET['u']; ?> - SmashClub</title>
	</head>
	<body>
	<?php require_once($_SERVER['DOCUMENT_ROOT']."/navigation.php"); ?>
		<div id="banner">
			<img src="/customization/banner.png" class="banner-img" /> 
		</div>
		<?php require_once($_SERVER['DOCUMENT_ROOT']."/alertmessage.php"); ?>
		<div id="main" class="page-content">
		<?php
		require_once($_SERVER['DOCUMENT_ROOT']."/service/svc_member_lookup.php");
		$profile = svc_getFullMemberProfile($_GET['u']);
		$joindate = date_format(new DateTime($profile['date_member_join']), "F Y");
		$pmleft = $profile['rank_placements'];
		$pminit = svc_getSetting("InitialPlacementMatches");
		?>

		<?php if(svc_getSetting("EnableGuestProfileView")=="0" and $_SESSION['type']==0) : ?>
			<h1>Private Profile</h1>
			<h3>You must be logged in to view member profiles. Don't have an account? <a href="/register/">Register</a> now!</h3>
		<?php elseif($profile=="404") : ?>
			<h1>Ummm...</h1>
			<h3>That profile was not found. The account may have been renamed, banned, or deleted.</h3>
		<?php else : ?>

			<?php if ($_SESSION['name']==$_GET['u']) : ?>
				<div style="width: 50%; margin: 0 auto;">
					<input class="sc-button" onclick="window.location='edit'" type="button" value="Edit Details" style="float: right"/>
					<h1>Your Public Profile</h1>
				</div>
			<?php endif; ?>

			<div class="pview-block">
				<div id="pview-title">
					<img id="pview-image" src=<?php echo "'/resource/character/".$profile['prof_main_character'].".png'"; ?> />
					<h2><?php echo $profile['user_username']; ?></h2>
					<h3>Member since <?php echo $joindate; ?></h3>
				</div>
				<div id="pview-ranks">
					<?php if(svc_getSetting("CurrentSeasonNumber")==0) : ?>
					<div id="pview-rank-top">
						<h1>-</h1>
						<?php /* <img class="pview-rank-emblem" src=<?php echo svc_getEmblemByRank($profile['rank_current'], $profile['rank_season_high']); ?> /> */ ?>
						<h2>OFF SEASON</h2>
					</div>
					<div id="pview-rank-extra">
						<h1>-</h1>
						<h2>SEASON HIGH</h2>
					</div>
					<div id="pview-rank-extra">
						<h1><?php echo $profile['rank_career_high']; ?></h1>
						<h2>ALL-TIME HIGH</h2>
					</div>
					<?php elseif($profile['rank_placements']==0) : ?>
					<div id="pview-rank-top">
						<h1><?php echo $profile['rank_current']; ?></h1>
						<img class="pview-rank-emblem" src=<?php echo svc_getEmblemByRank($profile['rank_current'], $profile['rank_season_high']); ?> />
						<h2>CURRENT</h2>
					</div>
					<div id="pview-rank-extra">
						<h1><?php echo $profile['rank_season_high']; ?></h1>
						<h2>SEASON HIGH</h2>
					</div>
					<div id="pview-rank-extra">
						<h1><?php echo $profile['rank_career_high']; ?></h1>
						<h2>ALL-TIME HIGH</h2>
					</div>
					<?php else : ?>
					<div id="pview-rank-top">
						<h1>?</h1>
						<?php /* <img class="pview-rank-emblem" src=<?php echo svc_getEmblemByRank($profile['rank_current'], $profile['rank_season_high']); ?> /> */ ?>
						<h2><?php echo ($pminit - $pmleft)." / ".$pminit; ?> PLACEMENT MATCHES COMPLETED</h2>
					</div>
					<div id="pview-rank-extra">
						<h1>?</h1>
						<h2>SEASON HIGH</h2>
					</div>
					<div id="pview-rank-extra">
						<h1><?php echo $profile['rank_career_high']; ?></h1>
						<h2>ALL-TIME HIGH</h2>
					</div>
					<?php endif; ?>
				</div>
				<?php if (!empty($profile['prof_catchphrase'])) : ?>
				<div id="pview-catchphrase">
					&quot;<?php echo $profile['prof_catchphrase']; ?>&quot;
				</div>
				<?php endif; ?>
				<div id="pview-connects">
				<?php if ($_SESSION['type']>0) : ?>
					<div class="pview-connect-box">
					<img src="/resource/tab_profile.png" /> 
					<?php echo $profile['prof_first_name']." ".$profile['prof_last_name']; ?>
					</div>
				<?php endif; ?>
				<?php

				if (!empty($profile['prof_connect_nintendo'])){
					echo "<div class='pview-connect-box'><img src='/resource/connect/nintendo.png' /> ".$profile['prof_connect_nintendo']."</div> ";
				}

				if (!empty($profile['prof_connect_xbox'])){
					echo "<div class='pview-connect-box'><img src='/resource/connect/xboxlive.png' /> ".$profile['prof_connect_xbox']."</div> ";
				}

				if (!empty($profile['prof_connect_psn'])){
					echo "<div class='pview-connect-box'><img src='/resource/connect/playstation.png' /> ".$profile['prof_connect_psn']."</div> ";
				}

				if (!empty($profile['prof_connect_steam'])){
					echo "<div class='pview-connect-box'><img src='/resource/connect/steam.png' /> ".$profile['prof_connect_steam']."</div> ";
				}

				if (!empty($profile['prof_connect_origin'])){
					echo "<div class='pview-connect-box'><img src='/resource/connect/origin.png' /> ".$profile['prof_connect_origin']."</div> ";
				}

				if (!empty($profile['prof_connect_other_name'])){
					echo "<div class='pview-connect-box'><img src='/resource/connect/other.png' /> <b>".$profile['prof_connect_other_name'].": </b>".$profile['prof_connect_other_value']."</div> ";
				}

				if ($profile['prof_show_email']==1 or $_SESSION['type']>1){
					echo "<div class='pview-connect-box'><img src='/resource/connect/email.png' /> ".$profile['prof_email_address']."</div> ";
				}

				if ($profile['prof_show_phone']==1 or $_SESSION['type']>1){
					$num = (string) $profile['prof_phone_number'];
					echo "<div class='pview-connect-box'><img src='/resource/connect/phone.png' /> (".substr($num, 0, 3).") ".substr($num, 3, 3)."-".substr($num, 6)."</div> ";
				}

				?>
				</div>
			</div>

		<?php endif; ?>
		</div>
	</body>
</html>