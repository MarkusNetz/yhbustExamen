<?php
$top_level="../";
require_once $top_level."ini/settings.php";
if(!filter_has_var(INPUT_GET,'userID')){
	header("location: ../profiles/");
}
?>
<!DOCTYPE html>
<html lang='sv'>
	<head>
		<title>Curriculum Vitae</title>
		<?php
		/*	Metadata */
		echo $metadata;
		
		/*	W3.CSS */
		echo $w3_css;
		echo $w3_theme;
		
		/*	Fonts */
		echo $font_awesome;
		
		/*	BOOTSTRAP */
		// echo $bootstrap_css;
		// echo $bootstrap_js;
		
		/*	jQuery library 	*/
		echo $jquery; ?>
	</head>
	<body class="w3-light-grey">
		<?php // include $path_inc ."/". $file_nav; ?>
		
		<!-- Page Container -->
		<div class="w3-content w3-margin-top" style="max-width:1400px;">

			<!-- The Grid -->
			<div class="w3-row-padding">
		  
				<!-- Left Column -->
				<div class="w3-third">
			
					<div class="w3-white w3-text-grey w3-card-4">
						<div class="w3-display-container">
							<img src="../images/netz/markus-netz-1.jpg" style="width:100%" alt="Avatar" />
							<div class="w3-display-bottomleft w3-container w3-text-black w3-gray w3-opacity">
								<h2>Markus Netz</h2>
							</div>
						</div>
						<div class="w3-container">
							<p><i class="fa fa-briefcase fa-fw w3-margin-right w3-large w3-text-teal"></i>Databasadministratör</p>
							<p><i class="fa fa-home fa-fw w3-margin-right w3-large w3-text-teal"></i>Stockholm, Sverige</p>
							<p><i class="fa fa-envelope fa-fw w3-margin-right w3-large w3-text-teal"></i>markus.netz.89@gmail.com</p>
							<p><i class="fa fa-phone fa-fw w3-margin-right w3-large w3-text-teal"></i>073 - 362 90 96</p>
							<hr>

							<p class="w3-large"><b><i class="fa fa-asterisk fa-fw w3-margin-right w3-text-teal"></i>Färdigheter & intressen</b></p>
							<p>MySQL</p>
							<div class="w3-light-grey w3-round-xlarge w3-small">
								<div class="w3-container w3-center w3-round-xlarge w3-teal" style="width:90%">90%</div>
							</div>
							<p>ORACLE DB</p>
							<div class="w3-light-grey w3-round-xlarge w3-small">
								<div class="w3-container w3-center w3-round-xlarge w3-teal" style="width:80%">
									<div class="w3-center w3-text-white">80%</div>
								</div>
							</div>
							<p>SQL Server</p>
							<div class="w3-light-grey w3-round-xlarge w3-small">
								<div class="w3-container w3-center w3-round-xlarge w3-teal" style="width:75%">75%</div>
							</div>
							<p>Media</p>
							<div class="w3-light-grey w3-round-xlarge w3-small">
								<div class="w3-container w3-center w3-round-xlarge w3-teal" style="width:50%">50%</div>
							</div>
							<br />

							<p class="w3-large w3-text-theme">
								<b><i class="fa fa-globe fa-fw w3-margin-right w3-text-teal"></i>Språkkunskaper</b>
							</p>
							<p>Svenska</p>
							<div class="w3-light-grey w3-round-xlarge">
								<div class="w3-round-xlarge w3-teal" style="height:24px;width:100%"></div>
							</div>
							<p>English</p>
							<div class="w3-light-grey w3-round-xlarge">
								<div class="w3-round-xlarge w3-teal" style="height:24px;width:90%"></div>
							</div>
							<p>Deutsch</p>
							<div class="w3-light-grey w3-round-xlarge">
								<div class="w3-round-xlarge w3-teal" style="height:24px;width:15%"></div>
							</div>
							<br>
						</div>
					</div><br />

			<!-- End Left Column -->
			</div>

			<!-- Right Column -->
			<div class="w3-twothird">
			
				<div class="w3-container w3-card w3-white w3-margin-bottom">
					<h2 class="w3-text-grey w3-padding-16"><i class="fa fa-suitcase fa-fw w3-margin-right w3-xxlarge w3-text-teal"></i>Arbetsliv</h2>
					<div class="w3-container">
						<h5 class="w3-opacity"><b>Databasadministratör / Polismyndigheten</b></h5>
						<h6 class="w3-text-teal"><i class="fa fa-calendar fa-fw w3-margin-right"></i>Dec 2017 - <span class="w3-tag w3-teal w3-round">Nuvarande</span></h6>
						<p>Lorem ipsum dolor sit amet. Praesentium magnam consectetur vel in deserunt aspernatur est reprehenderit sunt hic. Nulla tempora soluta ea et odio, unde doloremque repellendus iure, iste.</p>
						<hr />
					</div>
					<div class="w3-container">
						<h5 class="w3-opacity"><b>Web Developer / Stockholmshem AB</b></h5>
						<h6 class="w3-text-teal"><i class="fa fa-calendar fa-fw w3-margin-right"></i>Okt 2015 - Jun 2018</h6>
						<p>Consectetur adipisicing elit. Praesentium magnam consectetur vel in deserunt aspernatur est reprehenderit sunt hic. Nulla tempora soluta ea et odio, unde doloremque repellendus iure, iste.</p>
						<hr />
					</div>
					<div class="w3-container">
						<h5 class="w3-opacity"><b>Busschaufför / Nobina Sverige AB</b></h5>
						<h6 class="w3-text-teal"><i class="fa fa-calendar fa-fw w3-margin-right"></i>Mar 2017 - Sept 2017</h6>
						<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. </p><br>
						<hr />
					</div>
					<div class="w3-container">
						<h5 class="w3-opacity"><b>IT-tekniker / IT-assistans AB</b></h5>
						<h6 class="w3-text-teal"><i class="fa fa-calendar fa-fw w3-margin-right"></i>Nov 2016 - Mar 2017</h6>
						<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. </p><br>
						<hr />
					</div>
					<div class="w3-container">
						<h5 class="w3-opacity"><b>Busschaufför / Kerstins Taxi & Buss AB</b></h5>
						<h6 class="w3-text-teal"><i class="fa fa-calendar fa-fw w3-margin-right"></i>Nov 2016 - Dec 2017</h6>
						<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. </p><br>
					</div>
				</div>

				<div class="w3-container w3-card w3-white">
					<h2 class="w3-text-grey w3-padding-16"><i class="fa fa-certificate fa-fw w3-margin-right w3-xxlarge w3-text-teal"></i>Utbildning & kurser</h2>
					<div class="w3-container">
						<h5 class="w3-opacity"><b>Lernia YH</b></h5>
						<h6 class="w3-text-teal"><i class="fa fa-calendar fa-fw w3-margin-right"></i>Aug 2016 - <span class="w3-tag w3-teal w3-round">Nuvarande</span></h6>
						<p>Backendutvecklare med C#</p>
						<hr />
					</div>
					<div class="w3-container">
						<h5 class="w3-opacity"><b>Jensen Education</b></h5>
						<h6 class="w3-text-teal"><i class="fa fa-calendar fa-fw w3-margin-right"></i>Aug 2008 -  Jan 2010</h6>
						<p>Databasadministration- och utveckling.</p>
						<hr />
					</div>
					<div class="w3-container">
						<h5 class="w3-opacity"><b>Tyresö Gymnasium</b></h5>
						<h6 class="w3-text-teal"><i class="fa fa-calendar fa-fw w3-margin-right"></i>Aug 2005 - Jun 2008</h6>
						<p>Samhällskunskap inriktning samhällsvetenskap</p><br>
					</div>
				</div>

			<!-- End Right Column -->
			</div>
			
		<!-- End Grid -->
		</div>
		  
		<!-- End Page Container -->
		</div>

		<footer class="w3-container w3-teal w3-center w3-margin-top">
			<p>Find me on social media.</p>
			<i class="fa fa-facebook-official w3-hover-opacity"></i>
			<i class="fa fa-instagram w3-hover-opacity"></i>
			<i class="fa fa-snapchat w3-hover-opacity"></i>
			<i class="fa fa-pinterest-p w3-hover-opacity"></i>
			<i class="fa fa-twitter w3-hover-opacity"></i>
			<i class="fa fa-linkedin w3-hover-opacity"></i>
		</footer>

	</body>
</html>