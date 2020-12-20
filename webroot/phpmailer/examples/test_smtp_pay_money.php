<html>
<head>
<title>PHPMailer - SMTP (Gmail) basic test</title>
</head>
<body>
	<p> test </p>
<?php
// var_dump('ici');
//error_reporting(E_ALL);
error_reporting(E_STRICT);

date_default_timezone_set('America/Toronto');

require_once('../class.phpmailer.php');
//include("class.smtp.php"); // optional, gets called from within class.phpmailer.php if not already loaded

$mail             = new PHPMailer();

$body             = file_get_contents('contents.html');
$body             = eregi_replace("[\]",'',$body);

$mail->IsSMTP(); // telling the class to use SMTP
$mail->Host       = "mail.yourdomain.com"; // SMTP server
$mail->SMTPDebug  = 1;                     // enables SMTP debug information (for testing)
                                           // 1 = errors and messages
                                           // 2 = messages only
$mail->SMTPAuth   = true;                  // enable SMTP authentication
$mail->SMTPSecure = "TLS";                 // sets the prefix to the servier
$mail->Host       = "pro2.mail.ovh.net";      // sets GMAIL as the SMTP server
$mail->Port       = 587;                   // set the SMTP port for the GMAIL server
//$mail->Username   = "test.ngser@gmail.com";  // GMAIL username
$mail->Username   = "notification@pay-money.net"; 
$mail->Password   = "usernotifier@123";            // GMAIL password

/* address: 'pro2.mail.ovh.net'
port: '993'
login: notification@pay-money.net
password: usernotifier@123 */

$mail->SetFrom('notification@pay-money.net', 'PAYMONEY');

$mail->AddReplyTo("notification@pay-money.net","PAYMONEY");

$mail->Subject    = "PHPMailer Test Subject via smtp (Gmail), basic";

$mail->AltBody    = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test

$mail->MsgHTML($body);

//$address = "romeo.kesso@ngser.com";
$address = "romekesso92@gmail.com";
$mail->AddAddress($address, "MALICK");

$mail->AddAttachment("images/phpmailer.gif");      // attachment
$mail->AddAttachment("images/phpmailer_mini.gif"); // attachment

// var_dump($mail);

if(!$mail->Send()) {
  echo "Mailer Error: " . $mail->ErrorInfo;
} else {
  echo "Message sent!";
}

?>

</body>
</html>
