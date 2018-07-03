<?php
$top_level="../../";
require_once $top_level."ini/settings.php";

$ExternalUserProfile="";
if( $loggedInUser != null && !isset($_GET['requestProfile']) || ($loggedInUser != null && isset($_GET['requestProfile']) && $loggedInUser->getUserId == $_GET['requestProfile']) )
{
	
	// No specific action. The user is logged in and has not requested another user. Continue with showing the logged in users profile.
}
else{
	if(isset($_GET['requestProfile']) ){
		$_GETrequestProfile=filter_input(INPUT_GET, "requestProfile", FILTER_VALIDATE_INT);
		$ExternalUserProfile = new RequestedProfile($_GETrequestProfile, $dbConn);
		if($ExternalUserProfile->wrongProfile == "true")
			header("location: ". $sub_link ."?reason=WrongProfileRequested");
	}
	else{
		header("location: ". $sub_link);
	}
}

?>
<!DOCTYPE html>
<html lang="sv">
	<head>
		<title><?php echo ( isset($loggedInUser) ? $loggedInUser->getDisplayName() : (isset($ExternalUserProfile) ? $ExternalUserProfile->getDisplayName() : "" ) 	); ?> - NetZV</title>
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
	<body class="w3-theme-l5" id="profilePage">
		<script src="<?php echo $sub_link;?>js/fb-sdk.js"></script>
		<?php include $subdomain_level . $folder_inc . $file_sub_dom_nav; ?>
		
		<!-- Team Container -->
		<section class="w3-container w3-center w3-white" id="profilePresentation">
			<div class="w3-padding-16 w3-row">
				<h2><span class="w3-bottombar w3-border-teal"><?php echo ( isset($loggedInUser) ? $loggedInUser->getDisplayName() : (isset($ExternalUserProfile) ? $ExternalUserProfile->getDisplayName() : "" ) ); ?></span></h2>
			</div>
			
			<div class="w3-padding-16 w3-row">
				<div class="w3-half">
					<h1>Yrkesvision<i class="fa fa-"></i></h1>
					<p>
					<?php
					echo ( isset($loggedInUser) ? $loggedInUser->getProfileProfessional() : (isset($_GETrequestProfile) ? $ExternalUserProfile->getProfileProfessional() : ""));
					?>
					</p>
				</div>
				<div class="w3-half">
					<h1>Karriärmål<i class="fa fa-"></i></h1>
					<p>
					<?php
					echo ( isset($loggedInUser) ? $loggedInUser->getProfileCareer() : (isset($_GETrequestProfile) ? $ExternalUserProfile->getProfileCareer() : ""));
					?>
					</p>
				</div>
			</div>
		</section>
		
		<!-- CV-section -->
		<section class="w3-container w3-padding-32 w3-center" id="curriculum">
			<?php
			// Lists the CV of logged in user or of requested profile user.
			echo (isset($loggedInUser) ? $loggedInUser->getListOfCvs() : (isset($_GETrequestProfile) ? $ExternalUserProfile->getListOfCvs() : "") );
			
			// Only show the create new cv-button if logged in.
			if( isset($loggedInUser)){
				if( $loggedInUser -> nrOfCreatedCvs < 2 || ($loggedInUser -> nrOfCreatedCvs >= 2 && $loggedInUser->PayingUser() == true)){
			?>
				<a href="<?php echo $sub_link;?><?php echo (isset($loggedInUser) ? "cv/?userID=".$loggedInUser->getUserId()."&newCv=yes" : "register/?show=noAccInfo"); ?>">
					<div class="w3-quarter w3-card w3-border-big w3-white w3-padding-16 w3-hover-pale-green w3-display-container" style="min-height:11.25em; border:3px dashed black">
						<span class="w3-button w3-white w3-yellow w3-display-middle w3-hover-white w3-round-xxlarge">Skapa nytt CV</span>
					</div>
				</a>
			<?php
				}
			}
			?>
		</section>
		
		<?php
		$datalist="<datalist id='skills_list'>";
		$dbConn->query("SELECT skill_name, id_skill FROM t_skills");
		$skillsResult=$dbConn->resultSet();
		foreach($skillsResult as $skillsRow){
			$datalist.= "<option class='addSkillToList' data-skill_list_id='". $skillsRow['id_skill'] ."' value='". $skillsRow['skill_name']."' />";
		}
		$datalist.="</datalist>";
		?>
		<section class="w3-container w3-padding-32 w3-white">
			<h2 class="w3-show-inline-block">Färdigheter</h2> <div class="w3-show-inline-block">
			<input type="text" name="addUserSkill" id="addUserSkill" value="" placeholder="Lägg till färdighet" class="w3-input w3-round-xlarge w3-border w3-border-black w3-padding-small" list="skills_list" /></div>
			<?php echo $datalist;?>
			<div class="skillsList">
				<?php echo $loggedInUser->MyProfileSkills($dbConn);?>
			</div>
		</section>

		<script>
		$(document).ready(function(){
			$(".skillsList").on("click","a.removeSkill",function(event){
				event.preventDefault();
				
				$.post("/netzv/js/post_calls.php",
				{
					event: "removeUserSkill",
					skillID: $(this).attr("data-skillId")
				},
				function(data, status){
					if(status == "success")
					{
						$(".skillsList").html(data );
					}
				});
			});
			
			$("#addUserSkill").on("input",function(){
				var enteredVal=$(this).val();
				
				if( $("#skills_list option").filter(function(){
					return this.value === enteredVal;
				}).length){
					var skillExistsFromTemplate=true;
					// alert("Clicked a new skill to add." + enteredVal + ". It exists in datalist.");
					// This if now only matches the existing items. If no items are matched, the entry should be added to table and then be able to be reused by other users :)
					// The users will contribute to the total backlog of items possible to add as skills.
					
				}
				else
					var skillExistsFromTemplate=false;
				
				$.post("/netzv/js/post_calls.php", 
				{
					event: "addUserSkill",
					skillName: enteredVal,
					skillTemplate: $skillExistsFromTemplate
				},
				function(data, status){
					if(status == "success")
					{
						$(".skillsList").html(data);
					}
				});
			
			});
			
			
		});
		</script>
	</body>
</html>