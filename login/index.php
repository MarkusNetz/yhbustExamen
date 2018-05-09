<?php
$top_level="../";
require_once $top_level."ini/settings.php";
include $top_level."class/class_lib.php";

?>
<!DOCTYPE html>
<html lang='sv'>
	<head>
		<title>Logga in</title>
		<meta name="google-signin-client_id" content="94719343879-eo9fi600ua8k99tbn4omr34f841cbp3b.apps.googleusercontent.com" redirect_uri=>
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
		echo $bootstrap_css;
		echo $bootstrap_js;
		
		/*	jQuery library 	*/
		echo $jquery; ?>
	</head>
	<body id="myPage">
		<script source="/js/fb-sdk.js"></script>
		<?php include $path_inc ."/". $file_nav; ?>
		<div id="fb-root"></div>
		<script>
			(function(d, s, id) {
			var js, fjs = d.getElementsByTagName(s)[0];
			if (d.getElementById(id)) return;
			js = d.createElement(s); js.id = id;
			js.src = 'https://connect.facebook.net/sv_SE/sdk.js#xfbml=1&version=v3.0&appId=2077280685881658&autoLogAppEvents=1';
			fjs.parentNode.insertBefore(js, fjs);
			}(document, 'script', 'facebook-jssdk'));
		</script>
		<!-- Contact Container -->
		<div class="w3-container w3-padding-32 w3-theme-l5" id="contact">
			<div class="w3-row">
				<div class="w3-half">
					<form class="w3-container w3-padding-32 w3-white">
						<h4>Logga in med användaruppgifter</h4>
						<div class="w3-section">
							<input class="w3-input" style="width:100%;" type="text" required>
							<label>Username</label>
						</div>
						<div class="w3-section">
							<input class="w3-input" style="width:100%;" type="password" required>
							<label>Password</label>
						</div>
						<button type="button" class="w3-btn btn-info">Logga in</button>
					</form>
				</div>
				<div class="w3-half">
					<div class="w3-container w3-padding-32 w3-white">
						<h4>Logga in via OAuth.</h4>
						<div class="w3-margin">
							<div class="g-signin2" data-onsuccess="onSignIn"></div>
						</div>
						<div class="w3-margin">
							<div class="fb-login-button" data-max-rows="1" data-size="medium" data-button-type="login_with" data-show-faces="false" data-auto-logout-link="false" data-use-continue-as="false"></div>
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
