<?php

require '../includes/Exception.inc.php';
require '../includes/SMTP.inc.php';
require '../includes/PHPMailer.inc.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class SendMail extends PHPMailer{

    private $name;
    private $message;
    private $phone;
    private $email;

    public function __construct($name, $message, $phone, $email) {
        $this->name = $name;
        $this->email = $email;
        $this->phone = $phone;
        $this->message = $message;
    }
    public $readyToOutput;
    public function send() {
        $credentials = json_decode(file_get_contents('../includes/credentials.json'), true);
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
        $mail->From=$this->email;
        $mail->FromName = $this->name;
        $mail->Body = $this->message. '<br>'. '<br>'. 'vārds: '. $this->name. '<br>'. 'epasts: '. $this->email. '<br>'. 'mob.tel: '. $this->phone;
        $mail->AddReplyTo($this->email, $this->name);
        
        if ($mail->Send()){
            $this->readyToOutput=array('status'=>1, 'srvmessage'=>'Ziņa nosūtīta. Sazināšos ar jums tuvākajā laikā!');
            return $this->readyToOutput;
            die();
        }
        $this->readyToOutput=array('status'=>0, 'srvmessage'=>'Radusies kļūda, lūdzu, mēģiniet vēlreiz!');
        $mail->smtpClose();
        return $this->readyToOutput;
        }        
    }