<?php
require("load_env.php");

//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';

//Instantiation and passing `true` enables exceptions
function sendEmail($email, $message, $subject) {
    $mail = new PHPMailer(true);

    try {
        //Server settings
        //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = $_ENV['EMAIL_HOST'];                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = $_ENV['EMAIL_USERNAME'];                     //SMTP username
        $mail->Password   = $_ENV['EMAIL_PASSWORD'];                               //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         //Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
        $mail->Port       =  587;                                    //TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
        $fromEmail = 'verify@luxfortis.studio';
        $fromName = 'Luxfor Studio';
        //Recipients
        $mail->setFrom($fromEmail, $fromName);
        $mail->addAddress($email);     //Add a recipient
        $mail->AddReplyTo($fromEmail, $fromName);



        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = $subject;
        $mail->Body    = $message;
        $mail->AltBody = $message;

        $mail->send();
        return true;
    } catch (Exception $e) {

        return false;
    }
}
