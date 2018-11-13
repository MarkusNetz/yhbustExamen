<?php
$top_level="../../";
$sub_top_level=$top_level . "netzv/";
require_once $top_level . "ini/" . "settings.php";

$varJQueryModal="<input type='hidden' id='newCvModalTrigger' value='0' />";

$_GETuserID=$_GETcvID="";

if(isset($_GET['cvID']))
	$_GETcvID = filter_input(INPUT_GET, "cvID", FILTER_VALIDATE_INT);
if(isset($_GET['userID']))
	$_GETuserID = filter_input(INPUT_GET, "userID", FILTER_VALIDATE_INT);

if( isset($_GETuserID) && ( isset($_GETcvID) || isset($_GET['newCv']) ) )
{
	if( isset($_GET['newCv']) && $_GET['newCv'] == "yes" )
		$varJQueryModal="<input type='hidden' id='newCvModalTrigger' value='1' />";
}
else{
	header("location: ". $sub_link ."profile/");
}

include $subdomain_level . $folder_class ."elements.class.php";
$HtmlObjProps = new HtmlObjectProperties();

// CV | Delete items in CV
if(isset($_GET['action']) && $_GET['action'] == "delete" && isset($_GET['actionID'])){
	$_GETactionID=filter_input(INPUT_GET, "actionID", FILTER_VALIDATE_INT);
	$sqlDelete="";
	// En specifierad typ måste finnas för önskad delete.
	if( isset($_GET['actionDelete']) ) {
		if($_GET['actionDelete']=="edu"){
			$sqlDelete="DELETE FROM t_cv_educations WHERE id_education = :id_action_get AND id_cv = :id_cv_get";
		}
		elseif($_GET['actionDelete']=="work"){
			$sqlDelete="DELETE FROM t_cv_work_experience WHERE id_work_experience = :id_action_get AND id_cv = :id_cv_get";
		}
	}
	// Koll att sql-satsen är gjord.
	if(!empty($sqlDelete)){
		$dbConn->beginTransaction();
		$dbConn->query($sqlDelete);
		$dbConn->bind(":id_action_get", $_GETactionID);
		$dbConn->bind(":id_cv_get", $_GETcvID);
		if($dbConn->execute()){
			$dbConn->endTransaction();
			header("location: ./?userID=".$_GETuserID."&cvID=".$_GETcvID);
		}
		else{
			$dbConn->cancelTransaction();
		}
	}
}
include $sub_top_level . $folder_class . $file_class_cv;
if( isset($_GETuserID,$_GETcvID) )
	$myCurriculum = new curriculum($_GETuserID, $_GETcvID, $dbConn, (isset($loggedInUser) && $_GETuserID == $loggedInUser->getUserId() ? "1" : "0") );

?>
<!DOCTYPE html>
<html lang='sv'>
	<head>
		<title>Curriculum Vitae - <?php echo ( isset($_GETuserID, $_GETcvID) ? $myCurriculum->getDisplayCvName() : (isset($_GET['newCv']) ? "Skapa nytt CV." : "" ) );?></title>
		<script src="https://apis.google.com/js/platform.js" async defer></script>
		
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
		<script src="<?php echo $sub_top_level . $folder_js; ?>cv.js"></script>
		<script src="<?php echo $sub_top_level . $folder_js; ?>form-submits.js"></script>
		<script src="<?php echo $sub_top_level . $folder_js; ?>functions.generic.js"></script>
		<script src="<?php echo $sub_top_level . $folder_js; ?>function.calls.js" /></script>
		<script src="<?php echo $sub_top_level . $folder_js; ?>modals.js"></script>
	</head>
	<body class="w3-light-grey" id="cvPresentation">
		<script src="<?php echo $sub_top_level . $folder_js ;?>fb.js"></script>
		<?php // include $subdomain_level . $path_inc ."/". $file_sub_dom_nav; ?>
		
		
		</div>
		<!-- Page Container -->
		<div class="w3-content w3-margin-top" style="max-width:1400px;">
			<!-- The Grid -->
			<div class="w3-row-padding">
		  
				<!-- Left Column -->
				<div class="w3-third">
			
					<div class="w3-white w3-text-grey w3-card-4">
						<div class="w3-display-container">
						
							<img src="<?php echo ( isset($myCurriculum) && !empty($myCurriculum->getDisplayAvatarDirectory()) && !empty( $myCurriculum->getDisplayAvatarFile() ) ? $myCurriculum->getDisplayAvatarDirectory().$myCurriculum->getDisplayAvatarFile() : "/netzv/images/cv/noImage.jpg");?>" style="width:100%" alt=" " />
							
							<div class="w3-display-bottommiddle w3-container w3-text-white w3-black w3-opacity w3-twothird w3-center">
								<h2 class="Toggle-CV-Business w3-xlarge"><a href="./card.php?userID=<?php echo (isset($loggedInUser) ? $loggedInUser->getUserId() : "") . (isset($_GETcvID) ? "cvID=".$_GETcvID : ""); ?>"> <?php echo (isset($myCurriculum) ? $myCurriculum->getDisplayNameBanner() : ""); ?></a></h2>
							</div>
						
						</div>
						
						<div class="w3-container">
							<p><i class="fa fa-briefcase fa-fw w3-margin-right w3-large w3-text-teal"></i> <?php echo (isset($myCurriculum) ? $myCurriculum->getDisplayWorkTitleBanner() : ""); ?></p>
							<p><i class="fa fa-home fa-fw w3-margin-right w3-large w3-text-teal"></i> <?php echo (isset($myCurriculum) ? $myCurriculum->getDisplayLocationBanner() : ""); ?></p>
							<p><i class="fa fa-envelope fa-fw w3-margin-right w3-large w3-text-teal"></i> <?php echo (isset($myCurriculum) ? $myCurriculum->getDisplayMailBanner() : "" ); ?></p>
							<p><i class="fa fa-phone fa-fw w3-margin-right w3-large w3-text-teal"></i> <?php echo (isset($myCurriculum) ? $myCurriculum->getDisplayPhoneBanner() :"" ); ?></p>
							<hr>

							<p class="w3-large"><b><i class="fa fa-asterisk fa-fw w3-margin-right w3-text-teal"></i><?php echo (isset($myCurriculum) ? $myCurriculum->getHeaderSkills() : "");?></b> <a href=''><i class='fa fa-pencil'></i></a></p>
							
								<?php
								echo (isset($myCurriculum) ? $myCurriculum->getSkillsList($dbConn) : "");
								?>
							<br />

							<p class="w3-large"><b><i class="fa fa-globe fa-fw w3-margin-right w3-text-teal"></i><?php echo (isset($myCurriculum) ? $myCurriculum->getHeaderLanguages() : "");?></b></p>
							<?php
								echo (isset($myCurriculum) ? $myCurriculum->getLangugesList($dbConn, $HtmlObjProps):"");
							?>
							<br />
						</div>
					</div><br />

			<!-- End Left Column -->
			</div>

			<!-- Right Column -->
			<div class="w3-twothird">
			
				<div class="w3-container w3-card w3-white w3-margin-bottom">
					<form id='formWork' class='SubmitFormAjax' action="./?userID=<?php echo $_GETuserID;?>&cvID=<?php echo (isset($_GETcvID) ? $_GETcvID : "");?>" method="post">
						<input type='hidden' name='event' value='formWorkSubmit' />
						<input type='hidden' name='getCvId' value="<?php echo (isset($_GETcvID) ? $_GETcvID : "");?>" />
						
						<div class="w3-row w3-margin-top">
							<div class="w3-mobile w3-threequarter w3-col m12">
								<h2 class="w3-text-grey w3-margin-top">
									<i class="fa fa-suitcase fa-fw w3-margin-right w3-xxlarge w3-text-teal"></i>
									<?php echo (isset($myCurriculum) ? $myCurriculum->getHeaderWork() :"" );?>
								</h2>
							</div>
						
					<?php	
						if(isset($loggedInUser) && $_GETuserID == $loggedInUser->getUserId())
						{
					?>
							<div class="w3-mobile w3-quarter w3-padding-top w3-margin-top w3-col m12">
							
						<?php
							if( (isset($_GET['add']) && $_GET['add'] == "work") || (isset($_GET['edit']) && $_GET['edit'] == "work") )
							{
						?>
								<a href="./?userID=<?php echo $_GETuserID;?>&cvID=<?php echo $_GETcvID;?>" class="w3-button w3-col s6 m6 l2 w3-red w3-hover-indigo w3-border w3-border-brown w3-hover-border-black">
									<i class="fa fa-times"></i>
								</a>
								<button type="submit" name="submitting" class="w3-button w3-col s6 m6 l2 w3-light-green w3-hover-indigo w3-border w3-border-brown w3-hover-border-black" value="formWork">
									<i class="fa fa-save"></i>
								</button>
						<?php
							}
							else
							{
						?>
								<a href="./?userID=<?php echo $_GETuserID;?>&cvID=<?php echo (isset($_GETcvID) ? $_GETcvID : "");?>&edit=work#formWork" class="w3-button w3-col s6 m6 l2 w3-amber w3-hover-indigo w3-border w3-border-brown w3-hover-border-black">
									<i class="fa fa-pencil-alt"> </i>
								</a>
								<a href="./?userID=<?php echo $_GETuserID;?>&cvID=<?php echo $_GETcvID;?>&add=work#formWork" class="w3-button w3-col s6 m6 l2 w3-green w3-hover-indigo w3-border w3-border-brown w3-hover-border-black modalShow" data-modal-type="modal-work-form">
									<i class="fa fa-plus"> </i>
								</a>
						<?php
							}
						?>
							</div>
					<?php
						}
					?>
						</div>
						<div id="workXpDivList">
					<?php
					echo (isset($myCurriculum) ? $myCurriculum->getWorkExperiencesList($dbConn,$HtmlObjProps) : "");
					?>
						</div>
					</form>
				</div>

				<div class="w3-container w3-card w3-white">
					<form id='formEdu' class="SubmitFormAjax" action="./?userID=<?php echo $_GETuserID;?>&cvID=<?php echo $_GETcvID;?>" method="post">
						<input type="hidden" name="event" value="formEduSbumit" />
						<input type="hidden" name="getCvId" value="<?php echo $_GETcvID;?>" />
						<div class="w3-row w3-margin-top">
							<div class="w3-mobile w3-threequarter w3-col m12">
								<h2 class="w3-text-grey w3-margin-top">
									<i class="fa fa-certificate fa-fw w3-margin-right w3-xxlarge w3-text-teal"></i>
									<?php echo (isset($myCurriculum) ? $myCurriculum->getHeaderEducation() : "");?>
								</h2>
							</div>
						
			<?php	if(isset($loggedInUser) && $_GETuserID == $loggedInUser->getUserId()){ ?>
							<div class="w3-mobile w3-quarter w3-padding-top w3-margin-top w3-col m12">
				<?php	if( (isset($_GET['add']) && $_GET['add'] == "edu") || (isset($_GET['edit']) && $_GET['edit'] == "edu") ){ ?>
								<a href="./?userID=<?php echo $_GETuserID;?>&cvID=<?php echo $_GETcvID;?>" class="w3-button w3-col s6 m6 l2 w3-red w3-hover-indigo w3-border w3-border-brown w3-hover-border-black"><i class="fa fa-times"></i></a>
								
								<button type="submit" name="submitting" class="w3-button w3-col s6 m6 l2 w3-light-green w3-hover-indigo w3-border w3-border-brown w3-hover-border-black" value="formEdu"><i class="fa fa-save"></i></button>
								<input type="hidden" name="submitAction" value="updEdu" />
				<?php	}
						else{	?>
								<input type="hidden" name="submitAction" value="addEdu" />
								<a href="./?userID=<?php echo $_GETuserID;?>&cvID=<?php echo $_GETcvID;?>&edit=edu#formEdu" class="w3-button w3-col s6 m6 l2 w3-amber w3-hover-indigo w3-border w3-border-brown w3-hover-border-black"><i class="fa fa-pencil-alt"></i></a>
								<a href="./?userID=<?php echo $_GETuserID;?>&cvID=<?php echo $_GETcvID;?>&add=edu#formEdu" class="w3-button w3-col s6 m6 l2 w3-green w3-hover-indigo w3-border w3-border-brown w3-hover-border-black modalShow" data-modal-type="modal-edu-form"><i class="fa fa-plus"></i></a>
				<?php	}	?>
							</div>
			<?php	}	?>
						</div>
						<div id="eduDivList">
						
					<?php
					echo (isset($myCurriculum) ? $myCurriculum->getEducationsList($dbConn, $HtmlObjProps) : "");
					?>
						</div>
					</form>
				<!-- End Right Column -->
				</div>
			
			<!-- End Grid -->
			</div>
		  
		<!-- End Page Container -->
		</div>

		<footer>
			<a class="w3-container w3-teal w3-center w3-margin-top w3-button w3-col s12 m12 l12" href="<?php echo "../".$_href_profile . (isset($loggedInUser) && $_GETuserID == $loggedInUser->getUserId() ? "" : "?requestProfile=".$_GETuserID ); ?>">Tillbaka till profilsidan.</a>
		</footer>
		<?php
		include ($sub_top_level . $folder_inc . "modal.cv_skillset.php");
		if(isset($_GET['newCv']) && !empty($varJQueryModal))
		{
			echo $varJQueryModal;
			include ($sub_top_level . $folder_inc . "modal.new_cv.php");
		}
		include $GLOBALS['sub_top_level'] . $GLOBALS['folder_inc'] . "modal.work_form.php";
		include $GLOBALS['sub_top_level'] . $GLOBALS['folder_inc'] . "modal.edu_form.php";
		include($sub_top_level . $folder_inc . "page.footer.php");
		?>
	</body>
</html>