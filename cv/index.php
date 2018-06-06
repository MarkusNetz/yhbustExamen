<?php
$top_level="../";
require_once $top_level . "ini/" . "settings.php";
if(!filter_has_var(INPUT_GET,'userID') && !filter_has_var(INPUT_GET,'cvID')){
	header("location: ../profile/");
}
if( isset($_POST['submitting'])){
	if(isset($_POST['submitType'])){
		if( strpos( $_POST['submitType'], 'Work') !== false){
			$rowCountWorkXP = filter_input(INPUT_POST, "rowCountWorkXP", FILTER_VALIDATE_INT);
			if(filter_has_var(INPUT_POST, "work_id"))
				$cv_work_id=filter_input(INPUT_POST, "work_id", FILTER_VALIDATE_INT);
			if( $_POST['submitType'] == "saveWork" )
			{
				$nrOfRowsInForm=$_POST['rowCountWorkXP']; // Total number of rows from form.
				// var_dump($_POST);
				foreach($_POST['row_work_id'] as $row_work_id){
					$save_work_title=$save_work_employer=$save_start_date=$save_end_date=$save_current_work="";
					$save_work_title = filter_input( INPUT_POST, "work_title_". $row_work_id, FILTER_SANITIZE_STRING );
					$save_work_employer = filter_input( INPUT_POST, "work_employer_". $row_work_id, FILTER_SANITIZE_STRING );
					$save_start_date = filter_input( INPUT_POST, "start_date_". $row_work_id );
					$save_end_date = filter_input( INPUT_POST, "end_date_". $row_work_id );
					if(isset($_POST['current_work_'. $row_work_id ])){
						$save_current_work = filter_input( INPUT_POST, "current_work_". $row_work_id );
					}
					if( (empty($save_end_date) && empty($save_current_work)) || (!empty($save_current_work) && $save_current_work == 1 ))
						$save_end_date="9999-12-31";
					echo "Slutdatum $row_work_id: ". $save_end_date.". ";
				}
			}
			elseif($_POST['submitType']=="addWork"){
				echo "Sparar data om nytt jobb";
				var_dump($_POST);
			}
		}
		elseif( strpos( $_POST['submitType'], "Edu") !== false){
			if( $_POST['submitType'] == "saveEdu" ){
				echo "Sparar data om befintlig utb.";
				
			}
			elseif( $_POST['submitType'] == "addEdu" ){
				echo "Sparar data om ny utb.";
			}
		}
		else{}
	}
}


include $top_level . $folder_class . $file_class_cv;
$myCurriculum=new curriculum();


?>
<!DOCTYPE html>
<html lang='sv'>
	<head>
		<title>Curriculum Vitae</title>
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
	</head>
	<body class="w3-light-grey">
		<script src="/js/fb-sdk.js"></script>
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
							<div class="w3-display-bottommiddle w3-container w3-text-white w3-black w3-opacity">
								<h2 class="Toggle-CV-Business"><a href="./card.php">Markus Netz</a></h2>
							</div>
						</div>
						<div class="w3-container">
							<a class="w3-btn w3-orange w3-round-large w3-right w3-margin-top" href="/cv/edit.php?cvID=1"><i class="fa fa-edit"></i> Ändra</a>
							<p><i class="fa fa-briefcase fa-fw w3-margin-right w3-large w3-text-teal"></i> Databasadministratör</p>
							<p><i class="fa fa-home fa-fw w3-margin-right w3-large w3-text-teal"></i> Stockholm, Sverige</p>
							<p><i class="fa fa-envelope fa-fw w3-margin-right w3-large w3-text-teal"></i> markus.netz.89@gmail.com</p>
							<p><i class="fa fa-phone fa-fw w3-margin-right w3-large w3-text-teal"></i> 073 - 362 90 96</p>
							<hr>

							<p class="w3-large"><b><i class="fa fa-asterisk fa-fw w3-margin-right w3-text-teal"></i><?php echo $myCurriculum->getHeaderSkills();?></b> <a href=''><i class='fa fa-pencil'></i></a></p>
							
								<?php
								$skillList = $myCurriculum->getSkillsList($dbConn);
								echo $skillList;
								?>
							<br />

							<p class="w3-large"><b><i class="fa fa-globe fa-fw w3-margin-right w3-text-teal"></i><?php echo $myCurriculum->getHeaderLanguages();?></b></p>
							<?php
								$langList=$myCurriculum->getLangugesList($dbConn);
								echo $langList;
							?>
							<br />
						</div>
					</div><br />

			<!-- End Left Column -->
			</div>

			<!-- Right Column -->
			<div class="w3-twothird">
			
				<div class="w3-container w3-card w3-white w3-margin-bottom">
					<form id='formWork' action="<?php echo "./?userID=1&cvID=1"; ?>" method="post">
						
					<div class="w3-row">
						<h2 class="w3-text-grey w3-padding-16 w3-col l7">
							<i class="fa fa-suitcase fa-fw w3-margin-right w3-xxlarge w3-text-teal"></i>
							<?php echo $myCurriculum->getHeaderWork();?>
						</h2>
						<div class="w3-col l5 w3-margin-top w3-padding-top">
							<a href='./?userID=1&cvID=1&edit=work#formWork' class="w3-button w3-mobile w3-amber w3-right fa fa-pencil-alt"> Ändra</a>
							<a href="./?userID=1&cvID=1&add=work#formWork" class="w3-button w3-mobile w3-light-green w3-right fa fa-plus"> Lägg till</a>
						</div>
					<?php if( isset($_GET['add']) || isset($_GET['edit']) ){ ?>
						<div class="w3-col l5 w3-padding-top">
							<a href="./?userID=1&cvID=1" class="w3-button w3-mobile w3-red w3-right fa fa-close"> Avbryt</a>
							<button type="submit" name="submitting" class="w3-button w3-mobile w3-light-gray w3-right fa fa-save" value="formWork"> Spara</button>
						</div>
					<?php
					}
					?>
					</div>
					<?php
					$workList = $myCurriculum->getWorkExperiencesList($dbConn);
					echo $workList;
					?>
					</form>
				</div>

				<div class="w3-container w3-card w3-white">
					<form id='formEdu' action="<?php echo "./?userID=1&cvID=1&".( isset($_GET['save']) ? "save=edu" : isset($_GET['add']) ? "add=edu" : "" ); ?>" method="post">
					<h2 class="w3-text-grey w3-padding-16"><i class="fa fa-certificate fa-fw w3-margin-right w3-xxlarge w3-text-teal"></i><?php echo $myCurriculum->getHeaderEducation();?></b> <?php echo ( isset($_GET['edit']) && $_GET['edit']=="edu" ? "<button type='submit' class='w3-button w3-xlarge'><i class='fa fa-check'></i></button>  <a class='w3-button w3-xlarge' href='./?userID=1&cvID=1'><i class='fa fa-close w3-xlarge'></i></a>" : "<a href='./?userID=1&cvID=1&edit=edu'><i class='fa fa-pencil'></i></a>" )?></h2>
					<?php
					$eduList = $myCurriculum->getEducationsList($dbConn);
					echo $eduList;
					
					?>
					</form>
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
		<script>
			$(document).ready(function(){
				$("input[type='checkbox']").change( function(){
					if($(this).attr("data-checkToggleInput") ==1 ){
						var attr_row_id=$(this).attr("data-rowId");
						if ( $( this ).prop( "checked" ) ){
							$("#end_date_" + attr_row_id).prop("disabled", true);
							$("#end_date_" + attr_row_id).prop("required", false);
							$( this ).prop("required", true);
						}
						else{
							$("#end_date_" + attr_row_id).prop("disabled", false);
							$("#end_date_" + attr_row_id).prop("required", true);
							$( this ).prop("required", false);
						}
					}
				});
			});
		</script>
	</body>
</html>