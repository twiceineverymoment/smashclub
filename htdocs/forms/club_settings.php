<html>
	<head>
		<link rel="stylesheet" href="/resource/dstyle.php" />
		<link rel="shortcut icon" href="/resource/favicon.ico" />
		<title>SmashClub</title>
	</head>
	<body>
	<?php require_once($_SERVER['DOCUMENT_ROOT']."/alertmessage_wide.php"); ?>
	<?php require_once($_SERVER['DOCUMENT_ROOT']."/service/svc_site_settings.php"); ?>
	<?php require_once($_SERVER['DOCUMENT_ROOT']."/service/svc_home_portal.php"); ?>
	<?php
	if ($_SESSION['type']<4){
		writeLog(ALERT, "Form:CLUB_SETTINGS requested by unauthorized user, IP: ".$_SERVER['REMOTE_ADDR']);
		showErrorPage(401);
		die();
	}

	if (isset($_POST['save'])){
		svc_putSetting("OrganizationName", $_POST["orgname"]);
		svc_putSetting("AboutPageSubtitle", $_POST["subtitle"]);
		svc_putSetting("AboutPageBody", $_POST["about"]);
		svc_putSetting("DonateURL", $_POST["donateLink"]);
		if ($_POST["donateEnable"] == "on"){
			svc_putSetting("EnableDonatePortlet", 1);
		} else {
			svc_putSetting("EnableDonatePortlet", 0);
		}
		if ($_POST["slideshowSpeed"] != "nochg") {
			svc_putSetting("SlideshowInterval", $_POST["slideshowSpeed"]);
		}
		showJavascriptAlert("Your changes have been saved.");
		sendBack();
	}

	?>

		<div class="page-content" style="text-align: center">
			<h2>Club Settings</h2>
			<h3>This page contains site-wide settings related to privacy and page access.</h3>
			<div class="formpage-block">
				<h2>Privacy</h2>
				<form action=<?php echo $_SERVER['PHP_SELF']; ?> method="post">
					<span style="width: 73%"><b>Guest Browsing: </b>Guests (users not signed in) can see the Members, Events, and Activity pages. Personal information will not be shown unless signed in. <span style="color: yellow; display: inline">NOTE: Disabling this setting will prevent guests from signing up for events.</span></span>
					<input type="checkbox" name="donateEnable" value="on" style="width: 23%" <?php echo (svc_getSetting('EnableGuestBrowsing')==1) ? 'checked' : '';?> />
					<span style="width: 73%"><b>Guest Directory: </b>Guests can see all members on the Members tab. If this is disabled, guests will only see officers and admins.</span></span>
					<input type="checkbox" name="donateEnable" value="on" style="width: 23%" <?php echo (svc_getSetting('GuestEnableFullMemberList')==1) ? 'checked' : '';?> />
					<span style="width: 73%"><b>Guest Profile Viewing: </b>Guests can see members' profiles. Personal info such as real name will not be shown.</span></span>
					<input type="checkbox" name="donateEnable" value="on" style="width: 23%" <?php echo (svc_getSetting('EnableGuestProfileView')==1) ? 'checked' : '';?> />
					<p>&nbsp;</p>
					<input type="submit" name="subPrivacy" value="Save Settings" class="sc-button" />
				</form>
			</div>
			<br />
			<div class="formpage-block">
				<h2>Registration</h2>
				<form action=<?php echo $_SERVER['PHP_SELF']; ?> method="post">
					<span style="width: 73%"><b>Open Registration: </b>Allow anyone browsing the site to register for an account. If this is turned off, only scorekeepers and officials can create accounts for new members.</span>
					<input type="checkbox" name="donateEnable" value="on" style="width: 23%" <?php echo (svc_getSetting('EnableSelfRegister')==1) ? 'checked' : '';?> />
					<span style="width: 73%"><b>Enable Guest Registration: </b>Guests signing up for certain events will have a guest account created for them, which can participate in the event and be converted into a full account later.</span>
					<input type="checkbox" name="donateEnable" value="on" style="width: 23%" <?php echo (svc_getSetting('EnableGuestAccounts')==1) ? 'checked' : '';?> />
					<p>&nbsp;</p>
					<input type="submit" name="subRegistration" value="Save Settings" class="sc-button" />
				</form>
			</div>
			<br />
			<div class="formpage-block">
				<h2>Messaging</h2>
				<form action=<?php echo $_SERVER['PHP_SELF']; ?> method="post">
					<!--TODO -->
					<input type="submit" name="subMessaging" value="Save Settings" class="sc-button" />
				</form>
			</div>
			<br />
			<div class="formpage-block">
				<h2>Twitch Streaming</h2>
				<form action=<?php echo $_SERVER['PHP_SELF']; ?> method="post">
					<span style="width: 73%">Enter your club's Twitch channel ID here:</span>
					<input type="text" name="channelId" value="<?php echo svc_getSetting('TwitchChannelID'); ?>" style="width: 23%" />
					<p>&nbsp;</p>
					<input type="submit" name="subStreaming" value="Save Settings" class="sc-button" />
				</form>
			</div>
			<br />
			<div class="formpage-block">
				<h2>Ranks &amp; Records</h2>
				<form action=<?php echo $_SERVER['PHP_SELF']; ?> method="post">
					<span style="width: 73%"><b>Rankings Sort Order: </b>Set the default sort order for the Rankings tab.</span>
					<select name="rankOrder" style="width: 23%">
						<option value="nochg">Select...</option>
						<option value="0">Current Rank (High to Low)</option>
						<option value="1">Current Rank (Low to High)</option>
						<option value="2">Season High (High to Low)</option>
						<option value="3">All-Time High (High to Low)</option>
						<option value="4">Username (A to Z)</option>
					</select>
					<span style="width: 73%"><b>Ordered Ranks: </b>Show a numbered 'Rank' column on the Rankings tab.</span>
					<input type="checkbox" name="showRankColumn" value="on" style="width: 23%" <?php echo (svc_getSetting('ShowRankColumn')==1) ? 'checked' : '';?> />
					<span style="width: 73%"><b>Allow Manual Scoring: </b>Allow users with Scorekeeper privilege to manually report scores. If this is turned off, scorekeepers can only report scores during tournaments or matchmaking.</span>
					<input type="checkbox" name="freeplayScore" value="on" style="width: 23%" <?php echo (svc_getSetting('EnableFreePlayScoring')==1) ? 'checked' : '';?> />
					<p>&nbsp;</p>
					<input type="submit" name="subRanks" value="Save Settings" class="sc-button" />
				</form>
			</div>
			<br />
			<?php if (svc_getSetting("CurrentSeasonNumber")=="0") : ?>
				<div class="formpage-block">
				<h2>Calculations</h2>
				<h3 style="color: orange">Warning: These settings govern the calculation of rankings. You should not adjust these values unless you know what you're doing!</h3>
				<form action=<?php echo $_SERVER['PHP_SELF']; ?> method="post">
					<span style="width: 73%"><b>A Constant: </b>Set the value of A in the rank curve. Higher values equal a steeper curve.</span>
					<input type="text" name="primCons" value="<?php echo svc_getSetting('RankCalcPrimConstant'); ?>" style="width: 23%" />
					<span style="width: 73%"><b>Loss Scalar: </b>Set the scalar value for the ratio of win yield vs. loss yield.</span>
					<input type="text" name="lossScale" value="<?php echo svc_getSetting('RankCalcLossScalar'); ?>" style="width: 23%" />
					<span style="width: 73%"><b>Streak Interval: </b>Set the initial threshold for winning and losing streak multipliers.</span>
					<input type="number" name="streakInt" value="<?php echo svc_getSetting('WinningStreakInterval'); ?>" style="width: 23%" min="2" max="100" />
					<p>&nbsp;</p>
					<input type="submit" name="subCalculations" value="Save Settings" class="sc-button" />
				</form>
				</div>
				<br />
			<?php else : ?>
				<div class="formpage-block">
				<h2>Calculations</h2>
				<h3 style="color: orange">Warning: These settings govern the calculation of rankings. You should not adjust these values unless you know what you're doing!</h3>
				<form action=<?php echo $_SERVER['PHP_SELF']; ?> method="post">
					<span style="width: 73%"><b>A Constant: </b>Set the value of A in the rank curve. Higher values equal a steeper curve.</span>
					<input type="text" name="primCons" value="<?php echo svc_getSetting('RankCalcPrimConstant'); ?>" style="width: 23%" disabled/>
					<span style="width: 73%"><b>Loss Scalar: </b>Set the scalar value for the ratio of win yield vs. loss yield.</span>
					<input type="text" name="lossScale" value="<?php echo svc_getSetting('RankCalcLossScalar'); ?>" style="width: 23%" disabled/>
					<span style="width: 73%"><b>Streak Interval: </b>Set the initial threshold for winning and losing streak multipliers.</span>
					<input type="number" name="streakInt" value="<?php echo svc_getSetting('WinningStreakInterval'); ?>" style="width: 23%" min="2" max="100" disabled/>
					<p>&nbsp;</p>
					<span><i>These values cannot be changed in the middle of a season.</i></span>
				</form>
			</div>
			<br />
			<?php endif; ?>
		</div>
	</body>
</html>