<html>
	<head>
		<link rel="stylesheet" href="/resource/dstyle.php" />
		<link rel="shortcut icon" href="/resource/favicon.ico" />
		<title>Error - SmashClub</title>
	</head>
	<body>
	<?php require_once($_SERVER['DOCUMENT_ROOT']."/navigation.php"); ?>
		<div id="banner">
			<img src="/customization/banner.png" class="banner-img" /> 
		</div>

	<?php require_once($_SERVER['DOCUMENT_ROOT']."/alertmessage.php"); ?>

		<div id="main" class="page-content">

		<?php
		$err = $_GET['e'];
		http_response_code($err);

		switch($err){
			case 400:
			echo "<h1>Looking for a Secured Page?</h1>";
			echo "<h3>SmashClub can't display this page. It looks like you've tried to reach an invalid page or submitted a form without authorization. Your IP address has been logged. If you believe this is a bug, please contact the club's site admin.</h3>";
			echo "<h3><i>HTTP Code 400 - Bad Request</i></h3>";
			writeLog(ALERT, "400 - BAD REQUEST, errorpage served to ".$_SERVER['REMOTE_ADDR']);
			break;
			case 401:
			echo "<h1>Please Log In</h1>";
			echo "<h3>You must be logged in to access that page. Please log in and try again.</h3>";
			echo "<h3><i>HTTP Code 401 - Unauthorized</i></h3>";
			writeLog(ALERT, "401 - UNAUTHORIZED, errorpage served to ".$_SERVER['REMOTE_ADDR']);
			break;
			case 403:
			echo "<h1>Access Denied</h1>";
			echo "<h3>You don't currently have permission to access that page. Contact the club's site admin to request permission. Your IP address has been logged.</h3>";
			echo "<h3><i>HTTP Code 403 - Forbidden</i></h3>";
			writeLog(ALERT, "403 - FORBIDDEN, errorpage served to ".$_SERVER['REMOTE_ADDR']);
			break;
			case 404:
			echo "<h1>Page Not Found</h1>";
			echo "<h3>That page was not found. You may have clicked a broken link, or maybe your spelling was off. Check your link and try again!</h3>";
			echo "<h3><i>HTTP Code 404 - Not Found</i></h3>";
			writeLog(INFO, "404 - NOT FOUND (".$_SERVER['REQUEST_URI']."), errorpage served to ".$_SERVER['REMOTE_ADDR']);
			break;
			case 405:
			echo "<h1>Access Denied</h1>";
			echo "<h3>The link you have followed is not valid. Please return to the homepage and try again. Your IP address has been logged.</h3>";
			echo "<h3><i>HTTP Code 405 - Method Not Allowed</i></h3>";
			writeLog(ALERT, "405 - METHOD NOT ALLOWED, errorpage served to ".$_SERVER['REMOTE_ADDR']);
			break;
			case 500:
			echo "<h1>Error</h1>";
			echo "<h3>Sorry! SmashClub has encountered an internal error. Please contact the site admins to report this problem so we can get it fixed as soon as possible. Be sure to let them know what you were trying to do when you received this error.</h3>";
			echo "<h3><i>HTTP Code 500 - Internal Server Error</i></h3>";
			writeLog(ERROR, "500 - INTERNAL SERVER ERROR, errorpage served to ".$_SERVER['REMOTE_ADDR']);
			break;
			case 503:
			echo "<h1>SmashClub is Unavailable</h1>";
			echo "<h3>Sorry! The system is currently unavailable due to scheduled maintenance or a technical problem. Please try again later.</h3>";
			echo "<h3><i>HTTP Code 503 - Service Unavailable</i></h3>";
			writeLog(SEVERE, "503 - SERVICE UNAVAILABLE, errorpage served to ".$_SERVER['REMOTE_ADDR']);
			break;
		}

		?>
		
		</div>
	</body>
</html>