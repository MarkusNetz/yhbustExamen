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
	$dbConn->beginTransaction();
	if($_POST['skillTemplate']==false){
		$dbConn->query("INSERT INTO t_skills (skill_name) VALUES(:param_skill_name)");
		$dbConn->bind(":param_skill_name", $_POSTskillName);
	}
	$dbConn->query("INSERT INTO t_user_has_skills (id_skill, id_user) VALUES( (SELECT id_skill from t_skills WHERE skill_name = :param_skill_name), :param_id_user);");
	$dbConn->bind(":param_skill_name", $_POSTskillName);
	$dbConn->bind(":param_id_user", $loggedInUser->getUserId());
	if($dbConn->execute() == true){
		$dbConn->endTransaction();
		
		echo BuildSkills($dbConn, $loggedInUser->getUserId());
	}
	else
		return false;
}

function BuildSkills($dbConn, $user){
	$dbConn->query("SELECT s.skill_name, s.skill_description, us.id_user_skill FROM t_user_has_skills us JOIN t_skills s ON us.id_skill = s.id_skill WHERE id_user = :param_id_user");
	$dbConn->bind(":param_id_user", $user);
	$resultUserSkills=$dbConn->resultSet();
	$buildSkillSet="";
	foreach($resultUserSkills as $userSkillRow){
		$buildSkillSet.="<span class='skill_". $userSkillRow['id_user_skill']." w3-padding-small w3-round-xxlarge w3-teal w3-margin-right' title='". $userSkillRow['skill_description'] ."'>". $userSkillRow['skill_name'] ." <a href='#' data-skillId='". $userSkillRow['id_user_skill'] ."' style='text-decoration:none;' class='w3-show-inline-block removeSkill fa fa-times-circle'></a></span>";
	}
	return $buildSkillSet;
}