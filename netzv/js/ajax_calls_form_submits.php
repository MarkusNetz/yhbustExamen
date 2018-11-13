<?php
$top_level="../../";
require ($top_level . "ini/settings.php");
// include $sub_link.$folder_inc."function.list_builds.php";
$data = $errors = null;
if(isset($_POST['event']) ){
	include "../". $folder_inc ."function.form_submits.php";
	
	if( $_POST['event'] == "formSearchUserSubmit"){
		$functionRes = SearchUsers($_POST, $dbConn);
		if( $functionRes != false){
			$data['searchReturnRows']=$functionRes;
		}
		else{
			$errors['searchUsers']="Fel inträffade vid sökning av profiler.";
		}
	}
	
	elseif( $_POST['event'] == "formWorkSubmit"){
		if($_POST['submitType']=="saveWork")
			$crudAction="update";
		elseif($_POST['submitType']=="addWork")
		{
			$crudAction="add";
			$data['addWork']=true;
		}
		$processWorkForm = crudCvWork($crudAction, $_POST, $dbConn);
		if($processWorkForm == false){
			$errors['processWorkFormFailed']="Ett fel inträffade när arbetslivsuerfarenhet skulle hanteras.";
			$errors['processWorkFormType']=$actionCrud;
			
		}
		else{
			$data['ajaxContent'] = $processWorkForm;
		}
	}
	elseif( $_POST['event'] == "formEduSubmit"){
		if($_POST['submitType'] == "saveEdu")
			$crudAction="update";
		elseif($_POST['submitType'] == "addEdu"){
			$crudAction="add";
			$data['addEdu']=true;
		}
		$processEduForm = crudCvEdu($crudAction, $_POST, $dbConn);
		if($processEduForm == false){
			$errors['processEduFormFailed']="Ett fel inträffade när arbetslivsuerfarenhet skulle hanteras.";
			$errors['processEduFormType']=$actionCrud;
		}
		else{
			$data['ajaxContent'] = $processEduForm;
		}
	}
	// Spara nytt cv för att arbeta med.
	elseif(isset($_POST['event']) && $_POST['event'] == "formCvCreateSubmit" && isset($loggedInUser) ){
		$boolAddNewCv = AddNewCv($dbConn, $_POST, $loggedInUser->getUserId() ); // Returns false on failure and returns db-inserted id of the cv.
		if($boolAddNewCv == false)
			$errors['addNewCvError']="Kunde inte spara nytt cv.";
		else{
			include("../inc/function.bitly_shortlinks.php");
			$data['newCvId'] = $boolAddNewCv; // Add cv-lastinsert id to data var to be returned to cv-page.
			$data['loggedInUser'] = $loggedInUser->getUserId(); // Add cv-lastinsert id to data var to be returned to cv-page.
			$shortLink = make_bitly_url("https://netzarna.eu/netzv/cv/?userID=". $data['loggedInUser'] ."&cvID=". $data['newCvId'], bitly_access_token);
			if( $shortLink != false){
				$dbConn->query("INSERT INTO t_cv_has_shortlink( id_shortlink, id_cv) VALUES(:param_id_shortlink, :param_id_cv)");
				$dbConn->bind(":param_id_shortlink", $shortLink);
				$dbConn->bind(":param_id_cv", $data['newCvId']);
				$dbConn->execute();
			}
		}
	}

	// Avgör om ett call gick bra eller ej, sett ur ett serverside-perspektiv. Det kan fortfarande gå dåligt vid js-bearbetning efteråt.	
	if ( ! empty( $errors )) {
        // if there are items in our errors array, return those errors
        $data['success'] = false;
        $data['errors']  = $errors;
    } else {

		// if there are no errors return a message

		// show a message of success and provide a true success variable
		$data['success'] = true;
		$data['message'] = 'Success!';
    }
	
	// Skriv ut data som returneras som svar.
	echo json_encode($data);
}