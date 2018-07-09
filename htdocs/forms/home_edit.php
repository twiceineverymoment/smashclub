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
		writeLog(ALERT, "Form:HOME_EDIT requested by unauthorized user, IP: ".$_SERVER['REMOTE_ADDR']);
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
			<h2>Customize Homepage</h2>
			<div class="formpage-block">
				<h3>About Your Organization</h3>
				<form action=<?php echo $_SERVER['PHP_SELF']; ?> method="post">
					<span>Club Name:</span>
					<input type="text" name="orgname" maxlength="64" value="<?php echo svc_getSetting('OrganizationName'); ?>" />
					<hr />
					<span>About Page Heading &amp; Body Text:</span>
					<input type="text" name="subtitle" maxlength="64" value="<?php echo svc_getSetting('AboutPageSubtitle'); ?>" />
					<br />
					<textarea name="about"><?php echo svc_getSetting("AboutPageBody"); ?></textarea>
					<span>Show the Donate link on the homepage?</span>
					<input type="checkbox" name="donateEnable" value="on" style="width: 48%" <?php echo (svc_getSetting('EnableDonatePortlet')==1) ? 'checked' : '';?> />
					<span>Link to your external donor site:</span>
					<input type="text" name="donateLink" maxlength="1024" value="<?php echo svc_getSetting('DonateURL'); ?>" />
					<br /><br />
					<span>Slideshow Speed:</span>
					<select name="slideshowSpeed">
						<option value="nochg">Select...</option>
						<option value="2000">Fast (2s)</option>
						<option value="4000">Medium (4s)</option>
						<option value="6000">Slow (6s)</option>
						<option value="8000">Very Slow (8s)</option>
					</select>
					<p><i>Use the file panel below to add or remove slideshow photos.</i></p>
					<input type="submit" name="save" class="sc-button" value="Save Changes" />
				</form>
			</div>
			<div class="formpage-block">
				<h3>Photos</h3>
				<form action="/script/image_upload.php" method="post" enctype="multipart/form-data">
					<span>Upload a Photo:</span>
					<input type="file" name="imgUpload" />
					<span><i>Images must be in .JPG or .PNG format. Max filesize is 2 MB.</i></span>
					<input type="submit" name="upload" class="sc-button" value="Upload" />
					<br /><br />
					<p>Photos in slideshow:</p>
					<table class="rank-list">
					<?php
						$directory = $_SERVER['DOCUMENT_ROOT']."/customization/slideshow/";
						$images = glob($directory . "*.{jpg,png}", GLOB_BRACE);
						foreach ($images as $image){
							echo "<tr><td>
							<input type='checkbox' name='files[]' value=\"".basename($image)."\" />
							</td><td>
							".basename($image)."
							</td></tr>";
						}
					?>
					</table>
					<input type="submit" name="delete" class="sc-button" style="background-color: firebrick" value="Delete Selected" />
				</form>
			</div>
		</div>
	</body>
</html>