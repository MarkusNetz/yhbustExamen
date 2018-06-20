<?php
$top_level="../";
require_once $top_level."ini/settings.php";

if( $LoginCheck->LoginCheck($dbConn) == true )
{
	
	$loggedInUser = new loggedInUser($dbConn);
}
else
{
	header("location " . $top_level . "login/");
}

?>
<!DOCTYPE html>
<html lang='sv'>
	<head>
		<title>Skapa nytt konto - NetZV</title>
		<meta name="google-signin-client_id" content="94719343879-eo9fi600ua8k99tbn4omr34f841cbp3b.apps.googleusercontent.com" redirect_uri="" />
		
		<?php
		/*	Metadata */
		echo $metadata;
		
		/*	W3.CSS */
		echo $w3_css;
		echo $w3_theme;
		
		/*	Fonts */
		echo $font_awesome;
		echo $font_roboto;
		
		/*	BOOTSTRAP */
		// echo $bootstrap_css;
		// echo $bootstrap_js;
		
		/*	jQuery library 	*/
		echo $jquery; ?>
	</head>
	<body id="myPage" class="w3-theme-l5">
		<?php include $top_level . $folder_inc . $file_nav; ?>
		
		<!-- Contact Container -->
		<div class="w3-container w3-white">
			<div class="w3-padding-32">
				<div class="w3-content">
					<div class="w3-panel w3-green w3-center">
						<h2>Skapa nytt konto</h2>
					</div>
					<form class="w3-container" method="post" action="../inc/process_registration.php">
						<div class="w3-row-padding">
							<div class="w3-third">
								<input name="accFirstName" id="accFirstName" class="w3-input w3-border-green" style="width:100%;" type="text" required="required" />
								<label for="accFirstName" class="w3-opacity">Förnamn</label>
							</div>
							<div class="w3-third">
								<input name="accLastName" id="accLastName" class="w3-input w3-border-green" style="width:100%;" type="text" required="required" />
								<label for="accLastName" class="w3-opacity">Efternamn</label>
							</div>
							<div class="w3-third">
								<input name="accDateOfBirth" id="accDateOfBirth" class="w3-input w3-border-green" style="width:100%;" type="date" required="required" placeholder="" />
								<label for="accDateOfBirth" class="w3-opacity">Födelsedatum</label>
							</div>
						</div>
						<div class="w3-row-padding">							
							<div class="w3-third">
								<select class="w3-select w3-medium" name="accContactType" id="accContactType">
									<option disabled selected>Ange kontakt</option>
									<option value="1">Mobilnummer</option>
									<option value="2">Hemadress</option>
									<option value="3">Test</option>
								</select>
								<label>&nbsp;</label>
							</div>
							<div class="w3-twothird">
								<input name="accContactInfo" id="accContactInfo" class="w3-input w3-border-green" style="width:100%;" type="text" required="required" />
							</div>
						</div>
						
						<div class="w3-row-padding">							
							<div class="w3-third">
								<input name="accEmail" id="accEmail" class="w3-input w3-border-green" style="width:100%;" type="email" required="required" />
								<label for="accEmail" class="w3-opacity">Din e-postadress</label>
							</div>
							<div class="w3-third">
								<input name="accPassOne" id="accPassOne" class="w3-input w3-border-green" style="width:100%;" type="password" required="required" />
								<label for="accPassOne" class="w3-opacity">Önskat lösenord</label>
							</div>
							<div class="w3-third">
								<input name="accPassTwo" id="accPassTwo" class="w3-input w3-border-green" style="width:100%;" type="password" required="required" />
								<label for="accPassOne" class="w3-opacity">Bekräfta lösenord</label>
							</div>
						</div>
						
						<div class="w3-margin-top">
							<input type="submit" class="w3-button w3-large w3-deep-purple w3-border w3-border-black w3-round w3-hover-black" name="submitNewAcc" value="Registrera" />
						</div>
					</form>
				</div>
			</div>
		</div>
	</body>
</html>
