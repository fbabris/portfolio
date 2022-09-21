<?php

class Review extends Dbh {

    protected function saveUser($name, $email){

        $connection=$this->connect();
        $stmt = $connection->prepare("INSERT INTO users (`user_name`, `user_email`) VALUES (?, ?);");

        if(!$stmt->execute([$name, $email])){
            $stmt = null;
            exit();
        }

        $userid=$connection->lastInsertId();
        $stmt = null;        
        $connection = null;
    }

    protected function saveReview($review, $userid){

        $connection=$this->connect();
        $stmt = $connection->prepare("INSERT INTO reviews (review_text, review_date, review_status, user_id) VALUES (?, NOW(), FALSE, $userid);"); 
        if(!$stmt->execute([$review])){
            $stmt = null;
            exit();
        }
        
        $this->readyToOutput=array('status'=>1, 'srvmessage'=>'Atsauksme iesniegta un tiks izskatīta tuvākajā laikā');
        return $this;

    }

    protected function checkUser($name, $email){
        $stmt = $this->connect()->prepare("SELECT * FROM users WHERE `user_name` = ? AND `user_email` = ?;");
        if(!$stmt->execute([$name, $email])){
            $stmt = null;
            exit();
        }

        if($stmt->rowCount() > 0) {
            $row = $stmt->fetch();
            return $row['user_id'];
        }
        else{
            return false; 
        }
    }

    protected function output() {
        print_r(json_encode($this->readyToOutput));
        die();
    }
}