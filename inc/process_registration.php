<?php
$top_level="../";
require_once $top_level."ini/settings.php";
include_once 'function.login.php';
if(isset($_POST['submitNewAcc'])){
	var_dump($_POST);
	$save_accFirstName=$_POST['accFirstName'];
	$save_accLastName=$_POST['accLastName'];
	$save_accDateOfBirth=$_POST['accDateOfBirth'];
	$save_accContactType=$_POST['accContactType'];
	$save_accContactInfo=$_POST['accContactInfo'];
	$save_accEmail=$_POST['accEmail'];
	$save_accPassOne=$_POST['accPassOne'];
	$save_accPassTwo=$_POST['accPassTwo'];
	if($save_accPassOne === $save_accPassTwo)
		$setPassPhrase = password_hash($save_accPassOne, PASSWORD_DEFAULT);
	
	$dbConn->beginTransaction();
	$dbConn->query("INSERT INTO t_users(name_first, name_last, personal_number, unique_hash) VALUES(:param_accFirstName, :param_accLastName, :param_dateOfBirth, :param_unique_hash)");
	$dbConn->bind(":param_accFirstName",$save_accFirstName);
	$dbConn->bind(":param_accLastName",$save_accLastName);
	$dbConn->bind(":param_dateOfBirth",$save_accDateOfBirth);
	$dbConn->bind(":param_unique_hash",password_hash( uniqid("zten_".mt_rand().$save_accLastName.$save_accDateOfBirth), PASSWORD_DEFAULT));
	$dbConn->execute();
	$newUserId=$dbConn->lastInsertId();
	
	$dbConn->query("INSERT INTO t_user_has_contact_info(id_user, id_contact_type, contact) VALUES(:param_id_user1, :save_accContactType1, :param_accContactInfo1),(:param_id_user2, :save_accContactType2, :param_accContactInfo2)");
	$dbConn->bind(":param_id_user1",$newUserId);
	$dbConn->bind(":param_id_user2",$newUserId);
	$dbConn->bind(":save_accContactType1",1);
	$dbConn->bind(":save_accContactType2",$save_accContactType);
	$dbConn->bind(":param_accContactInfo1",$save_accEmail);
	$dbConn->bind(":param_accContactInfo2",$save_accContactInfo);
	$dbConn->execute();
	
	$dbConn->query("INSERT INTO t_user_has_login(id_user, login, passphrase, pass_updated) VALUES(:param_id_user, :param_accEmail, :param_accPassPhrase, NOW())");
	$dbConn->bind(":param_id_user",$newUserId);
	$dbConn->bind(":param_accEmail",$save_accEmail);
	$dbConn->bind(":param_accPassPhrase",$setPassPhrase);
	$dbConn->execute();
	$dbConn->endTransaction();
}