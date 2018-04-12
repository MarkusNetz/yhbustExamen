<?php
// PHP INI-settings
date_default_timezone_set('Europe/Stockholm');

// Paths and names.
$top_level="";
$folder_class = "class";
$folder_ini = "ini";
$folder_inc = "inc";
$file_class_db="database.class.php";
$file_nav="nav.php";
// $path_include="../".$folder_inc;
// $path_class="../".$folder_class."/";

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

// jQuery.
$jquery_3_3_1="<script src='https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js'></script>";
// jquery to include.
$jquery=$jquery_3_3_1;

// Fonts
$netz_css="<link rel='stylesheet' href='../css/netz.css'>";
$font_awesome="<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css'>";
$font_roboto="<link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Roboto'>";

// Include files
include "db-config.php"; // From etc-folder.
include($folder_class . "/" . $file_class_db); //Relative path to class.

// Setup sql-modes and connectivity.
$sql_mode_def_5_7="ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION";
$sql_set_sql_mode="SET SESSION sql-mode='$sql_mode_def_5_7'";
?>