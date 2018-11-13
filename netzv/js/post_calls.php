<?php
$top_level="../../";
require ($top_level . "ini/settings.php");
include $sub_link.$folder_inc."function.list_builds.php";

$errors=$data="";
if(isset($_REQUEST['event']) ){
		
	// Ta bort användares färdighet.
	if(isset($_POST['event']) && $_POST['event'] == "removeUserSkill"){
		$_POSTskillID=filter_input(INPUT_POST,'skillID', FILTER_VALIDATE_INT);
		$dbConn->query("DELETE FROM t_user_has_skills WHERE id_user_skill = :param_user_skill AND id_user = :param_id_user");
		$dbConn->bind(":param_user_skill", $_POSTskillID);
		$dbConn->bind(":param_id_user", $loggedInUser->getUserId());
		if($dbConn->execute() == true){
			echo BuildSkills($dbConn,$loggedInUser->getUserId());
		}
		else
			return false;
	}

	// Spara ner ny färdighet.
	if(isset($_POST['event']) && $_POST['event'] == "addUserSkill"){
		$_POSTskillName=filter_input(INPUT_POST,'skillName', FILTER_SANITIZE_STRING);
		$queryFine=false;
		
		if($_POST['skillTemplate'] == false){
			
			// Vid icke false så har id för lastInsert returnerats och kan då binda denna.
			$returnAddSkill = AddNonExistentSkill($dbConn,$_POSTskillName, $loggedInUser->getUserId());
			if($returnAddSkill == false){
				$errors['skillAddError']="kunde inte spara ner ny förslag-skill i databasen.";
				$queryFine=false;
				return false;
			}
			else{
				$queryFine=true;
				$stmtAddUserSkill=$dbConn->query("INSERT INTO t_user_has_skills (id_skill, id_user) VALUES( :param_skill_id, :param_id_user)");
				$stmtAddUserSkill->bind(":param_skill_id", $returnAddSkill);
			}
		}
		
		// Förstår faktikst inte varför jag har denna ifsats... Måste byggas om... Antagligen så ska man tvinga ner en insättning i db om en likadan inte redan finns. Denna används för att hämta ut en datalist som användarna får förslag ifrån.
		if($_POST['skillTemplate']==false && $queryFine == false){
			$stmtAddUserSkill->query("INSERT INTO t_user_has_skills (id_skill, id_user) VALUES((SELECT id_skill FROM t_skills s WHERE s.skill_name = :param_skill_name), :param_id_user)");
			$stmtAddUserSkill->bind(":param_skill_name", $_POSTskillName);
			$queryFine=true;
		}
		
		if($queryFine==true){
			$stmtAddUserSkill->bind(":param_id_user", $loggedInUser->getUserId());
			
			if($stmtAddUserSkill->execute() == true){
				echo BuildSkills($dbConn, $loggedInUser->getUserId());
			}
			else{
				$errors['addUserSkill']="Kunde inte spara ny skill på användare.";
			}
		}
	}

// Avgör om ett call gick bra eller ej, sett ur ett serverside-perspektiv. Det kan fortfarande gå dåligt vid js-bearbetning efteråt.	
}

if ( !empty($errors)) {
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