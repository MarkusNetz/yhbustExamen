<?php
function BuildSkills($dbConn, $user){
	$dbConn->query("SELECT s.skill_name, s.skill_description, us.id_user_skill FROM t_user_has_skills us JOIN t_skills s ON us.id_skill = s.id_skill WHERE id_user = :param_id_user");
	$dbConn->bind(":param_id_user", $user);
	$resultUserSkills=$dbConn->resultSet();
	$buildSkillSet=$buildSkillOptions=null;
	
	// the profile skills list that will show the users added skills.
	foreach($resultUserSkills as $userSkillRow){
		$buildSkillSet.="<div class='s6 w3-section w3-margin-left w3-margin-right w3-show-inline-block'><span class='skill_". $userSkillRow['id_user_skill']." w3-padding-small w3-round-xxlarge w3-teal' title='". $userSkillRow['skill_description'] ."'>". $userSkillRow['skill_name'] ." <a href='#' data-skillId='". $userSkillRow['id_user_skill'] ."' style='text-decoration:none;' class='removeSkill fa fa-times-circle'></a></span></div>";
	}
	
	// Datalist options containing all available skills.
	$dbConn->query("SELECT id_skill, s.skill_name, s.skill_description FROM t_skills s");
	$resultAllSkills=$dbConn->resultSet();
	foreach($resultAllSkills as $skillsRow){
		$buildSkillOptions.="<option class='addSkillToList' data-skill_list_id='". $skillsRow['id_skill'] ."' value='". $skillsRow['skill_name'] ."' />";
	}
	
	return $buildSkillSet."%%".$buildSkillOptions;
}


function AddNonExistentSkill($pdoDbConn,$skill2Add, $userReporterId){
	$pdoDbConn->query("INSERT INTO t_skills (skill_name, user_reporter) VALUES(:param_skill_name, :param_id_user_reporter)");
	$pdoDbConn->bind(":param_skill_name", $skill2Add);
	$pdoDbConn->bind(":param_id_user_reporter", $userReporterId);
	if($pdoDbConn->execute() == true)
		return $pdoDbConn->lastInsertId;
	else
		return false;
}