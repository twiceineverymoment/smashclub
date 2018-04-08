<?php require_once($_SERVER['DOCUMENT_ROOT']."/customization/smashclub_theme.php"); ?>

body {
	background-color: <?php echo $theme['MainBackgroundColor']; ?> ;
	font-family: MavenPro;
	color: <?php echo $theme['MainTextColor']; ?> ;
	font-size: 12px;
	margin: 0px;
}

/* The side navigation menu */
.sidebar {
    height: 100%; /* 100% Full-height */
	width: 250px;
    position: fixed; /* Stay in place */
    display: inline-block;
    z-index: 1; /* Stay on top */
    top: 0;
    left: 0;
    background-color: <?php echo $theme['SidebarBackgroundColor']; ?> ;
    overflow-x: hidden; /* Disable horizontal scroll */
    transition: 0.5s; /* 0.5 second transition effect to slide in the sidenav */
    box-shadow: inset 0px 0px 20px black;
}

/* The navigation menu links */
.sidebar .sidebarlink {
    padding: 8px 8px 8px 32px;
    text-decoration: none;
    font-size: 25px;
    color: <?php echo $theme['SidebarTextColor']; ?> ;
    display: block;
    transition: 0.3s
}

.sidebarlink img {
	display: inline;
	width: 36px;
	vertical-align: middle;
}

.sidebarlink a {
	font-family: MavenPro;
    text-decoration: none;
    font-size: 25px;
    color: <?php echo $theme['SidebarTextColor']; ?> !important ;
    display: inline;
    transition: 0.3s
}

.sidebarlinkpanel {
	overflow-y: scroll;
}

.sidebar p, .sidebar a {
	color: #555555;
	text-decoration: none;
}

/* When you mouse over the navigation links, change their color */
.sidebar a:hover, .offcanvas a:focus{
    color: <?php echo $theme['SidebarLinkHoverColor']; ?> ;
}

.footer {
	text-align: center;
}

.footer h3 {
	font-family: MavenPro;
	color: <?php echo $theme['SidebarTextColor']; ?> ;
}

.sc-button {
	background-color: <?php echo $theme['ButtonBackgroundColor']; ?> ;
	font-family: MavenPro;
	color: <?php echo $theme['ButtonTextColor']; ?> ;
	font-weight: bold;
	font-size: 18px;
	border-radius: 2px;
	border: none;
	padding: 2px;
}

.login {
	font-family: MavenPro;
	color: <?php echo $theme['SidebarTextColor']; ?> ;
	text-align: right;
	margin-right: 10px;
}

#banner {
	width: calc(100% - 250px);
	margin-left: 250px;
	margin-bottom: 0px;
	padding: 0px;
	background-color: <?php echo $theme['BannerBackgroundColor']; ?> ;
	text-align: center;
}

#alertmessage {
	width: calc(100% - 250px);
	margin-left: 250px;
	margin-bottom: 0px;
	padding: 0px;
	background-color: #D62020;
	text-align: center;
	font-family: MavenPro;
	font-size: 16px;
	color: #FFFFFF;
}

#eventalert {
	width: calc(100% - 250px);
	margin-left: 250px;
	margin-top: 0px;
	margin-bottom: 0px;
	padding: 0px;
	text-align: center;
	font-family: MavenPro;
	font-size: 16px;
	color: #FFFFFF;
}

#eventalert h2, h3 {
	margin-top: 0px;
	margin-bottom: 5px;
}

#eventalert a {
	color: white;
	text-decoration: underline;
}


.banner-img {
	width: 100%;
	max-width: 1670px;
	max-height: 200px;
}

#main {
	margin-left: 250px;
	padding: 20px;
}

#ctlpage {
	width: 50%;
	margin: 0 auto;
}

.page-content h1 {
	font-size: 48px;
	font-weight: bold;
	margin-top: 12px;
	margin-bottom: 12px;
}

.page-content h2 {
	font-size: 36px;
	font-weight: bold;
	margin-top: 12px;
	margin-bottom: 12px;
}

.activity-block {
	background-color: <?php echo $theme['BlockBackgroundColor']; ?> ;
	font-family: MavenPro;
	color: <?php echo $theme['BlockTextColor']; ?> ;
	box-shadow: 0px 0px 10px #222222;
	padding: 3px 3px 3px 3px;
	border-radius: 5px;
	width: 50%;
	margin: 0 auto;
}

.activity-block p {
	font-size: 16px;
}

.directory-grid {
	width: 75%;
	margin: 0 auto;
}

.profile-block {
	display: inline-block;
	background-color: <?php echo $theme['BlockBackgroundColor']; ?> ;
	font-family: MavenPro;
	color: <?php echo $theme['BlockTextColor']; ?> ;
	box-shadow: 0px 0px 10px #222222;
	padding: 3px 3px 3px 3px;
	border-radius: 5px;
	width: 400px;
	height: 225px;
	margin: 0 auto;
}

.character-image {
	width: 150px;
	height: 150px;
}

.catchphrase-cell {
	width: 100%;
	vertical-align: top;
}

.profile-block a {
	color: <?php echo $theme['BlockTextColor']; ?> ;
	text-decoration: none;
}

.profile-block a:hover {
	color: <?php echo $theme['BlockTextColor']; ?> ;
	text-decoration: underline;
}

.profile-name {
	text-overflow: ellipsis;
	overflow: hidden;
	white-space: nowrap;
	width: 250px;
	display: block;
}

.pview-block {
	display: block;
	background-color: <?php echo $theme['BlockBackgroundColor']; ?> ;
	font-family: MavenPro;
	color: <?php echo $theme['BlockTextColor']; ?> ;
	box-shadow: 0px 0px 10px #222222;
	padding: 3px 3px 3px 3px;
	border-radius: 5px;
	width: 60%;
	margin: 0 auto;
	text-align: center;
}

#pview-title {
	width: 48%;
	display: inline-block;
	text-align: center;
	border-right: 1px solid #EEEEEE;
}

#pview-title h2 {
	white-space: nowrap;
	display: block;
	/*width: 250px;*/
	max-width: 100%;
	text-overflow: ellipsis;
	overflow: hidden;
}

#pview-ranks {
	width: 48%;
	display: inline-block;
	text-align: center;
}

#pview-image {
	width: 60%;
	display: block;
	margin: 0 auto;
}

#pview-rank-top {
	width: 90%;
	display: inline-block;
	margin: 0 auto;
	background-color: <?php echo $theme['RankBlockColor']; ?> ;
	font-family: BigNoodleTitling;
	color: white;
	border-radius: 3px;
	box-shadow: inset 0px 0px 8px black;
	text-shadow: 2px 2px 5px black;
	font-style: italic;
	text-align: left;
	margin-bottom: 5px;
}

#pview-rank-top h1 {
	/*float: left;*/
	display: inline;
	font-size: 96px;
}

#pview-rank-top h2 {
	display: block;
	font-size: 28px;
	margin-top: 2px;
	margin-bottom: 2px;
}

.pview-rank-emblem {
	width: 40%;
	max-width: 136px;
	max-height: 136px;
	display: inline;
	float: right;
	vertical-align: middle;
}

#pview-rank-extra {
	width: 90%;
	display: block;
	margin: 0 auto;
	background-color: <?php echo $theme['RankBlockColor']; ?> ;
	font-family: BigNoodleTitling;
	color: white;
	border-radius: 3px;
	box-shadow: inset 0px 0px 8px black;
	text-shadow: 1px 1px 3px black;
	font-style: italic;
	text-align: left;
	margin-bottom: 5px;
}

#pview-rank-extra h1 {
	/*float: left;*/
	display: inline;
	font-size: 48px;
}

#pview-rank-extra h2 {
	display: inline;
	float: right;
	font-size: 24px;
	margin-top: 10px;
	margin-right: 10px;
}

#pview-connects {
	display: block;
	width: 90%;
	margin: 0 auto;

}

.pview-connect-box {
	background-color: transparent;
	display: inline-block;
	border: 1px solid #EEEEEE;
	border-radius: 3px;
	font-size: 16px;
	padding: 3px 3px 2px 2px;
}

.pview-connect-box img {
	display: inline-block;
	width: 48px;
	height: 48px;
	vertical-align: middle;
}

#pview-catchphrase {
	margin-top: 10px;
	font-size: 16px;
	font-style: italic;
	margin-bottom: 6px;
}

.event-block {
	display: block;
	width: 60%;
	margin: 0 auto;
	background-color: <?php echo $theme['BlockBackgroundColor']; ?> ;
	font-family: MavenPro;
	color: <?php echo $theme['BlockTextColor']; ?> ;
	box-shadow: 0px 0px 10px #222222;
	padding: 3px 3px 3px 3px;
	border-radius: 5px;
	margin-bottom: 8px;
	padding-left: 4px;
	padding-right: 4px;
}

.event-block h1 {
	display: block;
	font-size: 36px;
	text-align: center;
}

.event-block h2 {
	font-size: 22px;
	display: inline-block;
	text-align: left;
}

.event-block h2 img {
	width: 24px;
	height: 24px;
	display: inline;
}

.event-label {
	text-align: right !important;
	float: right;
}

.event-block p {
	display: block;
	font-size: 16px;
}

.event-type {
	display: inline;
}

.event-block form {
	display: inline;
	float: right;
}

.acp-block {
	display: block;
	background-color: transparent;
	text-align: center;
	width: 80%;
	margin: 0 auto;
}

.acp-icon {
	display: inline-block;
	margin: 0px 0px 6px 6px;
}

.acp-icon a {
	text-decoration: none;
	color: <?php echo $theme['MainTextColor']; ?> ;
}

.acp-icon img {
	width: 64px;
	height: 64px;
	display: block;
	margin: 0 auto;
}

.legend-link {
	width: 224px;
	height: 64px;
	display: inline;
	float: right;
}

.legend-link img {
	width: 64px;
	height: 64px;
	display: inline;
	vertical-align: middle;
}

.legend-link a {
	text-decoration: none;
	font-size: 24px;
	color: <?php echo $theme['MainTextColor']; ?> ;
}

.legend-link a:hover {
	text-decoration: underline;
}

#rankheader {
	display: inline-block;
}

.legend-block {
	display: inline-block;
	width: 19%;
	text-align: center;
}

.legend-block img {
	display: block;
	width: 250px;
	height: 250px;
	margin: 0 auto;
}

.legend-block span {
	font-weight: bold;
	font-size: 24px;
	color: <?php echo $theme['SidebarTextColor']; ?> ;
}

.rank-list {
	width: 75%;
	max-width: 1440px;
	margin: 0 auto;
	box-shadow: inset 0px 0px 15px black;
	font-family: MavenPro;
	font-size: 20px;
	color: <?php echo $theme['RankBlockTextColor']; ?> ;
	border-spacing: 0px;
	border-collapse: collapse;
	z-index: 1;
}

.rank-list tr {
	width: 100%;
}

#rank-list-head {
	font-weight: bold;
	background-color: <?php echo $theme['BlockBackgroundColor']; ?>;
	color: <?php echo $theme['BlockTextColor']; ?> !important;
}

.rank-list tr:nth-child(even) {
	background-color: <?php echo $theme['RankBlockColor']; ?>;
}

.rank-list tr:nth-child(odd) {
	background-color: <?php echo $theme['RankBlockAltColor']; ?>;
}

.rank-list td {
	padding: 5px;
}

.rank-list td img {
	width: 64px;
	height: 64px;
	margin: 0 auto;
}

.rank-list a {
	color: <?php echo $theme['RankBlockTextColor']; ?> ;
	text-decoration: none;
}

.rank-list a:hover {
	text-decoration: underline;
}

.rec-menu {
	display: inline-block;
	width: 40%;
	text-align: center;
}

.formpage-block {
	display: block;
	width: 50%;
	margin: 8px auto;
	background-color: <?php echo $theme['BlockBackgroundColor']; ?> ;
	font-family: MavenPro;
	color: <?php echo $theme['BlockTextColor']; ?> ;
	box-shadow: 0px 0px 10px #222222;
	padding: 3px 3px 3px 3px;
	border-radius: 5px;
	padding-left: 4px;
	padding-right: 4px;
	text-align: center;
}

.formpage-block span {
	width: 48%;
	display: inline-block;
	text-align: left;
}

.formpage-block input:not([type='checkbox']), .formpage-block select {
	width: 48%;
	display: inline-block;
}

.formpage-block h3 {
	width: 100%;
	display: block;
	text-align: center;
	margin-top: 1px;
	margin-bottom: 1px;
}

.formpage-block textarea {
	width: 96%;
	margin: 0 auto;
	display: block;
}

.feed-image {
	display: inline-block;
	vertical-align: middle;
}

.tourney-match-block {
	display: block;
	width: 300px;
	margin: 5px 5px;
	background-color: <?php echo $theme['BlockBackgroundColor']; ?> ;
	font-family: MavenPro;
	color: <?php echo $theme['BlockTextColor']; ?> ;
	box-shadow: 0px 0px 10px #222222;
	padding: 3px 3px 3px 3px;
	border-radius: 5px;
}

.tourney-match-cell {
	width: 350px;
}

.tourney-match-table {
	display: block;
	margin-left: 15px;
	margin-right: 15px;
	margin-bottom: 25px;
	border-collapse: collapse;
}

.tourney-match-innertable {
	color: <?php echo $theme['BlockTextColor']; ?> ;
	width: 100%;
	margin: 0 auto;
	border-collapse: collapse;
}

.tourney-match-innertable img {
	width: 36px;
	height: 36px;
	margin: 0 auto;
}

.rank-img-tiny {
	width: 16px !important;
	height: 16px !important;
	margin: none;
	vertical-align: middle;
}

#tourney-score-table {
	text-align: center;
}

#forgot-password {
	color: <?php echo $theme['SidebarTextColor']; ?> !important ;
}

@font-face{
	font-family: MavenPro;
	src: url(/resource/MavenProLight-300.otf);
}

@font-face{
	font-family: BigNoodleTitling;
	src: url(/resource/big_noodle_titling.ttf);
}