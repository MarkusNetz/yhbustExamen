<?php
$top_level="../";
require_once $top_level."ini/settings.php";
include_once $top_level . $folder_class . "login.class.php";

if (isset($_POST['credEntryUser'], $_POST['credEntryPhrase'])) {
    $entryUser = $_POST['credEntryUser'];
    $entryPhrase = $_POST['credEntryPhrase']; // The plain password.... Needed to use PHPs hash_verify and so on.
	echo "Startar login-funktion process. ";
	$loginProcess = $ClassProcessLogin->Login($entryUser, $entryPhrase, $dbConn);
    if ( $loginProcess == true ) {
		// Login success 
		echo "<h3>Success</h3><p>Du har blivit inloggad.</p>";
		// header('Location: ../protected_page.php');
    }else {
        // Login failed 
		echo "<h3>Failed</h3><p>Det gick inte att logga in med dina uppgifter.</p>";
        // header('Location: ../index.php?error=1');
    }
} else {
    // The correct POST variables were not sent to this page. 
    echo 'Invalid Request';
}
echo $_SESSION['user_id'];