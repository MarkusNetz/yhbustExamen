<?php
function addUserToApp( $infoSrc, $pdo)
{
	if($infoSrc == "registerform"){
		if( isset($_POST) ){
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
			else{
				return false;
			}
			
			$pdo->beginTransaction();
			$pdo->query("INSERT INTO t_users(name_first, name_last, personal_number, unique_hash) VALUES(:param_accFirstName, :param_accLastName, :param_dateOfBirth, :param_unique_hash)");
			$pdo->bind(":param_accFirstName",$save_accFirstName);
			$pdo->bind(":param_accLastName",$save_accLastName);
			$pdo->bind(":param_dateOfBirth",$save_accDateOfBirth);
			$pdo->bind(":param_unique_hash",password_hash( uniqid("zten_".mt_rand().$save_accLastName.$save_accDateOfBirth), PASSWORD_DEFAULT));$pdo->beginTransaction();

			$pdo->query("INSERT INTO t_user_has_contact_info(id_user, id_contact_type, contact) VALUES(:param_id_user1, :save_accContactType1, :param_accContactInfo1),(:param_id_user2, :save_accContactType2, :param_accContactInfo2)");
			$pdo->bind(":param_id_user1",$newUserId);
			$pdo->bind(":param_id_user2",$newUserId);
			$pdo->bind(":save_accContactType1",1);
			$pdo->bind(":save_accContactType2",$save_accContactType);
			$pdo->bind(":param_accContactInfo1",$save_accEmail);
			$pdo->bind(":param_accContactInfo2",$save_accContactInfo);
			
			$pdo->query("INSERT INTO t_user_has_login(id_user, login, passphrase, pass_updated) VALUES(:param_id_user, :param_accEmail, :param_accPassPhrase, NOW())");
			$pdo->bind(":param_id_user",$newUserId);
			$pdo->bind(":param_accEmail",$save_accEmail);
			$pdo->bind(":param_accPassPhrase",$setPassPhrase);
			$pdo->endTransaction();
		}
	}
	elseif($infoSrc="fbtable"){
	
	}
}



function addUserAccountFromOAuth( $userInfoArray, $pdo, $t_users_id=null,$param_contact_type_name="mail" )
{
	
	$pdo->beginTransaction();
	if( $t_users_id == null){
		$uq_hash = password_hash( uniqid( "zten_" . mt_rand() . $userInfoArray[2] . $$userInfoArray[0] ), PASSWORD_DEFAULT);
		$pdo->query( "INSERT INTO t_users(name_first, name_last, unique_hash) VALUES(:param_FirstName, :param_LastName, :param_unique_hash)" );
		$pdo->bind( ":param_FirstName", $userInfoArray[1] );
		$pdo->bind( ":param_LastName", $userInfoArray[2] );
		$pdo->bind( ":param_unique_hash", $uq_hash );
		$pdo->execute();
		$t_users_id = $pdo->lastInsertId();
		
		$pdo->query("INSERT INTO t_user_has_contact_info ( id_user, contact, id_contact_type) VALUES(:param_user_id,:param_user_email, (SELECT id_contact_type FROM t_contact_types ct WHERE ct.name = :param_contact_type_name LIMIT 0,1;))");
		$pdo->bind(":param_user_id", $t_users_id);
		$pdo->bind(":param_contact_type_name", $param_contact_type_name);
		$pdo->bind(":param_user_email", $userInfoArray[3]);
		$pdo->execute();
		$t_user_has_contact_info_id=$pdo->lastInsertId();
	}
	$sqlAddFbUserInfo = "INSERT INTO t_user_has_facebook (fb_id, fb_email, id_user) VALUES( :param_fb_id, :param_fb_email, :param_user_id )";
	$pdo->query( $sqlAddFbUserInfo );
	$pdo->bind( ":param_fb_id",  $userInfoArray[0] );
	$pdo->bind( ":param_fb_email", $userInfoArray[3] );
	$pdo->bind( ":param_user_id", $t_users_id );
	if( $pdo->execute()  == true ){
		$t_user_has_facebook_id = $pdo->lastInsertId();
	
		$pdo->endTransaction();
	
		return true;
	}
	else
	{
		$pdo->cancelTransaction();
		return false;
	
	}
}



function updateFbTableWithUserId($id, $fbid, $fbemail, $pdo){
	$sqlUpd="UPDATE t_user_has_facebook SET id_user = :param_new_user_id WHERE fb_id = :param_fb_id AND fb_email = :param_fb_email";
	$pdo->query($sqlUpd);
	$pdo->bind(":param_new_user_id", $id);
	$pdo->bind(":param_fb_id", $fbid );
	$pdo->bind(":param_fb_email", $fbemail );
	
	if( $pdo->execute() == true)
		return true;
	else
		return false;
}