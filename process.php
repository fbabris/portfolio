<?php
require 'phpmailer/includes/Exception.php';
require 'phpmailer/includes/SMTP.php';
require 'phpmailer/includes/PHPMailer.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

$credentials = json_decode(file_get_contents('./credentials.json'), true);

$mail = new PHPMailer(true);
$mail->isSMTP();
$mail->Host = $credentials['Host'];
$mail->SMTPAuth = $credentials['SMTPAuth'];
$mail->SMTPSecure = $credentials['SMTPSecure'];
$mail->Port = $credentials['Port'];
$mail->Username = $credentials['Username'];
$mail->Password = $credentials['Password'];
$mail->addAddress($credentials['adress']);
$mail->Subject = 'Contact from web-page';
$mail->isHTML(true);
$mail->CharSet = 'UTF-8';

if (!empty($_POST)){
    $name = htmlspecialchars($_POST['name']);
    $from = htmlspecialchars($_POST['email']);
    $phone = $_POST['phone'];
    $message = htmlspecialchars($_POST['message']);
    $honeypot = $_POST['url'];
    if (!empty($honeypot)){
        echo json_encode (array('status'=> 0, 'message'=>'There was a problem'));

        die(); 
    }
    if (empty ($name) || empty ($from) || empty ($phone) || empty ($message) ){
        echo json_encode (array('status'=>0, 'message'=> 'A required field was left empty'));

        die();
    }
    $from = filter_var($from, FILTER_VALIDATE_EMAIL);
    
    if(!$from){
        echo json_encode(array('status'=>0, 'message'=>'Email adress is not valid, please try again'));

        die();
    }
    $mail->From=$from;
    $mail->FromName = $name;
    $mail->Body = $message. '<br>'. '<br>'. 'vārds: '. $name. '<br>'. 'epasts: '. $from. '<br>'. 'mob.tel: '. $phone;
    $mail->AddReplyTo($from, $name);

    if ($mail->Send ()){
        echo json_encode(array('status'=>1, 'message'=>'Email sent succesfully'));
        die();
    }
    echo json_encode(array('status'=>0, 'message'=>'Email not sent, please try again'));
    $mail->smtpClose();
}