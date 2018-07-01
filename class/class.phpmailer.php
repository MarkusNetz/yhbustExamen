<?php
$mail = new PHPMailer\PHPMailer\PHPMailer(true);
$mail = new PHPMailer;
$mail->setFrom('from@example.com', 'Your Name');
$mail->addAddress('markus.netz.89@gmail.com', 'My Friend');
$mail->Subject  = 'First PHPMailer Message';
$mail->Body     = 'Hi! This is my first e-mail sent through PHPMailer.';


$mail->Host = "smtp.gmail.com"; // Hämtas från psl-config.
// Default setting for $mail->SMTPAuth is false, so I only change the value for when it is set to true in the psl-config.php file from etc-folder.
// if( !empty(PHPMailerSMTPAuth) &&  PHPMailerSMTPAuth == true ){
	$mail->SMTPAuth = PHPMailerSMTPAuth; // Hämtas från psl-config.
	// $mail->Username = PHPMailerSMTPUserName; // Hämtas från psl-config.
	$mail->Username = trombler@gmail.com; // Hämtas från psl-config.
	// $mail->Password = PHPMailerSMTPPass; // Hämtas från psl-config.php.
	$mail->Password = 'RZ3DpkldVVUQLO$&nME4uDU5&Mwyd'; // Hämtas från psl-config.php.
// }
// $mail->SMTPSecure = PHPMailerSMTPSecure; // Hämtas från psl-config.php
$mail->SMTPSecure = "tls"; // Hämtas från psl-config.php
// $mail->Port = PHPMailerPort; // från psl-config.php. 8025, 587 and 25 can also be used. 
$mail->Port = "587"; // från psl-config.php. 8025, 587 and 25 can also be used. 

if(!$mail->send()) {
  echo 'Message was not sent.';
  echo 'Mailer error: ' . $mail->ErrorInfo;
} else {
  echo 'Message has been sent.';
}