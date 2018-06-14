<?php
$top_level="../";
require_once $top_level."ini/settings.php";
include_once 'function.login.php';
 
sec_session_start(); // Our custom secure way of starting a PHP session.
 
if (isset($_POST['credEntryUser'], $_POST['credEntryPhrase'])) {
    $entryUser = $_POST['email'];
    $password = $_POST['credEntryUsername']; // The plain password.... Needed to use PHPs hash_verify and so on.
 
    if (login($email, $password, $dbConn) == true) {
        // Login success 
        header('Location: ../protected_page.php');
    } else {
        // Login failed 
        header('Location: ../index.php?error=1');
    }
} else {
    // The correct POST variables were not sent to this page. 
    echo 'Invalid Request';
}