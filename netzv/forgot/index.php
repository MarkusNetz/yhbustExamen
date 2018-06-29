<?php
$top_level="../../";
require_once $top_level."ini/settings.php";

?>
<!DOCTYPE html>
<html lang='sv'>
	<head>
		<title>Återställ lösenord - NetZV</title>
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
		<?php include $subdomain_level . $folder_inc . $file_sub_dom_nav; ?>
		
		<!-- Contact Container -->
		<div class="w3-container w3-white">
			<div class="w3-padding-32">
				<div class="w3-content">
					
					<div class="w3-panel w3-green w3-center">
						<h2>Återställ ditt lösenord för konto</h2>
					</div>
					
					<form class="w3-container" method="post" action="../inc/process_forgot.php">
						<div class="w3-row-padding w3-margin-top">							
							<div class="w3-twothird">
								<input name="resetEmail" id="resetEmail" class="w3-leftbar w3-input w3-pale-green w3-border-green" type="email" required="required" />
								<label class="w3-opacity" for="resetEmail">Ange din e-postadress</label>
							</div>
							<div class="w3-third">
								<input type="submit" class="w3-button w3-large w3-deep-purple w3-border w3-border-black w3-round w3-hover-black" name="submitResetPass" value="Återställ" />
							</div>
						</div>
					</form>
					
				</div>
			</div>
		</div>
		
	</body>
</html>
