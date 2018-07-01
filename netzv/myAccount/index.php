<?php
$top_level="../../";
require_once $top_level."ini/settings.php";

$ExternalUserProfile="";
if( $loggedInUser != null )
{
	// No specific action. The user is logged in and has not requested another user. Continue with showing the logged in users profile.
}
else{
	header("location: ". $sub_link);
}

?>
<!DOCTYPE html>
<html lang="sv">
	<head>
		<title>Hantera mitt konto - NetZV</title>
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
		// echo $bootstrap_css;
		// echo $bootstrap_js;
		
		/*	jQuery library 	*/
		echo $jquery; ?>
	</head>
	<body class="w3-theme-l5" id="accountsPage">
		<script src="<?php echo $sub_link;?>js/fb-sdk.js"></script>
		<?php include $subdomain_level . $folder_inc . $file_sub_dom_nav; ?>
		
		<!-- Team Container -->
		<section class="w3-container w3-center w3-white" id="profilePresentation">
			<div class="w3-padding-16 w3-row">
				<h2><span class="w3-bottombar w3-border-teal"><?php echo ( isset($loggedInUser) ? $loggedInUser->getDisplayName() : (isset($ExternalUserProfile) ? $ExternalUserProfile->getDisplayName() : "" ) ); ?></span></h2>
			</div>
			
			<div class="w3-padding-16 w3-row">
				<div class="w3-half">
					<h1>Kontoinställningar<i class="fa fa-"></i></h1>
					<p>
					<?php
					echo ( isset($loggedInUser) ? $loggedInUser->getProfileProfessional() : (isset($_GETrequestProfile) ? $ExternalUserProfile->getProfileProfessional() : ""));
					?>
					</p>
				</div>
				<div class="w3-half">
					<h1>Personlig info<i class="fa fa-"></i></h1>
					<p>
					<?php
					echo ( isset($loggedInUser) ? $loggedInUser->getProfileCareer() : (isset($_GETrequestProfile) ? $ExternalUserProfile->getProfileCareer() : ""));
					?>
					</p>
				</div>
			</div>
		</section>
		
		<!-- CV-section -->
		<section class="w3-container w3-padding-32 w3-center w3-row" id="curriculum">
			<?php
			// Lists the CV of logged in user or of requested profile user.
			echo (isset($loggedInUser) ? $loggedInUser->getListOfCvs() : (isset($_GETrequestProfile) ? $ExternalUserProfile->getListOfCvs() : "") );
			
			// Only show the create new cv-button if logged in.
			if( isset($loggedInUser)){
			?>
			<a href="<?php echo $sub_link;?><?php echo (isset($loggedInUser) ? "cv/?userID=".$loggedInUser->getUserId()."&newCv=yes" : "register/?show=noAccInfo"); ?>">
				<div class="w3-quarter w3-card w3-border-big w3-white w3-padding-16 w3-hover-pale-green w3-display-container" style="min-height:11.25em; border:3px dashed black">
					<span class="w3-button w3-white w3-yellow w3-display-middle w3-hover-white w3-round-xxlarge">Skapa nytt CV</span>
				</div>
			</a>
			<?php
			}
			?>
		</section>

		<!-- Footer -->
		<!--footer class="w3-container w3-padding-32 w3-theme-d1 w3-center">
			
		</footer-->
	</body>
</html>