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

$whitelist = array (
    'name',
    'email',
    'phone',
    'message',
);

foreach ($whitelist as $key ) {
    $fields[$key] = $_POST[$key];
}

foreach ( $fields as $field => $data ){
    if (empty($data)){
        $message = 'Lūdzu, aizpildiet'. $field. 'lauku.';
        echo json_encode (array('status->0', 'message' -> $message));
    }
    $fields[$field] = htmlspecialchars($data);
}

if (!empty($_POST)){
    if (!empty($_POST['url'])){
        echo json_encode (array('status'=> 0, 'message'=>'There was a problem'));
        die(); 
    }
    
    $fields['email'] = filter_var($fields['email'], FILTER_VALIDATE_EMAIL);
    if(!$fields['email']){
        echo json_encode(array('status'=>0, 'message'=>'Email adress is not valid, please try again'));
        die();
    }
    $mail->From=$fields['email'];
    $mail->FromName = $fields['name'];
    $mail->Body = $fields['message']. '<br>'. '<br>'. 'vārds: '. $fields['name']. '<br>'. 'epasts: '. $fields['email']. '<br>'. 'mob.tel: '. $fields['phone'];
    $mail->AddReplyTo($fields['email'], $fields['name']);

    if ($mail->Send ()){
        echo json_encode(array('status'=>1, 'message'=>'Email sent succesfully'));
        die();
    }
    echo json_encode(array('status'=>0, 'message'=>'Email not sent, please try again'));
    $mail->smtpClose();
}