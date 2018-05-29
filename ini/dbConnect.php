<?php
define("HOST", "cpsrv31.misshosting.com");
define("USER", "pjdqirfm_markus");
define("PASSWORD", "i.D!r3kVw0ah");
define("DATABASE", "pjdqirfm_netz");
$dbConn = new Database();

$dbConn->query("SET NAMES utf8mb4");
$dbConn->execute();
$dbConn->query("SET lc_time_names = 'sv_SE'");
$dbConn->execute();