<html>
	<head>
		<link rel="stylesheet" href="/resource/dstyle.php" />
		<link rel="shortcut icon" href="/resource/favicon.ico" />
		<title>SmashClub</title>
		<script type="text/javascript">
		function validatePWs(){
			var pw1 = document.getElementById('new1').value;
			var pw2 = document.getElementById('new2').value;
			if (pw1==pw2){
				return true;
			} else {
				alert("Passwords do not match!");
				return false;
			}
		}
		</script>
	</head>
	<body>
	<?php require_once($_SERVER['DOCUMENT_ROOT']."/alertmessage_wide.php"); ?>
	<?php require_once($_SERVER['DOCUMENT_ROOT']."/service/svc_event_manager.php"); ?>
	<?php
	if ($_SESSION['type']==0 && !isset($_SESSION['expired'])){
		writeLog(2, "Anonymous user attempted to load CHANGE PASSWORD form");
		showErrorPage(401);
		die();
	}
	?>

		<div class="page-content">
			<div class="formpage-block">
				<?php if(isset($_SESSION['expired'])) : ?>
					<h2>Password Change Required</h2>
					<h3>Your password has expired and must be changed before you can log in.</h3>
				<?php else : ?>
					<h2>Change Your Password</h2>
				<?php endif; ?>
				<form action="/script/login.php" method="post" onsubmit="return validatePWs()">
					<span>Old / Current Password:</span>
					<input type="password" name="current" />
					<span>New Password:</span>
					<input type="password" name="newpass" id="new1" />
					<span>Confirm Password:</span>
					<input type="password" id="new2" />
					<input type="hidden" name="username" value=<?php echo $_SESSION['name']; ?> />
					<input type="submit" name="change" id="submit" value="Change Password" class="sc-button"/>
				</form>
			</div>
		</div>
	</body>
</html>