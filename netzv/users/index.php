<?php
$top_level="../";
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
		// echo $bootstrap_css;
		// echo $bootstrap_js;
		
		/*	jQuery library 	*/
		echo $jquery; ?>
	</head>
	<body class="w3-theme-l5" id="myPage">
		<!--script src="/js/fb-sdk.js"></script-->
		<?php include $top_level . $folder_inc . $file_main_dom_nav; ?>

		<!-- Team Container -->
		<section class="w3-container w3-center w3-white" id="team">
			<div class="w3-padding-32">
				<h2>Sida under uppbyggnad</h2>
				<p>Här kommer du senare kunna söka efter profiler för att visa dem.</p>
			</div>
		</section>
		
	</body>
</html>

