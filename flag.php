<?php
$top_level="";
require_once $top_level . "ini/" . "settings.php";
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
	<body id="myPage" class="w3-theme-l5">
		<!-- Team Container -->
		<div class="w3-container w3-center w3-white w3-padding" id="team">
			<h3 class="w3-padding">Nu tar vi och firar lite på svenska flaggans dag!</h3>
				<!-- present a swedish flag -->
				<div class="w3-display-container w3-card-4 w3-yellow w3-hide-small w3-hide-medium" style="height:600px;width:1050px">
					<div class="w3-blue w3-display-topleft" style="width:25%;height:40%"></div>
					<div class="w3-blue w3-display-topright" style="width:60%;height:40%"></div>
					<div class="w3-blue w3-display-bottomleft" style="width:25%;height:40%"></div>
					<div class="w3-blue w3-display-bottomright" style="width:60%;height:40%"></div>
				</div>
				
				<div class="w3-display-container w3-card-4 w3-yellow w3-hide-small w3-hide-large" style="height:400px;width:700px">
					<div class="w3-blue w3-display-topleft" style="width:25%;height:40%"></div>
					<div class="w3-blue w3-display-topright" style="width:60%;height:40%"></div>
					<div class="w3-blue w3-display-bottomleft" style="width:25%;height:40%"></div>
					<div class="w3-blue w3-display-bottomright" style="width:60%;height:40%"></div>
				</div>
				
				<div class="w3-display-container w3-card-4 w3-yellow w3-hide-medium w3-hide-large" style="height:490px;width:280px">
					<div class="w3-blue w3-display-topright" style="width:40%;height:25%"></div>
					<div class="w3-blue w3-display-bottomright" style="width:40%;height:60%"></div>
					<div class="w3-blue w3-display-topleft" style="width:40%;height:25%"></div>
					<div class="w3-blue w3-display-bottomleft" style="width:40%;height:60%"></div>
				</div>
			</div>
		</div>
	</body>
</html>
