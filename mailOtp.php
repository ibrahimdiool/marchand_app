<?php
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';

function mailOtp($email, $idMarchand)
{
    $name = "Nom du client";
    //$email = $_POST["email"];

    //Instantiation and passing `true` enables exceptions
    $mail = new PHPMailer(true);

    try {
        //Enable verbose debug output
        $mail->SMTPDebug = 0; //SMTP::DEBUG_SERVER;

        //Send using SMTP
        $mail->isSMTP();

        //Set the SMTP server to send through
        $mail->Host = 'smtp.gmail.com';

        //Enable SMTP authentication
        $mail->SMTPAuth = true;

        //SMTP username
        $mail->Username = 'ibrahim@diool.com';

        //SMTP password
        $mail->Password = 'Peti nono#';

        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );

        //Enable TLS encryption;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;

        //TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
        $mail->Port = 587;

        //Recipients
        $mail->setFrom('ibrahim@diool.com', 'Diool (le systeme)');

        //Add a recipient
        $mail->addAddress($email, $name);

        //Set email format to HTML
        $mail->isHTML(true);

        $verification_code = substr(number_format(time() * rand(), 0, '', ''), 0, 6);

        $mail->Subject = 'Email verification';
        $mail->Body    = '<p>Your verification code is: <b style="font-size: 30px;">' . $verification_code . '</b></p>';

        $mail->send();

        require("connexion.php");
        $base->exec("SET CHARACTER SET utf8");

        $req00 = "UPDATE marchand set otpMail='$verification_code' WHERE id ='$idMarchand'";
        $base->exec($req00);
        $reponse =  "Code OTP envoyer par mail saisissez le ou \n \n 1. pour envoyer le code a nouveau";
    } catch (Exception $e) {
        $reponse = "Erreur recommencer le processus: {$mail->ErrorInfo}";
    }
    return $reponse;
}
