<?php
$top_level="../../";
require ($top_level . "ini/settings.php");

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
if(isset($_POST['event']) && $_POST['event'] == "addUserSkill"){
	$_POSTskillName=filter_input(INPUT_POST,'skillName', FILTER_SANITIZE_STRING);
	$queryFine=false;
	if($_POST['skillTemplate']==false){
		
		// Vid icke false så har id för lastInsert returnerats och kan då binda denna.
		$returnAddSkill = AddNonExistentSkill($dbConn,$_POSTskillName, $loggedInUser->getUserId());
		if($returnAddSkill == false){
			echo "kunde inte spara ner ny skill i databasen";
			$queryFine=false;
			return false;
		}
		else{
			$queryFine=true;
			$stmtAddUserSkill=$dbConn->query("INSERT INTO t_user_has_skills (id_skill, id_user) VALUES( :param_skill_id, :param_id_user)");
			$stmtAddUserSkill->bind(":param_skill_id", $returnAddSkill);
		}
	}
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
			return false;
		}
		return false;
	}
}

include $sub_link.$folder_inc."function.list_builds.php";

function AddNonExistentSkill($pdoDbConn,$skill2Add, $userReporterId){
	$pdoDbConn->query("INSERT INTO t_skills (skill_name, user_reporter) VALUES(:param_skill_name, :param_id_user_reporter)");
	$pdoDbConn->bind(":param_skill_name", $skill2Add);
	$pdoDbConn->bind(":param_id_user_reporter", $userReporterId);
	if($pdoDbConn->execute() == true)
		return $pdoDbConn->lastInsertId;
	else
		return false;
}