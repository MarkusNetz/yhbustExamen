<?php
$back = "../";
$folderClasses = "class";
$folderIni = "ini";

include "db-config.php";
include $folderClasses . "/database.class.php";

$sql_mode_def_5_7="ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION";
$sql_set_sql_mode="SET SESSION sql-mode='$sql_mode_def_5_7'";
?>