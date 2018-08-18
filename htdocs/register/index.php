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
						<option value="unknown" selected>Select...</option>
						<option value="63">Bayonetta</option>
						<option value="14">Bowser</option>
						<option value="58">Bowser Jr.</option>
						<option value="11">Capt. Falcon</option>
						<option value="35">Charizard</option>
						<option value="61">Cloud</option>
						<option value="62">Corrin</option>
						<!--<option value="13a">Daisy</option>-->
						<option value="28a">Dark Pit</option>
						<option value="36">Diddy Kong</option>
						<option value="02">Donkey Kong</option>
						<option value="18">Dr. Mario</option>
						<option value="59">Duck Hunt</option>
						<option value="20">Falco</option>
						<option value="07">Fox</option>
						<option value="23">Ganondorf</option>
						<option value="50">Greninja</option>
						<option value="15">Ice Climbers</option>
						<option value="32">Ike</option>
						<!--<option value="64">Inkling</option>-->
						<option value="34">Ivysaur</option>
						<option value="12">Jigglypuff</option>
						<option value="39">King Dedede</option>
						<option value="06">Kirby</option>
						<option value="03">Link</option>
						<option value="49">Little Mac</option>
						<option value="41">Lucario</option>
						<option value="37">Lucas</option>
						<option value="21a">Lucina</option>
						<option value="09">Luigi</option>
						<option value="01">Mario</option>
						<option value="21">Marth</option>
						<option value="46">Mega Man</option>
						<option value="28">Meta Knight</option>
						<option value="24">Mewtwo</option>
						<option value="51">Mii Brawler</option>
						<option value="52">Mii Swordfighter</option>
						<option value="53">Mii Gunner</option>
						<option value="26">Mr.Game &amp; Watch</option>
						<option value="10">Ness</option>
						<option value="40">Olimar</option>
						<option value="55">Pac-Man</option>
						<option value="54">Palutena</option>
						<option value="13">Peach</option>
						<option value="19">Pichu</option>
						<option value="08">Pikachu</option>
						<option value="28">Pit</option>
						<!--<option value="65">Ridley</option>-->
						<option value="42">R. O. B.</option>
						<option value="56">Robin</option>
						<option value="48">Rosalina &amp; Luma</option>
						<option value="25">Roy</option>
						<option value="60">Ryu</option>
						<option value="04">Samus</option>
						<option value="16">Sheik</option>
						<option value="57">Shulk</option>
						<option value="31">Snake</option>
						<option value="38">Sonic</option>
						<option value="33">Squirtle</option>
						<option value="43">Toon Link</option>
						<option value="45">Villager</option>
						<option value="30">Wario</option>
						<option value="47">Wii Fit Trainer</option>
						<option value="44">Wolf</option>
						<option value="05">Yoshi</option>
						<option value="22">Young Link</option>
						<option value="17">Zelda</option>
						<option value="29">Zero Suit Samus</option>
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