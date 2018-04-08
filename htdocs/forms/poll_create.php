<html>
	<head>
		<link rel="stylesheet" href="/resource/dstyle.php" />
		<link rel="shortcut icon" href="/resource/favicon.ico" />
		<title>Create Poll - SmashClub</title>
		<script type="text/javascript">
		function updateForm(){
			document.getElementById('submit').style.display='inline-block';
			document.getElementById('questiontext').style.display='inline-block';
			document.getElementById('question').style.display='inline-block';
			if (document.getElementById('radio1').checked==true){
				document.getElementById('choices').style.display='inline-block';
			}
			else {
				document.getElementById('choices').style.display='none';
			}
		}
		function validatePoll(){
			
		}
		</script>
	</head>
	<body>
	<?php require_once($_SERVER['DOCUMENT_ROOT']."/alertmessage_wide.php"); ?>
	<?php require_once($_SERVER['DOCUMENT_ROOT']."/service/svc_event_manager.php"); ?>
	<?php
		if ($_SESSION['type']<3){
		writeLog(ALERT, "Form:POLL_CREATE requested by unauthorized user, IP: ".$_SERVER['REMOTE_ADDR']);
		showErrorPage(403);
		die();
	}
	?>

		<div class="page-content">
			<div class="formpage-block">
				<h2>Create A Poll</h2>
				<form action="/script/poll_update.php" method="post" onsubmit="return validatePoll()">
					<input type="radio" name="type" value="1" id="radio1" onchange="updateForm()" /><span>Multiple-Choice Poll (Specify options to select from)</span>
					<input type="radio" name="type" value="2" id="radio2" onchange="updateForm()" /><span>Text Survey (Open-ended text responses)</span>
					<span id="questiontext" style="display: none">Enter your question:</span>
					<input type="text" id="question" name="question" style="display: none" required/>
					<textarea id="choices" name="choices" rows="5" style="display: none">Enter your choices here (one per line).</textarea>
					<br/>
					<input type="submit" class="sc-button" name="create" value="Create Poll" style="display: none" id="submit" />
				</form>
			</div>
		</div>
	</body>
</html>