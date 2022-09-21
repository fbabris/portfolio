<?php

class ReviewController extends Review {
    private $name;
    private $review;
    private $email;
    private $honeypot;
    
    public function __construct($name, $review, $email, $honeypot) {
        $this->name = $name;
        $this->email = $email;
        $this->review = $review;
        $this->honeypot = $honeypot;
    }  

    public function sendReview() {
        
                
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

        if ($this->repeatUser() == true){
            $this->saveReview($this->review, $this->repeatUser())->output();
            header_remove('location');
        }

        $this->saveUser($this->name, $this->email);
        $this->saveReview($this->review, $this->repeatUser());
    }
        

    private function emptyInput(){
        $result;
        if(empty($this->name) || empty($this->email) || empty($this->review)) {
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