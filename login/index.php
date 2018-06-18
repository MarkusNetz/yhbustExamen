<?php
$top_level="../";
require_once $top_level."ini/settings.php";
require_once $top_level . $folder_class . "LoginCheck.class.php";
if( $LoginCheck->LoginCheck($dbConn) == true )
{
	echo "<h2>Inloggad.</h2><p>Du är inloggad</p>";
}
else
{
	echo "<h2>Inte inloggad</h2><p>Det verkar som att du inte har loggat in.</p>";
}
?>
<!DOCTYPE html>
<html lang='sv'>
	<head>
		<title>Logga in</title>
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
		<script src="/js/fb-sdk.js"></script>
		<?php include $top_level . $folder_inc . $file_nav; ?>
		
		<!-- Contact Container -->
		<div class="w3-container w3-padding-32">
			<div class="w3-row">
				<div class="w3-border w3-col l5 w3-mobile w3-white">
					<form class="w3-container w3-margin-bottom" method="post" action="<?php echo $top_level . $folder_inc . "process_login.php"; ?>">
						<h4 class=" w3-margin-top">Logga in med användaruppgifter</h4>
						<div class="w3-section">
							<input name="credEntryUser" id="credEntryUser" class="w3-input" style="width:100%;" type="email" required="required" />
							<label>Användarnamn</label>
						</div>
						<div class="w3-section">
							<input name="credEntryPhrase" id="credEntryPhrase" class="w3-input" style="width:100%;" type="password" required="required" />
							<label>Lösenord</label>
						</div>
						<input type="submit" class="w3-button w3-blue w3" name="credLoginSubmit" value="Logga in" />
					</form>
				</div>
				
				<div class="w3-col l1 w3-small-hide">&nbsp;</div>
				
				<div class="w3-border w3-col l6 w3-mobile w3-white">
					<div class="w3-container w3-white">
						<h4 class="w3-margin-top w3-margin-bottom">Tredjepartsinloggning</h4>
						<div class="w3-padding-top">
							<div class="g-signin2" data-onsuccess="onSignIn"></div>
							<p class="w3-mobile">Google</p>
							<hr />
						</div>
						<div class="w3-padding-top">
							<div class="fb-login-button" data-max-rows="1" data-size="medium" data-button-type="login_with" data-show-faces="false" data-auto-logout-link="true" data-use-continue-as="false" data-onlogin="checkLoginState();"></div>
							<p class="w3-mobile">facebook</p>
							<hr />
						</div>
					</div>
				</div>
			</div>
		</div>

		<!-- Footer -->
		<footer class="w3-container w3-padding-32 w3-theme-d1 w3-center">
			<h4>Follow Us</h4>
			<a class="w3-button w3-large w3-teal" href="javascript:void(0)" title="Facebook"><i class="fa fa-facebook"></i></a>
			<a class="w3-button w3-large w3-teal" href="javascript:void(0)" title="Twitter"><i class="fa fa-twitter"></i></a>
			<a class="w3-button w3-large w3-teal" href="javascript:void(0)" title="Google +"><i class="fa fa-google-plus"></i></a>
			<a class="w3-button w3-large w3-teal" href="javascript:void(0)" title="Google +"><i class="fa fa-instagram"></i></a>
			<a class="w3-button w3-large w3-teal w3-hide-small" href="javascript:void(0)" title="Linkedin"><i class="fa fa-linkedin"></i></a>
			<p>Powered by <a href="https://www.w3schools.com/w3css/default.asp" target="_blank">w3.css</a></p>

			<div style="position:relative;bottom:100px;z-index:1;" class="w3-tooltip w3-right">
				<span class="w3-text w3-padding w3-teal w3-hide-small">Go To Top</span>   
				<a class="w3-button w3-theme" href="#myPage"><span class="w3-xlarge">
				<i class="fa fa-chevron-circle-up"></i></span></a>
			</div>
		</footer>
		
		<script src="https://apis.google.com/js/platform.js" async defer></script>
	</body>
</html>
