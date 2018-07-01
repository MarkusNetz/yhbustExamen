<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
$PHPMailerDir="PHPMailer/";
// require "./".$PHPMailerDir.'vendor/autoload.php'; // composer autoloader, not implemented. RECOMMENDED WAY.
require $top_level.$PHPMailerDir . 'src/PHPMailer.php';
require $top_level.$PHPMailerDir . 'src/SMTP.php';
require $top_level.$PHPMailerDir . 'src/Exception.php';
// include($top_level . "class/class.phpmailer.php"); // This file is an working example file. Not included becuase it sends an email every time it is included.