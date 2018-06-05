<?php
$top_level="../";
require_once $top_level."ini/settings.php";
?>
<!DOCTYPE html>
<html lang="sv">
	<head>
		<title>Vilka Netzare</title>
		<script src="https://apis.google.com/js/platform.js" async defer></script>

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
	<body id="profilePage" class="w3-theme-l5">
		<script src='/js/fb-sdk.js'></script>
		<?php include $top_level . $folder_inc ."/". $file_nav; ?>
		
		<!-- Team Container -->
		<section class="w3-container w3-center w3-padding" id="profilePresentation">
			<div class="w3-row w3-card-2 w3-white w3-round w3-padding-32">
				<h1>Hej, <?php if($loggedIn && isset($loggedInUser)){ echo $loggedInUser->getDisplayName();} ?></h1>
				<p>
					<span class="w3-bottombar w3-border-teal">Här är din profil.</span>
				</p>
				
				<div class="w3-margin-top w3-padding">
					<div class="w3-third w3-margin-top">
						<h1>Min historia</h1>
						<p>Lorem ipsum ....</p>
					</div>
					<div class="w3-third w3-margin-top">
						<h1>Mina karriärsmål</h1>
						<p>Lorem ipsum ....</p>
					</div>
					<div class="w3-third w3-margin-top">
						<h1>Min framtidsvision</h1>
						<p>Lorem ipsum ....</p>
					</div>
				</div>
			</div>
		</section>
		
		<!-- CV-section -->
		<section class="w3-container w3-padding-32 w3-center w3-row" id="curriculum">
			<div class="w3-quarter w3-card w3-amber w3-padding-16" style="min-height:10em;">
				<h3>IT-CV</h3>
				<p>Detta CV är för IT-branschen.</p>
				<a class="btn btn-info" role="button" href="../cv/?userID=1&cvID=1">Visa CV</a>
			</div>

			<div class="w3-quarter w3-card w3-deep-orange w3-padding-16" style="min-height:10em;">
				<h3>John Doe</h3>
				<p>Boss man</p>
				<a class="btn btn-info" role="button" href="../cv/?userID=1&cvID=2">Visa CV</a>
			</div>
			
			<div class="w3-quarter w3-card w3-khaki w3-padding-16" style="min-height:10em;">
				<h3>Jane Doe</h3>
				<p>Support</p>
				<a class="btn btn-info" role="button" href="../cv/?userID=1&cvID=3">Visa CV</a>
			</div>

			<div class="w3-quarter w3-card w3-blue-gray w3-padding-16" style="min-height:10em;">
				<h3>Meritförteckning</h3>
				<p>Min fullständiga meritförteckning</p>
				<a class="btn btn-info" role="button" href="../cv/?userID=1&cvID=4">Visa CV</a>
			</div>
		</section>

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
	</body>
</html>