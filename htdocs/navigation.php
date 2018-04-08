<div id="sidebar" class="sidebar">
<?php
	
	require_once($_SERVER['DOCUMENT_ROOT']."/service/svc_site_settings.php");
	$orgname = svc_getSetting("OrganizationName");
	$guestmode = svc_getSetting("EnableGuestBrowsing");
	//session_start();
	$eventActive = svc_getSetting("TourneyStatus");
	?>

	<table style="height: 100%; border-collapse: collapse; margin: 0 auto;">

	<tr><td valign="top">

	<div class="sidebarlink">
		<img src="/resource/tab_home.png" width="50" />
		<a href="/"><b><?php echo $orgname; ?></b></a>
	</div>

	<?php if ($_SESSION['type']>0 and $eventActive>=3) : ?>
	<div class="sidebarlink">
		<img src="/resource/tab_matchmaking.png" width="50" />
		<?php if (svc_getSetting("EventIsRanked")==1) : ?>
			<a href="/matchmaking/" style="color: orange !important">Matchmaking</a>
		<?php else : ?>
			<a href="/matchmaking/" style="color: mediumseagreen !important">Matchmaking</a>
		<?php endif; ?>
	</div>
	<?php endif; ?>
	<?php if ($_SESSION['type']>0 and in_array($eventActive, array(1, 2, 4))) : ?>
	<div class="sidebarlink">
		<img src="/resource/tab_tourney.png" width="50" />
		<a href="/tourney/" style="color: orangered !important">Tournament</a>
	</div>
	<?php endif; ?>

	<?php if($guestmode=='1' or $_SESSION['type']>0) : ?>
	<div class="sidebarlink">
		<img src="/resource/tab_members.png" width="50" />
		<a href="/directory/">Members</a>
	</div>
	<div class="sidebarlink">
		<img src="/resource/tab_activity.png" width="50" />
		<a href="/activity/">Activity</a>
	</div>
	<div class="sidebarlink">
		<img src="/resource/tab_events.png" width="50" />
		<a href="/events/">Events</a>
	</div>
	<?php endif; ?>

	<?php if ($_SESSION['type']>0) : ?>
	<div class="sidebarlink">
		<img src="/resource/tab_leaderboard.png" width="50" />
		<a href="/leaderboard/">Rankings</a>
	</div>
	<div class="sidebarlink">
		<img src="/resource/tab_records.png" width="50" />
		<a href="/records/">Records</a>
	</div>
	<div class="sidebarlink">
		<img src="/resource/tab_polls.png" width="50" />
		<a href="/poll/">Polls</a>
	</div>
	<div class="sidebarlink">
		<img src="/resource/tab_profile.png" width="50" />
		<a href=<?php echo "/profile/?u=".$_SESSION['name']; ?>>My Profile</a>
	</div>
	<?php else : ?>
	<div class="sidebarlink">
		<img src="/resource/tab_contact.png" width="50" />
		<a href="/contact/">Contact</a>
	</div>
	<?php endif; ?>

	<?php if ($_SESSION['type']>1) : ?>
		<div class="sidebarlink">
		<img src="/resource/tab_scoreentry.png" width="50" />
		<a href="/scoring/">Score Entry</a>
		</div>
	<?php endif; ?>

	<?php if ($_SESSION['type']>2) : ?>
		<div class="sidebarlink">
		<img src="/resource/tab_administration.png" width="50" />
		<a href="/adminpanel/">Admin Panel</a>
		</div>
	<?php endif; ?>

	</td></tr>
	<tr><td valign="bottom">

	<div class="footer" style="margin: 0 auto">
	<?php if ($_SESSION['type']==0) : ?>
		<form name='loginform' action='/script/login.php' method='POST'>
		<div class="login">
			E-mail: <input type='email' size='15' name='username' required/><br />
			Password: <input type='password' size='15' name='password' required/><br />
		</div>
		<br />
		<input type='submit' value='Log In' class="sc-button" />
		<input type='button' onClick="window.location='/register/'" value='Sign Up' class="sc-button" />
		<br/><br/><a id="forgot-password" href="/forms/forgot_password.php">Forgot Password?</a>
		</form>
	<?php else : ?>
		<h3>Hello, <?php echo svc_getFirstNameForNavBar($_SESSION['uuid']); ?> </h3>
		<input type='button' onClick="window.location='/account/'" value='My Account' class="sc-button" />
		<input type='button' onClick="window.location='/script/logout.php'" value='Log Out' class="sc-button" />
	<?php endif; ?>
	<p>SmashClub v<?php echo svc_getSetting("Version"); ?>
	<br/><a href="/about/">About This App</a>
	</p>
	</div>

	</td></tr>
	</table>

</div>