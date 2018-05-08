<?php
$top_level="";
require_once $top_level."ini/settings.php";
include "class/class_lib.php";

$markus = new person("Markus Netz");
$lollo = new employee("Johnny Fingers");

echo "Full name of employee lollo: " . $lollo->get_name();
// echo "Full name: " . $markus->get_name();
// echo "Tell me something private: " . $markus->test();
?>
<!DOCTYPE html>
<html lang='sv'>
	<head>
		<title>Netzarna</title>
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
		<script source="/js/fb-sdk.js" />
		<?php include $path_inc ."/". $file_nav; ?>

		<!-- Team Container -->
		<div class="w3-container w3-padding-64 w3-center" id="team">
			
			<h2>OUR TEAM</h2>
			<p>Meet the team - our office rats:</p>

			<div class="w3-row"><br>
				<div class="w3-quarter">
					<img src="/w3images/avatar.jpg" alt="Boss" style="width:45%" class="w3-circle w3-hover-opacity">
					<h3>Johnny Walker</h3>
					<p>Web Designer</p>
				</div>

				<div class="w3-quarter">
					<img src="/w3images/avatar.jpg" alt="Boss" style="width:45%" class="w3-circle w3-hover-opacity">
					<h3>Rebecca Flex</h3>
					<p>Support</p>
				</div>

				<div class="w3-quarter">
					<img src="/w3images/avatar.jpg" alt="Boss" style="width:45%" class="w3-circle w3-hover-opacity">
					<h3>Jan Ringo</h3>
					<p>Boss man</p>
				</div>

				<div class="w3-quarter">
					<img src="/w3images/avatar.jpg" alt="Boss" style="width:45%" class="w3-circle w3-hover-opacity">
					<h3>Kai Ringo</h3>
					<p>Fixer</p>
				</div>
			</div>
		</div>

		<!-- Work Row -->
		<div class="w3-row-padding w3-padding-64 w3-theme-l1" id="work">

			<div class="w3-quarter">
				<h2>Forms</h2>
				<p>Du kan använda formuläret för att lägga till folk till mitt Team.</p>
			</div>

			<!--div class="w3-half w3-right"-->
			<div class="w3-threequarter">
				<div>
					<form class="w3-container w3-card-4 w3-padding-16 w3-white" action="/action_page.php" target="_blank">
						<div class="w3-section w3-half">
							<input class="w3-input" type="text" name="first_name" required />
							<label>Förnamn</label>
							<input class="w3-input" type="text" name="last_name" required />
							<label>Efternamn</label>
						</div>
						<div class="w3-section w3-half">
							<input class="w3-input" type="tel" name="phone" required pattern="[+0-90-9]{3}?[0-9]{2,4}\s*?[-]?\s*?[0-9]{2,3}\s?[0-9]{1,3}\s*?[0-9]{2}?" />
							<label>Telefon. yyy-xxx xx xx</label>
							
							<input class="w3-input" type="email" name="email" required />
							<label>Email</label>
						</div>
						<div class="w3-content">
							<div class="w3-onethird w3-right">
								<button type="submit" class="w3-button w3-hover-khaki w3-green w3-round-large w3-margin-right">Add</button>
								<button type="reset" class="w3-button w3-red w3-section">Återställ</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>

		<!-- Container >
		<div class="w3-container" style="position:relative">
			<a onclick="w3_open()" class="w3-button w3-xlarge w3-circle w3-teal"
			style="position:absolute;top:-28px;right:24px">+</a>
		</div-->

		<!-- Pricing Row -->
		<div class="w3-row-padding w3-center w3-padding-64" id="pricing">
			<h2>PRICING</h2>
			<p>Choose a pricing plan that fits your needs.</p><br>
			<div class="w3-third w3-margin-bottom">
				<ul class="w3-ul w3-border w3-hover-shadow">
					<li class="w3-theme">
						<p class="w3-xlarge">Basic</p>
					</li>
					<li class="w3-padding-16"><b>10GB</b> Storage</li>
					<li class="w3-padding-16"><b>10</b> Emails</li>
					<li class="w3-padding-16"><b>10</b> Domains</li>
					<li class="w3-padding-16"><b>Endless</b> Support</li>
					<li class="w3-padding-16">
						<h2 class="w3-wide"><i class="fa fa-usd"></i> 10</h2>
						<span class="w3-opacity">per month</span>
					</li>
					<li class="w3-theme-l5 w3-padding-24">
						<button class="w3-button w3-teal w3-padding-large"><i class="fa fa-check"></i> Sign Up</button>
					</li>
				</ul>
			</div>

			<div class="w3-third w3-margin-bottom">
				<ul class="w3-ul w3-border w3-hover-shadow">
					<li class="w3-theme-l2">
						<p class="w3-xlarge">Pro</p>
					</li>
					<li class="w3-padding-16"><b>25GB</b> Storage</li>
					<li class="w3-padding-16"><b>25</b> Emails</li>
					<li class="w3-padding-16"><b>25</b> Domains</li>
					<li class="w3-padding-16"><b>Endless</b> Support</li>
					<li class="w3-padding-16">
						<h2 class="w3-wide"><i class="fa fa-usd"></i> 25</h2>
						<span class="w3-opacity">per month</span>
					</li>
					<li class="w3-theme-l5 w3-padding-24">
						<button class="w3-button w3-teal w3-padding-large"><i class="fa fa-check"></i> Sign Up</button>
					</li>
				</ul>
			</div>

			<div class="w3-third w3-margin-bottom">
				<ul class="w3-ul w3-border w3-hover-shadow">
					<li class="w3-theme">
						<p class="w3-xlarge">Premium</p>
					</li>
					<li class="w3-padding-16"><b>50GB</b> Storage</li>
					<li class="w3-padding-16"><b>50</b> Emails</li>
					<li class="w3-padding-16"><b>50</b> Domains</li>
					<li class="w3-padding-16"><b>Endless</b> Support</li>
					<li class="w3-padding-16">
						<h2 class="w3-wide"><i class="fa fa-usd"></i> 50</h2>
						<span class="w3-opacity">per month</span>
					</li>
					<li class="w3-theme-l5 w3-padding-24">
						<button class="w3-button w3-teal w3-padding-large"><i class="fa fa-check"></i> Sign Up</button>
					</li>
				</ul>
			</div>
		</div>

		<!-- Contact Container -->
		<div class="w3-container w3-padding-64 w3-theme-l5" id="contact">
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
		</div>

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
		<script source="/js/nav-script.j" />

	</body>
</html>
