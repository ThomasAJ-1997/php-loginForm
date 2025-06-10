<?php

$email = $_POST['email'];

require "../vendor/autoload.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

$mail = new PHPMailer(true);

//$mail->SMTPDebug = SMTP::DEBUG_SERVER;

$mail->isSMTP();
$mail->SMTPAuth = true;

$mail->Host = "???";
$mail->SMTPSecure = '???';
$mail->Port = '???';
$mail->Username = '???';
$mail->Password = '???';

$mail->isHTML(true);

return $mail;