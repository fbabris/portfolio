<?php
namespace Helpers;

require 'phpmailer/includes/Exception.php';
require 'phpmailer/includes/SMTP.php';
require 'phpmailer/includes/PHPMailer.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class ApiHelper
{
    private $ready_to_output = '';

    private $db_user = "root";
    private $db_password = "";
    private $db_name = "portfolio";
    private $db_host = "localhost";

    public function send() {
        $credentials = json_decode(file_get_contents('./Helpers/credentials.json'), true);

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
                $this->ready_to_output=array('status->0', 'srvmessage' -> $message);
                return $this;
            }
            $fields[$field] = htmlspecialchars($data);
        }
        
        if (!empty($_POST)){
            if (!empty($_POST['url'])){
                $this->ready_to_output=array('status'=> 0, 'srvmessage'=>'There was a problem');
                return $this;
                die(); 
            }
            
            $fields['email'] = filter_var($fields['email'], FILTER_VALIDATE_EMAIL);
            if(!$fields['email']){
                $this->ready_to_output=array('status'=>0, 'srvmessage'=>'Email adress is not valid, please try again');
                return $this;
                die();
            }
            $mail->From=$fields['email'];
            $mail->FromName = $fields['name'];
            $mail->Body = $fields['message']. '<br>'. '<br>'. 'vārds: '. $fields['name']. '<br>'. 'epasts: '. $fields['email']. '<br>'. 'mob.tel: '. $fields['phone'];
            $mail->AddReplyTo($fields['email'], $fields['name']);
        
            if ($mail->Send ()){
                $this->ready_to_output=array('status'=>1, 'srvmessage'=>'Email sent succesfully');
                $this->ready_to_output=array_merge($this->ready_to_output, $fields);
                return $this;
                die();
            }
            $this->ready_to_output=array('status'=>0, 'srvmessage'=>'Email not sent, please try again');
            $mail->smtpClose();
            return $this;
        }        
    }

    public function save(){
        $mysqli = new \mysqli($this->db_host, $this->db_user, $this->db_password, $this->db_name);
        if ($mysqli->connect_errno) {
            printf('Connect failed: %s\n', $mysqli->connect_error);
        exit();
        }
        $query1 = "INSERT INTO emails (email_text, email_timestamp) VALUES ('".$this->ready_to_output['message']. "', NOW())";
        $query2 = "INSERT INTO users (user_name, user_email, user_phone) VALUES ('".$this->ready_to_output['name']."', '". $this->ready_to_output['email']."', '".$this->ready_to_output['phone']."')";
        $mysqli->query($query1);
        $mysqli->query($query2);
        $this->ready_to_output='';
    }

    public function output() {
        print_r (json_encode($this->ready_to_output));
        return $this;
    }
}