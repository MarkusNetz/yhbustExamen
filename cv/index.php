<?php
$top_level="../";
require_once $top_level . "ini/" . "settings.php";
if(!filter_has_var(INPUT_GET,'userID') && !filter_has_var(INPUT_GET,'cvID')){
	header("location: ../profile/");
}
else{
	$_GETcvID = filter_input(INPUT_GET, "cvID", FILTER_VALIDATE_INT);
	$_GETuserID = filter_input(INPUT_GET, "userID", FILTER_VALIDATE_INT);
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
				$dbConn->beginTransaction();
				$sqlUpdateWorkRows="UPDATE t_cv_work_experience SET ork_time = :work_time, start_date = :start_date, end_date = :end_date, employer = :work_employer, work_title= :work_title, work_description = :work_description WHERE id_work_experience = :id_work_experience";
				$dbConn->query( $sqlUpdateWorkRows );
				// Loop over all distinct work_ids from $_POST.
				foreach($_POST['row_work_id'] as $row_work_id){
					// Empty all strings.
					$save_work_title=$save_work_description=$save_work_employer=$save_start_date=$save_end_date=$save_current_work="";
					
					// Get $_POST-values.
					$save_work_title = filter_input( INPUT_POST, "work_title_". $row_work_id, FILTER_SANITIZE_STRING );
					$save_work_time = filter_input( INPUT_POST, "work_time_". $row_work_id, FILTER_SANITIZE_STRING );
					$save_work_employer = filter_input( INPUT_POST, "work_employer_". $row_work_id, FILTER_SANITIZE_STRING );
					$save_work_description = htmlspecialchars($_POST["work_description_". $row_work_id]);
					$save_start_date = filter_input( INPUT_POST, "start_date_". $row_work_id );
					$save_end_date = filter_input( INPUT_POST, "end_date_". $row_work_id );
					if(isset($_POST['current_work_'. $row_work_id ])){
						$save_current_work = filter_input( INPUT_POST, "current_work_". $row_work_id );
					}
					if( (empty($save_end_date) && empty($save_current_work)) || (!empty($save_current_work) && $save_current_work == 1 ))
						$save_end_date="9999-12-31";
					
					// Bind-values
					$dbConn->bind( ":work_title", $save_work_title );
					$dbConn->bind( ":work_time", $save_work_time );
					$dbConn->bind( ":work_employer", $save_work_employer );
					$dbConn->bind( ":start_date", $save_start_date );
					$dbConn->bind( ":end_date", $save_end_date );
					$dbConn->bind( ":work_description", $save_work_description );
					$dbConn->bind( ":id_work_experience", $row_work_id );
					$dbConn->execute();
				}
				$dbConn->endTransaction();
			}
			elseif($_POST['submitType']=="addWork"){
				$sqlInsertWorkRow="INSERT INTO t_cv_work_experience (id_cv, work_time, start_date, end_date, employer, work_title, work_description) VALUES (:id_cv, :start_date, :end_date, :work_employer, :work_title, :work_description)";
				$dbConn->query( $sqlInsertWorkRow );
				// empty strings.
				$save_work_title=$save_work_description=$save_work_employer=$save_start_date=$save_end_date=$save_current_work="";
				
				// Get values from $_POST.
				$save_work_title = filter_input( INPUT_POST, "work_title", FILTER_SANITIZE_STRING );
				$save_work_time = filter_input( INPUT_POST, "work_time", FILTER_SANITIZE_STRING );
				$save_work_employer = filter_input( INPUT_POST, "work_employer", FILTER_SANITIZE_STRING );
				$save_work_description = htmlspecialchars($_POST["work_description"]);
				$save_start_date = filter_input( INPUT_POST, "start_date" );
				$save_end_date = filter_input( INPUT_POST, "end_date" );
				if( isset( $_POST['current_work'] ) ){
					$save_current_work = filter_input( INPUT_POST, "current_work" );
				}
				if( (empty($save_end_date) && empty($save_current_work)) || (!empty($save_current_work) && $save_current_work == 1 ))
					$save_end_date="9999-12-31";
				
				$dbConn->bind( ":work_title", $save_work_title );
				$dbConn->bind( ":work_time", $save_work_time );
				$dbConn->bind( ":work_employer", $save_work_employer );
				$dbConn->bind( ":start_date", $save_start_date );
				$dbConn->bind( ":end_date", $save_end_date );
				$dbConn->bind( ":work_description", $save_work_description );
				$dbConn->bind( ":id_cv", $_GETcvID );
				$dbConn->execute();
			}
		}
		elseif( strpos( $_POST['submitType'], "Edu") !== false){
			var_dump($_POST);
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
	<body class="w3-light-grey" id="cvPresentation">
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
							<div class="w3-display-bottommiddle w3-container w3-text-white w3-black w3-opacity w3-twothird w3-center">
								<h2 class="Toggle-CV-Business w3-xlarge"><a href="./card.php">Markus Netz</a></h2>
							</div>
						</div>
						<div class="w3-container">
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
						<div class="w3-col l7 w3-margin-top w3-padding-top w3-mobile">
							<h2 class="w3-text-grey w3-padding-16 w3-col">
								<i class="fa fa-suitcase fa-fw w3-margin-right w3-xxlarge w3-text-teal"></i>
								<?php echo $myCurriculum->getHeaderWork();?>
							</h2>
						</div>
						<div class="w3-col l5 w3-margin-top w3-padding-top">
			<?php	if( (isset($_GET['add']) && $_GET['add'] == "work") || (isset($_GET['edit']) && $_GET['edit'] == "work") ){ ?>
							<a href="./?userID=1&cvID=1" class="w3-button w3-mobile w3-red w3-half fa fa-ban"> Avbryt</a>
							<button type="submit" name="submitting" class="w3-button w3-mobile w3-light-green w3-half fa fa-save" value="formWork"> Spara</button>
			<?php	}
					else{	?>
							<a href='./?userID=1&cvID=1&edit=work#formWork' class="w3-button w3-half w3-amber fa fa-pencil-alt"> Ändra</a>
							<a href="./?userID=1&cvID=1&add=work#formWork" class="w3-button w3-half w3-light-green fa fa-plus"> Lägg till</a>
			<?php	}	?>
						</div>
					</div>
					<?php
					$workList = $myCurriculum->getWorkExperiencesList($dbConn);
					echo $workList;
					?>
					</form>
				</div>

				<div class="w3-container w3-card w3-white">
					<form id='formEdu' action="<?php echo "./?userID=1&cvID=1"; ?>" method="post">
					<div class="w3-row">
						<div class="w3-col l7 w3-margin-top w3-padding-top w3-mobile">
							<h2 class="w3-text-grey w3-padding-16 w3-col">
								<i class="fa fa-certificate fa-fw w3-margin-right w3-xxlarge w3-text-teal"></i>
								<?php echo $myCurriculum->getHeaderEducation();?>
							</h2>
						</div>
			<?php	if(1==1){ ?>
						<div class="w3-col l5 w3-margin-top w3-padding-top">
			<?php	if( (isset($_GET['add']) && $_GET['add'] == "edu") || (isset($_GET['edit']) && $_GET['edit'] == "edu") ){ ?>
							<a href="./?userID=1&cvID=1" class="w3-button w3-mobile w3-red w3-half fa fa-ban"> Avbryt</a>
							<button type="submit" name="submitting" class="w3-button w3-mobile w3-light-green w3-half fa fa-save" value="formEdu"> Spara</button>
			<?php	}
					else{	?>
							<a href='./?userID=1&cvID=1&edit=edu#formEdu' class="w3-button w3-half w3-amber fa fa-pencil-alt"> Ändra</a>
							<a href="./?userID=1&cvID=1&add=edu#formEdu" class="w3-button w3-half w3-light-green fa fa-plus"> Lägg till</a>
			<?php	}	?>
						</div>
			<?php	}	?>
					</div>
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