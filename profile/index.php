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
	<body id="myPage">
		<script src='/js/fb-sdk.js'></script
		<?php include $path_inc ."/". $file_nav; ?>

		<!-- Team Container -->
		<section class="w3-container w3-padding-64 w3-center" id="team">
			<h2>OUR TEAM</h2>
			<p>Meet the team - our office rats:</p>

			<div class="w3-row"><br />
				<div class="w3-quarter">
					<img src="/w3images/avatar.jpg" alt="Boss" style="width:45%" class="w3-circle w3-hover-opacity">
					<h3>Markus Netz</h3>
					<p>Web Designer</p>
					<a class="btn btn-info" role="button" href="../cv/?userID=1&cvID=1">
						Visa CV
					</a>
				</div>

				<div class="w3-quarter">
					<img src="/w3images/avatar.jpg" alt="Boss" style="width:45%" class="w3-circle w3-hover-opacity">
					<h3>Jane Doe</h3>
					<p>Support</p>
				</div>

				<div class="w3-quarter">
					<img src="/w3images/avatar.jpg" alt="Boss" style="width:45%" class="w3-circle w3-hover-opacity">
					<h3>John Doe</h3>
					<p>Boss man</p>
				</div>

				<div class="w3-quarter">
					<img src="/w3images/avatar.jpg" alt="Boss" style="width:45%" class="w3-circle w3-hover-opacity">
					<h3>John Doe</h3>
					<p>Fixer</p>
				</div>
			</div>
		</section>

		<!-- Contact Container -->
		<section class="w3-container w3-padding-64 w3-theme-l5" id="contact">
			<div class="w3-row">
				<div class="w3-col m5">
					<div class="w3-padding-16"><span class="w3-xlarge w3-border-teal w3-bottombar">Contact Us</span></div>
					<h3>Address</h3>
					<p>Swing by for a cup of coffee, or whatever.</p>
					<p><i class="fa fa-map-marker w3-text-teal w3-xlarge"></i>  Chicago, US</p>
					<p><i class="fa fa-phone w3-text-teal w3-xlarge"></i>  +00 1515151515</p>
					<p><i class="fa fa-envelope-o w3-text-teal w3-xlarge"></i>  test@test.com</p>
				</div>
				<div class="w3-col m7">
					<form class="w3-container w3-card-4 w3-padding-16 w3-white" action="/action_page.php" target="_blank">
						<div class="w3-section">      
							<label>Name</label>
							<input class="w3-input" type="text" name="Name" required>
						</div>
						<div class="w3-section">      
							<label>Email</label>
							<input class="w3-input" type="text" name="Email" required>
						</div>
						<div class="w3-section">      
							<label>Message</label>
							<input class="w3-input" type="text" name="Message" required>
						</div>  
						<input class="w3-check" type="checkbox" checked name="Like" />
						<label>I Like it!</label>
						<button type="submit" class="w3-button w3-right w3-theme">Send</button>
					</form>
				</div>
			</div>
		</section>

		<!-- Google Maps -->
		<div id="googleMap" style="width:100%;height:420px;"></div>
		<script>
			function myMap()
			{
				myCenter=new google.maps.LatLng(41.878114, -87.629798);
				var mapOptions= {
					center:myCenter,
					zoom:12, scrollwheel: false, draggable: false,
					mapTypeId:google.maps.MapTypeId.ROADMAP
				};
				var map=new google.maps.Map(document.getElementById("googleMap"),mapOptions);

				var marker = new google.maps.Marker({
					position: myCenter,
				});
				marker.setMap(map);
			}
		</script>
		<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBu-916DdpKAjTmJNIgngS6HL_kDIKU0aU&callback=myMap" />
		<!--
			To use this code on your website, get a free API key from Google.
			Read more at: https://www.w3schools.com/graphics/google_maps_basic.asp
		-->

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
