<?php
define("DB_HOST", "cpsrv31.misshosting.com");
define("DB_USER", "pjdqirfm_markus");
define("DB_PASSWORD", "i.D!r3kVw0ah");
define("DB_DATABASE", "pjdqirfm_netz");
define("DB_PORT", "3306");
define("DB_CHARSET", "utf8mb4");
define("SECURE", TRUE);

$dbConn = new Database();

// First queries to be run to iniate a good connection.
// $dbConn->query("SET lc_time_names = 'sv_SE'");
// $dbConn->execute();
// $dbConn->query("SET SESSION sql_mode='". $sqlMode_MariaDB_ver_10_2_4 ."'");
// $dbConn->query("SET SESSION sql_mode='". $sqlMode_MySQL_ver_5_7 ."'");
// $dbConn->execute();