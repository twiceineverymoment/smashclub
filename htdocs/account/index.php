<html>
	<head>
		<link rel="stylesheet" href="/resource/dstyle.php" />
		<link rel="shortcut icon" href="/resource/favicon.ico" />
		<?php
		session_start();
		if($_SESSION['type']<1){
			echo "<meta http-equiv='refresh' content='0 url=/errorpage/?e=401' />";
			writeLog(2, "User ".$_SESSION['name']." was denied access to the My Account page!");
			}
		?>
		<title>My Account - SmashClub</title>
	<script type="text/javascript">
	function confirmDisable(){
		if (confirm("WARNING: You are about to disable your account. This will not delete your information, but it will hide it from view and lock you out of the account. You must contact an officer to re-enable your account. Do you want to continue?")){
			window.location="/script/user_disable_self.php";
		}
	}
	</script>
	</head>
	<body>
	<?php require_once($_SERVER['DOCUMENT_ROOT']."/navigation.php"); ?>
		<div id="banner">
			<img src="/customization/banner.png" class="banner-img" /> 
		</div>

	<?php require_once($_SERVER['DOCUMENT_ROOT']."/alertmessage.php"); ?>

		<div id="main" class="page-content">

		<div class="acp-block">
				<h2>Manage Your Account</h2>
				
				<div class="acp-icon">
					<a href="/forms/change_password.php">
					<img src="/resource/admincp/change_password.png" />
					Change Password
					</a>
				</div>
				<div class="acp-icon">
					<a href="/forms/contact_change.php">
					<img src="/resource/admincp/edit_contact.png" />
					Edit Contact Info
					</a>
				</div>
				<div class="acp-icon">
					<a href="/profile/edit/">
					<img src="/resource/admincp/manage_tourney.png" />
					Edit Profile
					</a>
				</div>
				<div class="acp-icon">
					<a href="#" onclick="confirmDisable()">
					<img src="/resource/admincp/disable_user.png" />
					Disable Account
					</a>
				</div>
			</div>

		</div>
	</body>
</html>