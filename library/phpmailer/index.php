<?php 
require_once('class.phpmailer.php');
require_once("class.smtp.php"); // optional, gets called from within class.phpmailer.php if not already loaded

$mail             = new PHPMailer();

$body				= 'lol';

$mail->IsSMTP(); // telling the class to use SMTP
$mail->Host       = "mail.timeflix.net"; // SMTP server
$mail->SMTPDebug  = 2;                     // enables SMTP debug information (for testing)
                                           // 1 = errors and messages
                                           // 2 = messages only
$mail->SMTPAuth   = true;                  // enable SMTP authentication
$mail->Host       = "mail.timeflix.net"; // sets the SMTP server
$mail->Port       = 25;                    // set the SMTP port for the GMAIL server
$mail->Username   = "webmaster@timeflix.net"; // SMTP account username
$mail->Password   = "az01-er02";        // SMTP account password

$mail->SetFrom('webmaster@timeflix.net', 'First Last');

$mail->AddReplyTo("webmaster@timeflix.net","First Last");

$mail->Subject    = "PHPMailer Test Subject via smtp, basic with authentication";

$mail->AltBody    = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test

$mail->MsgHTML($body);

$address = "jack.gianesini@gmail.com";
$mail->AddAddress($address, "John Doe");

//$mail->AddAttachment("images/phpmailer.gif");      // attachment
//$mail->AddAttachment("images/phpmailer_mini.gif"); // attachment

if(!$mail->Send()) {
  echo "Mailer Error: " . $mail->ErrorInfo;
} else {
  echo "Message sent!";
}
 ?>