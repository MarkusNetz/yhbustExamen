<?php
// PHP INI-settings
date_default_timezone_set('Europe/Stockholm');
ini_set("error_reporting", E_ALL);
error_reporting(E_ALL);
ini_set("display_errors", 1);

// $path="/etc";
// set_include_path(get_include_path() . PATH_SEPARATOR . $path);

// Paths and names.
// $top_level is set at start of every page.
$subdomain_level="";
if(stripos($_SERVER['REQUEST_URI'],"/netzv/") !== false ){
	$sub_link="/netzv/";
	$subdomain_level=$top_level."netzv/";
}
include $top_level. "ini/setup_names_paths.php";

// Metadata
$metadata=
	"<meta charset='UTF-8'>"
	."<meta name='viewport' content='width=device-width, initial-scale=1'>";
// initial setup from top_level ini about css files like bootstrap, w3.css and variable-names for those includes.
include "setup_css.php";

/* PHPMailer */
include($top_level . $folder_ini . "/setup_phpMailer.php");

/*
*	 Include files specific for this domain
*/
if(!empty($subdomain_level))
	include $subdomain_level . $folder_interface . "interfaces.php";
// User class
if(!empty($subdomain_level))
	include $subdomain_level . $folder_class . "user.class.php";
if(!empty($subdomain_level))
	include $subdomain_level . $folder_ini . "set_href_names.php";


/* 
*	DATABASE CONNECTION includes
*/

include $top_level . $folder_class . $file_class_db;
// Setup sql-modes and connectivity.
$sqlMode_MySQL_ver_5_7="ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION";
$sqlMode_MariaDB_ver_10_2_4="NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION,STRICT_TRANS_TABLES,ERROR_FOR_DIVISION_BY_ZERO";


// include "db-config.php"; // From etc-folder.
include $top_level . $folder_ini . $file_dbConnect; // Initializes a db-connection.

// Include these after successfull db-connection is established.
if(!empty($subdomain_level)){
	include $subdomain_level . $folder_inc . "function.login.php";
	sec_session_start(); // Needed to make session-related ( login-related) queries and management on site.
	include $subdomain_level . $folder_class . "LoginCheck.class.php";
	include $subdomain_level . $folder_inc . "function.setupLoggedIn.php";
}