<?php
function crudCvWork($crudAction, $postArr, $dbConn){
	
	$_GETcvID = $_POST['getCvId'];
	$rowCountWorkXP = filter_input(INPUT_POST, "rowCountWorkXP", FILTER_VALIDATE_INT);
	if(filter_has_var(INPUT_POST, "work_id"))
		$cv_work_id=filter_input(INPUT_POST, "work_id", FILTER_VALIDATE_INT);
	
	if( $crudAction == "update"){
		$nrOfRowsInForm=$_POST['rowCountWorkXP']; // Total number of rows from form.
		$dbConn->beginTransaction();
		$sqlUpdateWorkRows="UPDATE t_cv_work_experience SET work_time = :work_time, start_date = :start_date, end_date = :end_date, employer = :work_employer, work_title= :work_title, work_description = :work_description WHERE id_work_experience = :id_work_experience";
		$dbConn->query( $sqlUpdateWorkRows );
		// Loop over all distinct work_ids from $_POST.
		$executeLoop=true;
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
			if(!$dbConn->execute()){
				$executeLoop = false;
				break 1;
			}
		}
		
		// Check if there were any errors while executing statements inside the above foreach loop;
		if($executeLoop == true)
			$dbConn->endTransaction();
		else
			$dbConn->cancelTransaction();
	}
	elseif($crudAction == "add"){
		$dbConn->beginTransaction();
		$sqlInsertWorkRow="INSERT INTO t_cv_work_experience (id_cv, work_time, start_date, end_date, employer, work_title, work_description) VALUES (:id_cv, :work_time, :start_date, :end_date, :work_employer, :work_title, :work_description)";
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
		if($dbConn->execute()){
			$dbConn->endTransaction();
			
			$dateObjStartDate   = DateTime::createFromFormat('Y-m-d', $save_start_date);
			$dateStartName = $dateObjStartDate->format('M Y'); // March
			$dateStartName= str_replace("y","j",$dateStartName);
			$dateStartName= str_replace("Oc","Ok",$dateStartName);
			
			$dateObjEndDate   = DateTime::createFromFormat('Y-m-d', $save_end_date);
			$dateEndName = $dateObjEndDate->format('M Y'); // March
			$dateEndName= str_replace("y","j",$dateEndName);
			$dateEndName= str_replace("Oc","Ok",$dateEndName);
			
			$returnDiv=
				"<div class='w3-container' id='workXpRow_". $dbConn->lastInsertId() ."'>"
					."<div class='w3-row'>"
					
						."<div class='w3-col m10 l10 w3-hide-small'>"
							."<h5 class='w3-opacity'><b>". $save_work_title ." / ". $save_work_employer ."</b> ". $save_work_time ."</h5>"
						."</div>"
						
						."<div class='w3-mobile w3-hide-medium w3-hide-large'>"
							."<h5 class='w3-opacity'><b>". $save_work_title ." / ". $save_work_employer ."</b> ". $save_work_time ."</h5>"
						."</div>"
						
						."<div class='m2 l2 w3-hide-small'>"
							. (isset($GLOBALS['_GETuserID'] ) ? "<a href='./?userID=".$GLOBALS['_GETuserID']."&cvID=". $GLOBALS['_GETcvID'] ."&action=delete&actionID=". $dbConn->lastInsertId() ."&actionDelete=work' class='". $objProps->getBtnDeleteNonSmallScreen() ." delCvItem' type='submit'><i class='fa fa-trash-alt'></i></a>" : "")
						."</div>"
					."</div>"
					
					."<h6 class='w3-text-teal'>"
						."<i class='fa fa-calendar fa-fw w3-margin-right'></i>"
						.ucfirst($dateStartName) . " - "  . ( $save_end_date != "9999-12-31" ? ucfirst($dateEndName) : "<span class='w3-tag w3-teal w3-round'>Nuvarande</span>" )
					."</h6>"
					
					."<p>". $save_work_description ."</p>"
					
					."<div class='w3-mobile w3-hide-medium w3-hide-large'>"
						. (isset($GLOBALS['_GETuserID']) ? "<a href='./?userID=".$GLOBALS['_GETuserID'] . "&cvID=".$GLOBALS['_GETcvID']."&action=delete&actionID=". $id_workXp ."&actionDelete=work' class='". $objProps->getBtnDeleteSmallScreen() ." delCvItem' type='submit'><i class='fa fa-trash-alt'></i></a>" : "")
					."</div>"
					
					."<hr />"
				."</div>";
			return $returnDiv;
		}
		else{
			$dbConn->cancelTransaction();
			return false;
		}
	}
		
/*
 *	Skola/utbildningar
 */
	elseif( strpos( $_POST['submitType'], "Edu") !== false){}
}

function crudCvWorkEdu($crudAction){
	
	/*
	Uppdatera befintliga rader om utbildning/kurser
	*/
	$_GETcvID = $_POST['getCvId'];
	if( $crudAction == "update" ){
		$nrOfRowsInForm=$_POST['rowCountEdu']; // Total number of rows from form.
		$dbConn->beginTransaction();
		$sqlUpdateEduRows="UPDATE t_cv_educations SET edu_time = :edu_time, start_date = :start_date, end_date = :end_date, school = :edu_school, education_title= :edu_title, education_description = :edu_description WHERE id_education = :id_education";
		$dbConn->query( $sqlUpdateEduRows );
		// Loop over all distinct work_ids from $_POST.
		$executeLoop=true;
		foreach($_POST['row_edu_id'] as $row_edu_id){
			// empty strings.
			$save_edu_time=$save_edu_title=$save_edu_description=$save_edu_school=$save_start_date=$save_end_date="";
			
			// Get values from $_POST.
			$save_edu_title = filter_input( INPUT_POST, "edu_title_".$row_edu_id, FILTER_SANITIZE_STRING );
			$save_edu_time = filter_input( INPUT_POST, "edu_time_".$row_edu_id, FILTER_SANITIZE_STRING );
			$save_edu_school = filter_input( INPUT_POST, "edu_school_".$row_edu_id, FILTER_SANITIZE_STRING );
			$save_edu_description = htmlspecialchars($_POST["education_description_".$row_edu_id]);
			$save_start_date = filter_input( INPUT_POST, "start_date_".$row_edu_id );
			if( empty( $_POST['end_date_'.$row_edu_id] ) )
				$save_end_date="9999-12-31";
			else
				$save_end_date = filter_input( INPUT_POST, "end_date_".$row_edu_id );
			
			// Bind-values
			$dbConn->bind( ":edu_title", $save_edu_title );
			$dbConn->bind( ":edu_school", $save_edu_school );
			$dbConn->bind( ":edu_time", $save_edu_time );
			$dbConn->bind( ":edu_description", $save_edu_description );
			$dbConn->bind( ":start_date", $save_start_date );
			$dbConn->bind( ":end_date", $save_end_date );
			$dbConn->bind( ":id_education", $row_edu_id );
			if(!$dbConn->execute()){
				$executeLoop = false;
				break 1;
			}
		}
		// Check if there were any errors while executing statements inside the above foreach loop;
		if($executeLoop == true)
			$dbConn->endTransaction();
		else
			$dbConn->cancelTransaction();
	}
	/*
		Lägg till ny rad om utbildning/kurser.
	*/
	elseif( $crudAction == "add" )
	{
		$dbConn->beginTransaction();
		$sqlInsertEduRow="INSERT INTO t_cv_educations (id_cv,edu_time, start_date, end_date,school, education_title, education_description) VALUES(:id_cv,:edu_time, :start_date, :end_date,:edu_school,:edu_title, :edu_description)";
		$dbConn->query( $sqlInsertEduRow );
		// empty strings.
		$save_edu_time=$save_edu_title=$save_edu_description=$save_edu_school=$save_start_date=$save_end_date="";
		
		// Get values from $_POST.
		$save_edu_title = filter_input( INPUT_POST, "edu_title", FILTER_SANITIZE_STRING );
		$save_edu_time = filter_input( INPUT_POST, "edu_time", FILTER_SANITIZE_STRING );
		$save_edu_school = filter_input( INPUT_POST, "edu_school", FILTER_SANITIZE_STRING );
		$save_edu_description = htmlspecialchars($_POST["education_description"]);
		$save_start_date = filter_input( INPUT_POST, "start_date" );
		if( empty($_POST['end_date']) )
			$save_end_date="9999-12-31";
		else
			$save_end_date = filter_input( INPUT_POST, "end_date" );
			
		$dbConn->bind( ":edu_time", $save_edu_time );
		$dbConn->bind( ":edu_title", $save_edu_title );
		$dbConn->bind( ":edu_school", $save_edu_school );
		$dbConn->bind( ":edu_description", $save_edu_description );
		$dbConn->bind( ":start_date", $save_start_date );
		$dbConn->bind( ":end_date", $save_end_date );
		$dbConn->bind( ":id_cv", $_GETcvID );
		if($dbConn->execute()){
			$dbConn->endTransaction();
			
			$dateObjStartDate   = DateTime::createFromFormat('Y-m-d', $save_start_date);
			$dateStartName = $dateObjStartDate->format('M Y'); // March
			$dateStartName= str_replace("y","j",$dateStartName);
			$dateStartName= str_replace("Oc","Ok",$dateStartName);
			
			$dateObjEndDate   = DateTime::createFromFormat('Y-m-d', $save_end_date);
			$dateEndName = $dateObjEndDate->format('M Y'); // March
			$dateEndName= str_replace("y","j",$dateEndName);
			$dateEndName= str_replace("Oc","Ok",$dateEndName);
			
			$returnDiv=
				"<div class='w3-container' id='eduRow_". $dbConn->lastInsertId() ."'>"
						
						."<div class='w3-row'>"
							
							."<div class='w3-col m10 l10 w3-hide-small'>"
								."<h5 class='w3-opacity'><b>". $educations['education_title']." / ". $educations['school']."</b></h5>"
							."</div>"
							
							."<div class='w3-mobile w3-hide-medium w3-hide-large'>"
								."<h5 class='w3-opacity'><b>". $educations['education_title']." / ". $educations['school']."</b></h5>"
							."</div>"
							
							."<div class='m2 l2 w3-hide-small w3-show-block-inline'>"
								. (isset($GLOBALS['_GETuserID']) ? "<a href='./?userID=". $GLOBALS['_GETuserID'] ."&cvID=". $GLOBALS['_GETcvID'] ."&action=delete&actionID=". $id_edu ."&actionDelete=edu' class='w3-button w3-circle w3-right w3-white delCvItem' type='submit'><i class='fa fa-trash-alt'></i></a>" : "" )
							."</div>"
							
						."</div>"
						
						."<h6 class='w3-text-teal' style='width:80%>"
							."<i class='fa fa-calendar fa-fw w3-margin-right'></i>"
							. $save_start_date  . " - "  . ( $educations['end_date_name'] != "Pågående" ? $educations['end_date'] : "<span class='w3-tag w3-teal w3-round'>". $educations['end_date_name'] ."</span>" )
						."</h6>"
						
						."<p>". $educations['education_description']."</p>"
						
						."<div class='w3-mobile w3-hide-medium w3-hide-large'>"
							. (isset($GLOBALS['_GETuserID']) ? "<a href='./?userID=". $GLOBALS['_GETuserID'] ."&cvID=".$GLOBALS['_GETcvID']."&action=delete&actionID=". $id_edu ."&actionDelete=edu' class='w3-border-none". $objProps->getBtnDeleteSmallScreen() ." delCvItem' type='submit'><i class='fa fa-trash-alt'></i></a>" : "" )
						."</div>"
						
						."<hr />"
					."</div>";
			return $returnDiv;
		}
		else
		{
			$dbConn->cancelTransaction();
			return false;
		}
	}
	else
		return false;
}


function AddNewCv( $pdo, $formPostData, $userOwner ){
	$sqlInsertUHCv = "INSERT INTO t_user_has_cv(id_user, name, description) VALUES(:param_id_user,:param_cv_name,:param_cv_desc)";
	$pdo->query($sqlInsertUHCv);
	$pdo->bind( ":param_id_user", $userOwner );
	$pdo->bind( ":param_cv_name", filter_input(INPUT_POST, "beginCvName", FILTER_SANITIZE_STRING ) );
	$pdo->bind( ":param_cv_desc", htmlspecialchars($_POST['beginCvDesc']) );
	if($pdo->execute()){
		return $pdo->lastInsertId();
	}
	else
		return false;
}

function SearchUsers( $searchValArr, $pdo){
	$rowProfiles=null;
	$sqlSelectUserProfiles="SELECT * FROM t_users u";
	$pdo->query( $sqlSelectUserProfiles );
	foreach($pdo->resultSet() as $profileRow)
	{
		$rowProfiles.= "<div class='w3-card w3-quarter' id='userResult_" . ( isset($profileRow['id_user']) ? $profileRow['id_user'] : "" )."'>". $profileRow['name_first']." ".$profileRow['name_last']."</div>";
	}
	
	if( !empty( $rowProfiles ) )
		return $rowProfiles;
	else
		return false;
}