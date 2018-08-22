<html>
	<head>
		<link rel="stylesheet" href="/resource/dstyle.php" />
		<link rel="shortcut icon" href="/resource/favicon.ico" />
		<title>Activity Feed - SmashClub</title>
	</head>
	<body>
	<?php require_once($_SERVER['DOCUMENT_ROOT']."/navigation.php"); ?>
		<div id="banner">
			<img src="/customization/banner.png" class="banner-img" /> 
		</div>

	<?php require_once($_SERVER['DOCUMENT_ROOT']."/alertmessage.php"); ?>

		<div id="main" class="page-content">
		<?php

		require_once($_SERVER['DOCUMENT_ROOT']."/service/svc_activity_feed.php");

		$results = svc_getActivityItems();

		?>

		<div class="activity-block" style="width: 75%">
		<h2>Activity Feed</h2>
		<h3>Announcements, milestones, and scores</h3>
		<table class="rank-list">

		<?php if (mysqli_num_rows($results)==0) : ?>
			<tr>
			<td colspan="2">
				There is no recent activity to show right now.
			</td>
			</tr>
		<?php endif; ?>

		<?php while($item = mysqli_fetch_assoc($results)) : ?>

			<?php if ($item['activity_type']==0) : ?>
				<tr>
				<td><?php echo svc_shortFormatDate(new DateTime($item['activity_time'])); ?><br/>
				Posted by <?php echo svc_getMemberNameByID($item['activity_owner_uuid']); ?></td>

				<td>
					<img src="/resource/admincp/announcement.png" class="feed-image" />
					<h3 style="display: inline-block"><?php echo $item['activity_header_html']; ?></h3><br/>
					<?php echo $item['activity_body_html']; ?>
				</td>
				</tr>
			<?php elseif ($item['activity_type']==1) : ?>
				<tr>
				<td><?php echo svc_shortFormatDate(new DateTime($item['activity_time'])); ?><br/>
				Recorded by <?php echo svc_getMemberNameByID($item['activity_owner_uuid']); ?></td>

				<td>
					<b>Match Results:</b><br/>
					<?php echo $item['activity_body_html']; ?>
				</td>
				</tr>
			<!--TODO: Implement type 2 and 3 activity feed items for tournaments -->
			<?php elseif ($item['activity_type']==4) : ?>
				<tr>
				<td><?php echo svc_shortFormatDate(new DateTime($item['activity_time'])); ?></td>

				<td>
					<b>A new event was scheduled:</b><br/>
					<img src="/resource/admincp/edit_events.png" class="feed-image"/>
					<h3 style="display: inline-block"><?php echo $item['activity_header_html']; ?></h3><br/>
					<?php echo $item['activity_body_html']; ?><br/>
					<b>Sign up on the <a href="/events/">Events</a> page!</b>
				</td>
				</tr>
			<?php elseif ($item['activity_type']==5) : ?>
				<tr>
				<td><?php echo svc_shortFormatDate(new DateTime($item['activity_time'])); ?></td>

				<td>
					<?php echo $item['activity_body_html']; ?>
				</td>
				</tr>
			<?php elseif ($item['activity_type']==6) : ?>
				<tr>
				<td><?php echo svc_shortFormatDate(new DateTime($item['activity_time'])); ?></td>

				<td>
					<?php echo $item['activity_body_html']; ?>
				</td>
				</tr>
			<?php elseif ($item['activity_type']==7) : ?>
				<tr>
				<td><?php echo svc_shortFormatDate(new DateTime($item['activity_time'])); ?></td>

				<td>
					<?php if(empty($item['activity_header_html'])) : ?>
						<b>The season has officially ended!</b>
					<?php else : ?>
						<b>A new season has started:</b><br/>
						<h3><?php echo $item['activity_header_html']; ?></h3>
					<?php endif; ?>
				</td>
				</tr>
			<?php elseif ($item['activity_type']==8) : ?>
				<tr>
				<td><?php echo svc_shortFormatDate(new DateTime($item['activity_time'])); ?></td>

				<td>
					<?php if(empty($item['activity_header_html'])) : ?>
						<b>The current poll has closed!</b>
					<?php else : ?>
						<b>A new poll has been created:</b><br/>
						<h3><?php echo $item['activity_header_html']; ?></h3>
					<?php endif; ?>
				</td>
				</tr>
			<?php elseif ($item['activity_type']==9) : ?>
				<tr>
				<td><?php echo svc_shortFormatDate(new DateTime($item['activity_time'])); ?></td>

				<td>
					<b>An event was changed:</b><br/>
					<img src="/resource/admincp/edit_events.png" class="feed-image"/>
					<h3 style="display: inline-block"><?php echo $item['activity_header_html']; ?></h3><br/>
					<?php echo $item['activity_body_html']; ?><br/>
				</td>
				</tr>
			<?php endif; ?>
		<?php endwhile; ?>
		</table>
		</div>
		</div>
	</body>
</html>