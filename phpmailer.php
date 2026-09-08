<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

//error_reporting(E_ALL);
//ini_set('display_errors', 1);

$mail = new PHPMailer(true);

try {
    //Server settings
    $mail->SMTPDebug = 2;
    $mail->isSMTP();
    $mail->Host       = 'mail.cyclerestorer.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'webmaster@cyclerestorer.com';
    $mail->Password   = '1975!Gl1000!!';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;  // Changed to SMTPS
    $mail->Port       = 465;

    //Recipients
    $mail->setFrom('Webmaster@cyclerestorer.com', 'Your Name');
    $mail->addAddress('williamneffpowell@gmail.com', 'William');

    // Content
    $mail->isHTML(true);
    $mail->Subject = 'Here is the subject';
    $mail->Body    = 'This is the HTML message body <b>in bold!</b>';
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
?>
