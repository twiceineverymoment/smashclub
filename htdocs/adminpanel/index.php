<?php require_once($_SERVER['DOCUMENT_ROOT']."/alertmessage.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT']."/service/svc_authentication.php"); ?>
<html>
	<head>
		<link rel="stylesheet" href="/resource/dstyle.php" />
		<link rel="shortcut icon" href="/resource/favicon.ico" />
		<?php
		//session_start();
		if($_SESSION['type']<3){
			writeLog(ALERT, "Page:ADMINPANEL requested by unauthorized user, IP: ".$_SERVER['REMOTE_ADDR']);
			showErrorPage(403);
			die();
			}
		?>
		<title>Admin Control Panel - SmashClub</title>
		<script type="text/javascript">
		function confirmAccountChange(){
			var dropdown = document.getElementById('action');
			var option = dropdown.options[dropdown.selectedIndex].value;

			if (option==8){
				return confirm('WARNING! This will remove all traces of this account from the system. All social and current ranking data will be lost. References to it in records may be invalidated. You cannot undo this action. Please disable the account instead if you want data to be retained. Do you wish to continue?');
			} else if (option==6){
				return confirm('Disabling this account will cause it to disappear from rankings and directories, but data will be retained. You can re-enable the account later. Do you wish to continue?');
			} else {
				return confirm('Are you sure? Please confirm this account change.');
			}
		}
		</script>
	</head>
	<body>
	<?php require_once($_SERVER['DOCUMENT_ROOT']."/navigation.php"); ?>
		<div id="banner">
			<img src="/customization/banner.png" class="banner-img" /> 
		</div>

		<div id="main" class="page-content">

		<h1>Admin Control Panel</h1>
		<h3>Use the options shown here to manage the site.</h3>
		<hr />

			<div class="acp-block">
				<h2>Member Accounts</h2>
				<div class="acp-icon">
					<a href="/register/">
					<img src="/resource/admincp/create_user.png" />
					Create Account
					</a>
				</div>
				<form class="acp-icon" action="/script/user_management.php" method="post" onsubmit="return confirmAccountChange();" >
					<h3>Manage Accounts</h3>
					Account: <select name="account">
						<?php echo svc_getAllAccountsHTML(); ?>
					</select><br />
					Action: <select name="action" value="bees" id="action">
						<option value="bees">Select...</option>
						<option value="0">Enable</option>
						<option value="1">Reset Password</option>
						<option value="2">Make Referee</option>
						<?php if($_SESSION['type']>=4) : ?>
						<option value="3">Make Officer</option>
						<option value="4">Make Admin</option>
						<?php endif; ?>
						<option value="5">Demote</option>
						<option value="6">Disable</option>
						<option value="7">Ban</option>
						<option value="8">Delete Account</option>
					</select>
					<input type="submit" class="sc-button" value="Go" id="acctmgmt" name="acctmgmt" />
				</form>
				<hr />
			</div>

			<div class="acp-block">
				<h2>Play Smash</h2>
				<?php $playstatus = svc_getSetting("TourneyStatus"); ?>
				<?php if($playstatus == 0) : ?>
					<div class="acp-icon">
						<a href="/forms/tourney_start.php">
						<img src="/resource/admincp/create_tourney.png" />
						Start Tourney
						</a>
					</div>
					<div class="acp-icon">
						<a href="/forms/start_game_event.php">
						<img src="/resource/admincp/start_tourney.png" />
						Start Event Play
						</a>
					</div>
					<div class="acp-icon">
						<a href="/forms/start_game_freeplay.php">
						<img src="/resource/admincp/open_matchmaking.png" />
						Start Free Play
						</a>
					</div>
				<?php elseif($playstatus == 3) : ?>
					<h3 style="display: block; vertical-align: middle">A matchmaking event is in progress.<br/>Players may join or leave early on the Events page.</h3>
					<?php if(svc_getSetting("MatchMakingQueueFreeze")==0) : ?>
					<div class="acp-icon">
						<a href="/script/mm_manage.php?action=pause">
						<img src="/resource/admincp/ico_pause_queue.png" />
						Freeze Queue
						</a>
					</div>
					<?php else : ?>
					<div class="acp-icon">
						<a href="/script/mm_manage.php?action=resume">
						<img src="/resource/admincp/ico_resume_queue.png" />
						Resume Queue
						</a>
					</div>
					<?php endif; ?>
					<div class="acp-icon">
						<a href="/script/mm_manage.php?action=stop">
						<img src="/resource/admincp/end_event.png" />
						End Event
						</a>
					</div>
				<?php elseif($playstatus == 2) : ?>
					<h3 style="display: block; vertical-align: middle">A tournament is starting up. Signups are currently open.<br/> When you are ready to close sign-ups, click Build Bracket.</h3>
					<div class="acp-icon">
						<a href="/forms/start_game_tourney.php">
						<img src="/resource/admincp/manage_tourney.png" />
						Build Bracket
						</a>
					</div>
					<div class="acp-icon">
						<a href="/script/tourney_update.php?action=close">
						<img src="/resource/admincp/disable_user.png" />
						Cancel Tournament
						</a>
					</div>
				<?php elseif($playstatus == 1) : ?>
					<h3 style="display: block; vertical-align: middle">A tournament is in progress.<br/>Click Start Matches to open the first round for score reporting.<br/>You may also use this button to refresh the bracket if you have to make modifications.</h3>
					<div class="acp-icon">
						<a href="/script/tourney_update.php?action=refresh">
						<img src="/resource/admincp/start_tourney.png" />
						Start/Refresh
						</a>
					</div>
					<div class="acp-icon">
						<a href="/script/tourney_update.php?action=opentmm">
						<img src="/resource/admincp/open_matchmaking.png" />
						Open Play
						</a>
					</div>
					<div class="acp-icon">
						<a href="/script/tourney_update.php?action=close">
						<img src="/resource/admincp/disable_user.png" />
						End Tournament
						</a>
					</div>
					<h3>Click "Open Play" to run a matchmaking queue alongside the tournament. This works well if you have multiple screens.</h3>
				<?php elseif($playstatus==4) : ?>
					<h3 style="display: block; vertical-align: middle">A tournament is in progress.<br/>Click Start Matches to open the first round for score reporting.<br/>You may also use this button to refresh the bracket if you have to make modifications.</h3>
					<div class="acp-icon">
						<a href="/script/tourney_update.php?action=refresh">
						<img src="/resource/admincp/start_tourney.png" />
						Start/Refresh
						</a>
					</div>
					<?php if(svc_getSetting("MatchMakingQueueFreeze")==0) : ?>
					<div class="acp-icon">
						<a href="/script/mm_manage.php?action=pause">
						<img src="/resource/admincp/ico_pause_queue.png" />
						Freeze Queue
						</a>
					</div>
					<?php else : ?>
					<div class="acp-icon">
						<a href="/script/mm_manage.php?action=resume">
						<img src="/resource/admincp/ico_resume_queue.png" />
						Resume Queue
						</a>
					</div>
					<?php endif; ?>
					<div class="acp-icon">
						<a href="/script/tourney_update.php?action=close">
						<img src="/resource/admincp/disable_user.png" />
						End Tournament
						</a>
					</div>

				<?php endif; ?>
				<hr />
			</div>

			<div class="acp-block">
				<h2>Scheduling</h2>
				
				<div class="acp-icon">
					<a href="/forms/event_create.php">
					<img src="/resource/admincp/create_event.png" />
					Create Event
					</a>
				</div>
				<!--
				<div class="acp-icon">
					<a href="#" onclick="alert('This feature coming soon!')">
					<img src="/resource/admincp/create_tourney.png" />
					Create Tourney
					</a>
				</div>
				-->
				<div class="acp-icon">
					<a href="/forms/event_manage.php">
					<img src="/resource/admincp/edit_events.png" />
					Manage Events
					</a>
				</div>
				<div class="acp-icon">
					<a href="/forms/event_review.php">
					<img src="/resource/admincp/attendance.png" />
					View Signups
					</a>
				</div>
				<div class="acp-icon">
					<a href="/forms/attendance.php">
					<img src="/resource/admincp/event_attendance.png" />
					Take Attendance
					</a>
				</div>
				<hr />
			</div>

			<div class="acp-block">
				<h2>Communication</h2>
				<?php if (svc_getSetting("TwitchOnAir")==0) : ?>
				<div class="acp-icon">
				<a href="/script/stream.php?live=1">
				<img src="/resource/admincp/go_live.png" />
				Open Live Stream
				</a>
				</div>
				<?php else : ?>
				<div class="acp-icon">
				<a href="/script/stream.php?live=0">
				<img src="/resource/admincp/go_live.png" />
				Close Live Stream
				</a>
				</div>
				<?php endif; ?>
				<div class="acp-icon">
					<a href="/forms/post_announcement.php">
					<img src="/resource/admincp/announcement.png" />
					Post Announcement
					</a>
				</div>
				<?php if (svc_getSetting("PollStatus")==0) : ?>
				<div class="acp-icon">
					<a href="/forms/poll_create.php">
					<img src="/resource/admincp/create_poll.png" />
					Create Poll
					</a>
				</div>
				<?php else : ?>
				<div class="acp-icon">
					<a href="/forms/poll_results.php">
					<img src="/resource/admincp/poll_results.png" />
					View Poll Results
					</a>
				</div>
				<div class="acp-icon">
					<a href="/script/poll_update.php?close" onclick="return confirm('Closing the poll will clear all responses. Are you sure?')">
					<img src="/resource/admincp/disable_user.png" />
					Close Poll
					</a>
				</div>
				<?php endif; ?>
				<hr />
			</div>
			<?php if($_SESSION['type']>=4) : ?>
			<div class="acp-block">
				<h2>Administration</h2>
				<?php if(svc_getSetting("CurrentSeasonNumber")==0) : ?>
				<div class="acp-icon">
					<a href="/forms/start_season.php">
					<img src="/resource/admincp/new_season.png" />
					Start New Season
					</a>
				</div>
				<?php else : ?>
				<div class="acp-icon">
					<a href="/script/end_season.php" onclick="return confirm('End the season? Current rankings will be moved to the Hall of Records. You cannot undo this action.')">
					<img src="/resource/admincp/new_season.png" />
					End Season
					</a>
				</div>
				<?php endif; ?>
				<div class="acp-icon">
					<a href="/forms/home_edit.php">
					<img src="/resource/admincp/site_settings.png" />
					Customize Homepage
					</a>
				</div>
				<div class="acp-icon">
					<a href="/forms/club_settings.php">
					<img src="/resource/admincp/access_settings.png" />
					Club Settings
					</a>
				</div>
				<div class="acp-icon">
					<a href="#" onclick="alert('This feature coming soon!')">
					<img src="/resource/admincp/alert_message.png" />
					Maintenance Message
					</a>
				</div>
				<div class="acp-icon">
					<a href="/logs/smashclub.log">
					<img src="/resource/admincp/cleanup.png" />
					Clean Up
					</a>
				</div>
			</div>
			<?php endif; ?>
		</div>
	</body>
</html>