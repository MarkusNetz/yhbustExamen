<?php
$top_level="../../";
include $top_level."netzv/inc/function.list_builds.php";
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
			<h2 class="w3-mobile"><span class="w3-bottombar w3-border-teal"><?php echo ( isset($loggedInUser) ? $loggedInUser->getDisplayName() : (isset($ExternalUserProfile) ? $ExternalUserProfile->getDisplayName() : "" ) ); ?></span></h2>
			
			<div class="w3-padding-bottom w3-row">
				<div class="w3-half">
					<h1><i class="fa fa-eye"></i> Yrkesvision</h1>
					<p><i>Vad jag vill utföra eller bidra med inom ett ansvarsområde</i></p>
					<p>
						<?php
						echo ( isset($loggedInUser) ? $loggedInUser->getProfileProfessional() : (isset($_GETrequestProfile) ? $ExternalUserProfile->getProfileProfessional() : ""));
						?>
					</p>
				</div>
				
				<div class="w3-half">
					<h1> <i class="fa fa-road"></i> Karriärmål</h1>
					<p><i>Vad jag långsiktigt vill uppnå i min karriär</i></p>
					<p>
						<?php
						echo ( isset($loggedInUser) ? $loggedInUser->getProfileCareer() : (isset($_GETrequestProfile) ? $ExternalUserProfile->getProfileCareer() : ""));
						?>
					</p>
				</div>
			</div>
		</section>
		
		<!-- CV-section -->
		<section class="w3-container w3-row-padding w3-center w3-margin-top w3-margin-bottom" id="curriculum">
			<?php
			// Lists the CV of logged in user or of requested profile user.
			echo (isset($loggedInUser) ? $loggedInUser->getListOfCvs() : (isset($_GETrequestProfile) ? $ExternalUserProfile->getListOfCvs() : "") );
			
			// Only show the create new cv-button if logged in and if the user is a non-paying user it is only allowed to create a maximum of 2 cvs.
			if( isset($loggedInUser)){
				if( $loggedInUser -> nrOfCreatedCvs < 2 || ($loggedInUser -> nrOfCreatedCvs >= 2 && $loggedInUser->PayingUser() == true)){
			?>
				<a href="<?php echo $sub_link;?><?php echo (isset($loggedInUser) ? "cv/?userID=".$loggedInUser->getUserId()."&newCv=yes" : "register/?show=noAccInfo"); ?>">
					<div class="w3-col s12 m4 l3 w3-card w3-border-big w3-white w3-padding-16 w3-hover-pale-green w3-display-container" style="min-height:11.25em; border:3px dashed black">
						<span class="w3-button w3-white w3-yellow w3-display-middle w3-hover-white w3-round-xxlarge">Skapa nytt CV</span>
					</div>
				</a>
			<?php
				}
			}
			?>
		</section>
		
		<?php
		$loadIniProfileSkills=BuildSkills($dbConn, ( isset($loggedInUser) ? $loggedInUser->getUserId() : (isset($_GETrequestProfile) ? $ExternalUserProfile->getUserId() : "")));
		$skillsResult=explode("%%",$loadIniProfileSkills);
		$datalistAllSkills="<datalist id='skills_list'>". $skillsResult[1] . "</datalist>";
		$showUserAddedSkills=$skillsResult[0];
		?>
		<div id="skillContainer" class="w3-white">
			<section class="w3-container w3-section">
				<h2 class="w3-show-inline-block w3-col s12 m5 l3">Färdigheter</h2>
				
				<div class="w3-round w3-show-inline-block w3-row w3-col s12 m7 l5">
					<p>
						<input type="text" name="addUserSkill" id="addUserSkill" value="" placeholder="Lägg till färdighet" class="w3-col s10 m10 l10 w3-border-0 w3-border-bottom w3-leftbar w3-border-green w3-padding-small" list="skills_list" />
						<i id="addSkillBtn" class="w3-col s1 m1 l1 w3-button w3-green w3-hover-light-green fa fa-plus w3-padding-medium"></i>
					</p>
				</div>
				<?php echo $datalistAllSkills;?>
				
			</section>
			<div class="skillsList">
				<?php echo $showUserAddedSkills; ?>
			</div>
		</div>

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
			
			$("#addSkillBtn").on("click",function(){
				var enteredVal=$("#addUserSkill").val();
				
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
					skillTemplate: skillExistsFromTemplate
				},
				function(data, status){
					if(status == "success")
					{
						alert(data)
						splitData=data.split("%%");
						$("#addUserSkill").val("");
						$(".skillsList").html(splitData[0]);
						$("#skills_list").html(splitData[1]);
					}
				});
			
			});
			
			
		});
		</script>
	</body>
</html>