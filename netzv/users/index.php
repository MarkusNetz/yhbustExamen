<?php
$top_level="../../";
$sub_top_level=$top_level."netzv/";
require_once $top_level . "ini/settings.php";

if( $LoginCheck->LoginCheck($dbConn) == true )
{
	
	$loggedInUser = new loggedInUser($dbConn);
}
else
{
	header("location " . $sub_top_level . "login/");
}

?>
<!DOCTYPE html>
<html lang='sv'>
	<head>
		<title>Hitta profiler - NetZV</title>
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
		
		<script src="<?php echo $sub_top_level . $folder_js; ?>form-submits.js"></script>
		<script src="<?php echo $sub_top_level . $folder_js; ?>functions.generic.js"></script>
		<script src="<?php echo $sub_top_level . $folder_js; ?>function.calls.js" /></script>
	</head>
	<body class="w3-theme-l5" id="myPage">
		<div id="fb-root"></div>
		<script src="<?php echo $sub_top_level . $folder_js; ?>fb.js"></script>
		
		<!-- Inkludera underdomänens nav-meny. -->
		<?php include $sub_top_level . $folder_inc . $file_sub_dom_nav; ?>

		<!-- Team Container -->
		<section class="w3-container w3-center w3-white" id="team">
			<div class="w3-padding-32">
				<h2>Sida under uppbyggnad</h2>
				<p>Här kommer du senare kunna söka efter profiler för att visa dem.</p>
			</div>
			<div>
				<form id="searchUsers" class="SubmitFormSearchUsers" action="./" method="get">
					<input type="hidden" name="event" value="formSearchUserSubmit" />
					
					<input type="text" name="suName" />
					<input type="email" name="suEmail" />
					
					<input type="submit" value="Leta användarprofiler" />
				</form>
			</div>
		</section>
			
		<section class="w3-container w3-margin-top w3-margin-bottom w3-sand">
			<div id="userResults" class="w3-content">
			</div>
		</section>
		
		<?php
		include($sub_top_level . $folder_inc . "page.footer.php");
		?>
	</body>
</html>

