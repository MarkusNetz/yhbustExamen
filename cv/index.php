<?php
$top_level="../";
require_once $top_level . "ini/" . "settings.php";
if(!filter_has_var(INPUT_GET,'userID') && !filter_has_var(INPUT_GET,'cvID')){
	header("location: ../profile/");
}
include $top_level . $folder_class . $file_class_cv;
$myCurriculum=new curriculum();

include $top_level . $folder_class . "user.class.php";
$activeUser=new user(1);


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
		<script src='/js/fb-sdk.js'></script
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
					<form id='formWork' action="<?php echo "./?userID=1&cvID=1&save=work"; ?>" method="post">
					<h2 class="w3-text-grey w3-padding-16"><i class="fa fa-suitcase fa-fw w3-margin-right w3-xxlarge w3-text-teal"></i><?php echo $myCurriculum->getHeaderWork();?></b> <?php echo( isset($_GET['edit']) && $_GET['edit']=="work" ? "<button type='submit' class='w3-button w3-xlarge'><i class='fa fa-check'></i></button>  <a class='w3-button w3-xlarge' href='./?userID=1&cvID=1'><i class='fa fa-close w3-xlarge'></i></a>" : "<a href='./?userID=1&cvID=1&edit=work'><i class='fa fa-pencil'></i></a>" )?></h2>
					<?php
					$workList = $myCurriculum->getWorkExperiencesList($dbConn);
					echo $workList;
					?>
				</div>

				<div class="w3-container w3-card w3-white">
					<form id='formEdu' action="<?php echo "./?userID=1&cvID=1&save=edu"; ?>" method="post">
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

	</body>
</html>