<html>
	<head>
		<link rel="stylesheet" href="/resource/dstyle.php" />
		<link rel="shortcut icon" href="/resource/favicon.ico" />
		<title>Registration - SmashClub</title>
		<script type="text/javascript">
		function validatePWs(){
			var phoneno = document.getElementById('phoneno').value;
			if (phoneno.length>0 && phoneno.length != 10){
				alert("Your phone number should be 10 digits including the area code.");
				return false;
			}
			var pw1 = document.getElementById('pw1').value;
			var pw2 = document.getElementById('pw2').value;
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
	<?php require_once($_SERVER['DOCUMENT_ROOT']."/service/app_properties.php"); ?>

	<?php
		if (svc_getSetting("EnableSelfRegister")=="0" and $_SESSION['type'] < 2){
			showJavascriptAlert("Sorry, this club does not allow new members to register themselves. You must attend an event or contact a club officer to have your account set up.");
			sendRedirect("/");
			die();
		}
	?>

		<div class="page-content">
			<div class="formpage-block">
				<h2>Join The Club!</h2>
				<h3>Create your SmashClub account and start building your player profile.</h3>
				<form action="/script/register.php" method="post" onsubmit="return validatePWs()">
					<span>Username: *</span>
					<input type="text" name="username" size="30" maxlength="64" required/>
					<span>Password: *</span>
					<input type="password" id="pw1" name="password" size="30" required/>
					<span>Confirm Password: *</span>
					<input type="password" id="pw2" size="30" required/>
					<hr/>
					<h3>Contact Information</h3>
					<h4><i>This information will only be visible to administrators in order to contact you during events. We will never release your information to third parties.</i></h4>
					<span>E-mail Address: *</span>
					<input type="email" name="email" size="30" required/>
					<span>Phone Number (digits only, include area code):</span>
					<input type="text" name="phone" id="phoneno" maxlength="10" size="30" />
					<span>Phone Service Provider:</span>
					<select name="carrier">
						<option value="0">AT&amp;T</option>
						<option value="1">Verizon</option>
						<option value="2">Sprint</option>
						<option value="3">T-Mobile</option>
						<option value="4">US Cellular</option>
						<option value="5">Boost Mobile</option>
						<option value="6">MetroPCS</option>
						<option value="7">Straight Talk</option>
						<option value="8">Other</option>
					</select>
					<hr/>
					<h3>Your Player Profile (will be shown publicly)</h3>
					<span>First Name: *</span>
					<input type="text" name="firstname" size="30" maxlength="50" required/>
					<span>Last Name: *</span>
					<input type="text" name="lastname" size="30" maxlength="50" required/>
					<span>Who's Your Main?</span>
					<select name="main">
						<option value="unknown">Select...</option>
						<option value="bayonetta">Bayonetta</option>
						<option value="bowser">Bowser</option>
						<option value="bowserjr">Bowser Jr.</option>
						<option value="cptfalcon">Capt. Falcon</option>
						<option value="charizard">Charizard</option>
						<option value="cloud">Cloud</option>
						<option value="corrin">Corrin</option>
						<option value="darkpit">Dark Pit</option>
						<option value="diddykong">Diddy Kong</option>
						<option value="donkeykong">Donkey Kong</option>
						<option value="drmario">Dr. Mario</option>
						<option value="duckhunt">Duck Hunt</option>
						<option value="falco">Falco</option>
						<option value="fox">Fox</option>
						<option value="ganondorf">Ganondorf</option>
						<option value="greninja">Greninja</option>
						<option value="iceclimbers">Ice Climbers</option>
						<option value="ike">Ike</option>
						<option value="jigglypuff">Jigglypuff</option>
						<option value="dedede">King Dedede</option>
						<option value="kirby">Kirby</option>
						<option value="link">Link</option>
						<option value="littlemac">Little Mac</option>
						<option value="lucario">Lucario</option>
						<option value="lucas">Lucas</option>
						<option value="lucina">Lucina</option>
						<option value="luigi">Luigi</option>
						<option value="mario">Mario</option>
						<option value="marth">Marth</option>
						<option value="megaman">Mega Man</option>
						<option value="metaknight">Meta Knight</option>
						<option value="mewtwo">Mewtwo</option>
						<option value="gamewatch">Mr.Game &amp; Watch</option>
						<option value="ness">Ness</option>
						<option value="olimar">Olimar</option>
						<option value="pacman">Pac-Man</option>
						<option value="palutena">Palutena</option>
						<option value="peach">Peach</option>
						<!--<option value="pichu">Pichu</option> (Couldn't find a good image)-->
						<option value="pikachu">Pikachu</option>
						<option value="pit">Pit</option>
						<option value="pokemon">Pokemon Trainer</option>
						<option value="rob">R. O. B.</option>
						<option value="robin1">Robin (M)</option>
						<option value="robin2">Robin (F)</option>
						<option value="rosalina">Rosalina</option>
						<option value="roy">Roy</option>
						<option value="ryu">Ryu</option>
						<option value="samus">Samus</option>
						<option value="sheik">Sheik</option>
						<option value="shulk">Shulk</option>
						<option value="snake">Snake</option>
						<option value="sonic">Sonic</option>
						<option value="toonlink">Toon Link</option>
						<option value="villager">Villager</option>
						<option value="wario">Wario</option>
						<option value="wiifit">Wii Fit Trainer</option>
						<option value="wolf">Wolf</option>
						<option value="yoshi">Yoshi</option>
						<option value="zelda">Zelda</option>
						<option value="zerosuit">Zero Suit Samus</option>
					</select><br/>
					<span>Nintendo Network ID:</span>
					<input type="text" name="id_nnw" size="30" />
					<span>Xbox Live Gamertag:</span>
					<input type="text" name="id_xbl" size="30" />
					<span>PSN ID:</span>
					<input type="text" name="id_psn" size="30" />
					<span>Steam Profile Name:</span>
					<input type="text" name="id_stm" size="30" />
					<span>Origin ID:</span>
					<input type="text" name="id_org" size="30" />
					<span>Other ID (Site/type):</span>
					<input type="text" name="id_oths" size="30" />
					<span>Other ID:</span>
					<input type="text" name="id_othn" size="30" />
					<h3>Favorite Quote or Catchphrase</h3>
					<textarea rows="3" name="catchphrase"></textarea>
					<input type="checkbox" name="rec-email" /> Receive e-mail and SMS notifications <br/>
					<input type="hidden" name="agent" value="self" /> <!--Tells the script which method to call-->
					<input type="hidden" name="type" value="1" /> <!--Standard member acct-->
					<input type="submit" value="Create Account" class="sc-button" />
				</form>

			</div>
		</div>
	</body>
</html>