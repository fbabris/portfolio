<?php

class EmailController extends SaveEmail {
    private $name;
    private $message;
    private $phone;
    private $email;
    private $honeypot;
    
    public function __construct($name, $message, $phone, $email, $honeypot) {
        $this->name = $name;
        $this->email = $email;
        $this->phone = $phone;
        $this->message = $message;
        $this->honeypot = $honeypot;
    }

    public function sendEmail() {
        
        $readyToOutput;
        if ($this->honeyPot() == false){
            $this->readyToOutput=array('status'=>0, 'srvmessage'=>'Servera kļūda, mēģiniet vēlreiz vēlāk!');
            $this->output();
        }

        if ($this->emptyInput() == false){
            $this->readyToOutput=array('status'=>0, 'srvmessage'=>'Lūdzu, aizpildiet visus laukus!');
            $this->output();
        }

        if ($this->invalidEmail() == false){
            $this->readyToOutput=array('status'=>0, 'srvmessage'=>'Norādīta nepareiza epasta adrese!');
            $this->output();
        }
        if ($this->invalidPhone() == false){
            $this->readyToOutput=array('status'=>0, 'srvmessage'=>'Lūdzu, norādiet pareizu tālruņa nummuru!');
            $this->output();
        }

        $sent = new SendMail($this->name, $this->message, $this->phone, $this->email);

        $sent->send();
        
        if ($this->repeatUser() == true){
            $this->saveMail($this->message, $this->repeatUser())->output();
            header_remove('location');
        }

        $this->saveUser($this->phone, $this->name, $this->email);
        $this->saveMail($this->message, $this->repeatUser())->output();
    }
    

    

    private function emptyInput(){
        $result;
        if(empty($this->name) || empty($this->email) || empty($this->phone) || empty($this->message)) {
            $result = false;
        }
        else{
            $result = true;
        }
        return $result;
    }
    
    private function invalidEmail(){
        $result;
        if(!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            $result = false;
        }
        else{
            $result = true;
        }
        return $result;  
    }

    private function invalidPhone(){
        $result;
        if(!preg_match("/^[0-9+\- ]*$/", $this->phone)) {
            $result = false;
        }
        else{
            $result = true;
        }
        return $result;
    }

    private function honeyPot(){
        $result;
        if(!empty($this->honeypot)) {
            $result = false;
        }
        else{
            $result = true;
        }
        return $result;
    }

    private function repeatUser(){
        if(!$this->checkUser($this->name, $this->email)) {
            return false;
        }
        else{
            return $this->checkUser($this->name, $this->email);
        }
    }

}