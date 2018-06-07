<?php
// PHP INI-settings
date_default_timezone_set('Europe/Stockholm');
ini_set("error_reporting", E_ALL);
error_reporting(E_ALL);
ini_set("display_errors", 1);

// $path="/etc";
// set_include_path(get_include_path() . PATH_SEPARATOR . $path);

// Paths and names.
$folder_class = "class/";
$folder_inc = "inc/";
$folder_ini = "ini/";
$file_class_db="database.class.php";
$file_class_cv="curriculum.class.php";
$file_nav="nav.php";

// Metadata
$metadata=
	"<meta charset='UTF-8'>"
	."<meta name='viewport' content='width=device-width, initial-scale=1'>";


// BOOTSTRAP ======================
// Latest compiled and minified CSS
$bootstrap_css_4_1_0="<link rel='stylesheet' href='https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css'>";
$bootstrap_css_3_3_7="<link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css'>";
$bootstrap_css=$bootstrap_css_4_1_0;
//Latest compiled JavaScript
$bootstrap_js_4_1_0="<script src='https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js'></script>";
$bootstrap_js_3_3_7="<script src='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js'></script>";
$bootstrap_js=$bootstrap_js_4_1_0;
// ver 3.
$bootstrap_3_3_7=$bootstrap_js_3_3_7.$bootstrap_css_3_3_7;
// ver 4
$bootstrap_4_1_0=$bootstrap_css_4_1_0.$bootstrap_js_4_1_0;
// Set version for inclusion on pages.
$bootstrap=$bootstrap_4_1_0;

// W3.CSS ==========================
$w3_css="<link rel='stylesheet' href='https://www.w3schools.com/w3css/4/w3.css' />";
$w3_theme_black="<link rel='stylesheet' href='https://www.w3schools.com/lib/w3-theme-black.css'>";
$w3_theme=$w3_theme_black;
// jQuery.
$jquery_3_3_1="<script src='https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js'></script>";
// jquery to include.
$jquery=$jquery_3_3_1;

// Fonts
$netz_css="<link rel='stylesheet' href='../css/netz.css'>";
$font_awesome='<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">';
$font_roboto="<link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Roboto'>";

// Include files
include($top_level . $folder_class . "user.class.php");

/* 
*	DATABASE CONNECTION includes
*/
// include "db-config.php"; // From etc-folder.
include $top_level . $folder_class . $file_class_db;
// Setup sql-modes and connectivity.
$sqlMode_MySQL_ver_5_7="ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION";
$sqlMode_MariaDB_ver_10_2_4="NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION,STRICT_TRANS_TABLES,ERROR_FOR_DIVISION_BY_ZERO";
include "dbConnect.php"; // Initializes a db-connection.


// Logga in
$sqlSelectUser="SELECT uhl.id_user, name_first, name_last, unique_hash, CONCAT(name_first, ' ', name_last) name_full FROM t_user_has_login uhl RIGHT JOIN t_users u USING(id_user) WHERE uhl.login = :user_login";
$param_user_login="markus.netz.89@gmail.com";
$dbConn->query($sqlSelectUser);
$dbConn->bind(":user_login", $param_user_login);
$fetchedUser=$dbConn->single();
if($dbConn->rowCount() == 1){
	// $_SESSION['']="";
	$loggedInUser=new LoggedInUser();
	$loggedInUser->setDisplayName( $fetchedUser['name_full'] );
}

//FAKE VARS
$loggedIn=1;