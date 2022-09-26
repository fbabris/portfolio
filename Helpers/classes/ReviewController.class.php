<?php

class ReviewController extends Review {
    private $name;
    private $review;
    private $email;
    private $honeypot;
    
    public function __construct($name, $review, $email, $honeypot, $picture) {
        $this->name = $name;
        $this->email = $email;
        $this->review = $review;
        $this->honeypot = $honeypot;
        $this->picture = $picture;
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

        $picheck = $this->checkPicture();
        if (!is_string($picheck)){
            $picheck->output();
        }

        if($picheck === ''){
            $filepath = 'default.jpeg';
        }
        else {
            $filepath = $this->resizePicture($picheck, 256, true);
            $filepath = $this->resizePicture($picheck, 64);
        }

        if ($this->repeatUser() == true){
            $this->saveReview($this->review, $this->repeatUser(), $filepath)->output();
            header_remove('location');
        }

        $this->saveUser($this->name, $this->email);
        $this->saveReview($this->review, $this->repeatUser(), $filepath);
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

    private function checkPicture(){
        $fileDestination = '';
        if($this->picture){
            $fileName = $this->picture['name'];
            $fileTmpName = $this->picture['tmp_name'];
            $fileSize = $this->picture['size'];
            $fileError = $this->picture['error'];
            $fileType = $this->picture['type'];
            $allowed = array('image/jpeg', 'image/png');
            if (!in_array( $fileType, $allowed)){
                $this->readyToOutput=array('status'=>0, 'srvmessage'=>'Nav atļauta šādu failu tipu augšupielāde!');
                return $this;
            };

            if($fileSize>5000000){
                $this->readyToOutput=array('status'=>0, 'srvmessage'=>'maksimālais faila izmērs - 5MB!');
                return $this;
            };

            if($fileError != 0){
                $this->readyToOutput=array('status'=>0, 'srvmessage'=>'radās kļūda augšupielādes laikā, lūdzu mēģiniet vēlreiz!');
                return $this;
            };
            $type = explode('/', $fileType);
            $fileExt = end($type);
            $fileNameNew = uniqid('', true).".".$fileExt;
            $fileDestination = '../../img/profilepics/'.$fileNameNew;
            move_uploaded_file($fileTmpName, $fileDestination);
        };
        return $fileDestination;
    }

    private function resizePicture($filepath, $res, $big = false) {
        
        $profpic_width = $res;
        $profpic_height = $res;
    
        if (mime_content_type($filepath) == 'image/jpeg'){
            $image = imagecreatefromjpeg($filepath);
        }
        else{
            $image = imagecreatefrompng($filepath);
        }
        $width = imagesx($image);
        $height = imagesy($image);

        $original_aspect = $width / $height;
        $profpic_aspect = $profpic_width / $profpic_height;

        if ( $original_aspect >= $profpic_aspect )
        {
        // If image is wider than thumbnail (in aspect ratio sense)
        $new_height = $profpic_height;
        $new_width = $width / ($height / $profpic_height);
        }
        else
        {
        // If the thumbnail is wider than the image
        $new_width = $profpic_width;
        $new_height = $height / ($width / $profpic_width);
        }

        $profpic = imagecreatetruecolor( $profpic_width, $profpic_height );

        // Resize and crop
        imagecopyresampled($profpic,
                        $image,
                        0 - ($new_width - $profpic_width) / 2, // Center the image horizontally
                        0 - ($new_height - $profpic_height) / 2, // Center the image vertically
                        0, 0,
                        $new_width, $new_height,
                        $width, $height);
        if ($big){
            $shortpath = explode('/', $filepath);
            $filename = end($shortpath);
            $filepath = '../../img/profilepics/big/'.$filename;
        }
        imagejpeg($profpic, $filepath, 80);

        $filepath = explode('/', $filepath);
        $filepath = end($filepath);

        return $filepath;
    }
}