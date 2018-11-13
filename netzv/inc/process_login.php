<?php
$top_level="../../";
$sub_top_level=$top_level."netzv/";
require_once $top_level."ini/settings.php";
include_once $sub_top_level . $folder_class . "login.class.php";

if (isset($_POST['credEntryUser'], $_POST['credEntryPhrase'])) {
    $entryUser = $_POST['credEntryUser'];
    $entryPhrase = $_POST['credEntryPhrase']; // The plain password.... Needed to use PHPs hash_verify and so on.
	echo "Startar login-funktion process. ";
	$loginProcess = $ClassProcessLogin->Login($entryUser, $entryPhrase, $dbConn);
    if ( $loginProcess == true ) {
		// Login success 
		// echo "<h3>Success</h3><p>Du har blivit inloggad.</p>";
		header("Location: ". $subdomain_level ."profile/");
    }else {
        // Login failed 
		// echo "<h3>Failed</h3><p>Det gick inte att logga in med dina uppgifter.</p>";
        header("Location: ". $subdomain_level ."login/?error=1");
    }
}
// Denna del avfyras vid ajax-anrop. Ifall en fb-connected användare är inloggad så ska vi på ajax-sidan först kolla om det finns en aktiv inloggning på appen med den det befintliga användaridt. Om ingen sådan session finns vill vi att systemet också ska göra en inloggning på dessa credentials.
elseif (isset($_POST['process'],$_POST['fb_uid'],$_POST['fb_pri_mail']) && $_POST['process'] == "fbProcessingOauth" ) {
	$loginProcess = $ClassProcessLogin->LoginFb($_POST, $dbConn);
    if ( $loginProcess == true ) {
		// Login success 
		// echo "<h3>Success</h3><p>Du har blivit inloggad.</p>";
		// header("Location: ". $subdomain_level ."profile/");
		return true;
    }else {
        // Login failed 
		// echo "<h3>Failed</h3><p>Det gick inte att logga in med dina uppgifter.</p>";
        // header("Location: ". $subdomain_level ."login/?error=1");
		return false;
    }
}
else {
    // The correct POST variables were not sent to this page. 
        header("Location: ". $subdomain_level ."login/");   
}