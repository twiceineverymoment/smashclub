<html>
	<head>
		<link rel="stylesheet" href="/resource/dstyle.php" />
		<link rel="shortcut icon" href="/resource/favicon.ico" />
		<title>Tier Legend - SmashClub</title>
	</head>
	<body>
	<?php require_once($_SERVER['DOCUMENT_ROOT']."/navigation.php"); ?>
		<div id="banner">
			<img src="/customization/banner.png" class="banner-img" /> 
		</div>

	<?php require_once($_SERVER['DOCUMENT_ROOT']."/alertmessage.php"); ?>

		<div id="main" class="page-content">

		<h1>Tier Legend</h1>

			<div style="margin: 0 auto; text-align: center; display: block;">
				<div class="legend-block">
					<img src="/resource/emblem/E.png" />
					<h2>E Class</h2>
					<span>1-399</span>
				</div>
				<div class="legend-block">
					<img src="/resource/emblem/D.png" />
					<h2>D Class</h2>
					<span>400-599</span>
				</div>
				<div class="legend-block">
					<img src="/resource/emblem/C.png" />
					<h2>C Class</h2>
					<span>600-799</span>
				</div>
				<div class="legend-block">
					<img src="/resource/emblem/B.png" />
					<h2>B Class</h2>
					<span>800-999</span>
				</div>
				<div class="legend-block">
					<img src="/resource/emblem/A.png" />
					<h2>A Class</h2>
					<span>1000-1199</span>
				</div>
				<h3>Casual Tiers: No rating decay, No matchmaking restrictions</h3>
				<hr />
			</div>

			<div style="margin: 0 auto; text-align: center; display: block;">
				<div class="legend-block">
					<img src="/resource/emblem/bronze.png" />
					<h2>Bronze</h2>
					<span>1200-1399</span>
				</div>
				<div class="legend-block">
					<img src="/resource/emblem/silver.png" />
					<h2>Silver</h2>
					<span>1400-1599</span>
				</div>
				<div class="legend-block">
					<img src="/resource/emblem/gold.png" />
					<h2>Gold</h2>
					<span>1600-1799</span>
				</div>
				<div class="legend-block">
					<img src="/resource/emblem/platinum.png" />
					<h2>Platinum</h2>
					<span>1800-1999</span>
				</div>
				<h3>Competitive Tiers: Rating decay after 3 missed events, Can match within 600 points of each other</h3>
				<hr />
			</div>

			<div style="margin: 0 auto; text-align: center; display: block;">
				<div class="legend-block">
					<img src="/resource/emblem/diamond.png" />
					<h2>Master (3rd Class)</h2>
					<span>2000-2199</span>
				</div>
				<div class="legend-block">
					<img src="/resource/emblem/master.png" />
					<h2>Master (2nd Class)</h2>
					<span>2200-2499</span>
				</div>
				<div class="legend-block">
					<img src="/resource/emblem/grandmaster.png" />
					<h2>Master (1st Class)</h2>
					<span>2500 +</span>
				</div>
				<h3>Master Tiers: Rating decay after 2 missed events, Can match within 400 points of each other, cannot match with unranked players</h3>
				<h3>Masters above 3rd-class will drop out of this rank if their rating declines</h3>
			</div>

		</div>
	</body>
</html>