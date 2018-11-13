<?php
$top_level="../../";
$sub_top_level="../";
require_once $top_level."ini/settings.php";
include_once 'function.login.php';
include_once 'functions.generic.php'; // Contains the function addUserToApp.

if(isset($_POST['submitNewAcc'])){
	
	if( addUserToApp( "registerform", $dbConn) != false ){
		header("location: ../profile/?event=newAccount&redirected=FromRegistrationForm&autostartCV=yes");
	}
	else{
		header("location: ". $sub_link ."register/?errCreate=Couldn't-create-account-due-to-password-mismatch");
		return false;
	}
}
