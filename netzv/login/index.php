<?php
$top_level="../../";
require_once $top_level . "ini/settings.php";

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
		<title>Logga in - NetZV</title>
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
		<script src="<?php echo $subdomain_level; ?>js/fb-sdk.js"></script>
		<?php include $subdomain_level . $folder_inc . $file_sub_dom_nav; ?>
		
		<!-- Contact Container -->
		<div class="w3-container w3-white">
			<div class="w3-padding-32">
				<div class="w3-content">
					<div class="w3-panel w3-green w3-center">
						<h2 class="w3-margin-top">Logga in till NetZV</h2>
					</div>
					
					<form class="w3-container" method="post" action="<?php echo $sub_link . $folder_inc . "process_login.php"; ?>">
						<div class="w3-section">
							<input name="credEntryUser" id="credEntryUser" class="w3-input" type="email" required="required" />
							<label>Användarnamn</label>
						</div>
						
						<div class="w3-section">
							<input name="credEntryPhrase" id="credEntryPhrase" class="w3-input" type="password" required="required" />
							<label>Lösenord</label>
						</div>
						
						<div>
							<input class="w3-half w3-button w3-blue w3-hover-indigo w3-border w3-border-brown w3-hover-border-black" type="submit" name="credLoginSubmit" value="Logga in" />
							<a class="w3-right" name="credLoginCreate" href="<?php echo $subdomain_level . "forgot/";?>">Glömt lösenord?</a><br />
							<a class="w3-right" name="credLoginCreate" href="<?php echo $subdomain_level . "register/";?>">Skapa användarkonto</a>
						</div>
					</form>
					
					<div class="w3-container">
						<div class="w3-col l6 w3-mobile w3-white">
							<div class="w3-container w3-white">
								<div class="w3-header">
									<h4 class="w3-margin-top w3-margin-bottom">Logga in utan användaruppgifter.</h4>
								</div>
								
								<div class="w3-padding-top">
									<div class="g-signin2" data-onsuccess="onSignIn"></div>
									<p class="w3-mobile">Google</p>
									<hr />
								</div>
								<div class="w3-padding-top">
									<div class="fb-login-button" data-max-rows="1" data-size="medium" data-button-type="login_with" data-show-faces="false" data-auto-logout-link="true" data-use-continue-as="false" data-onlogin="checkLoginState();"></div>
									<p class="w3-mobile">facebook</p>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>
