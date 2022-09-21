<?php

class SaveEmail extends Dbh {

    protected function saveUser($phone, $name, $email){

        $connection=$this->connect();
        $stmt = $connection->prepare("INSERT INTO users (`user_name`, `user_email`) VALUES (?, ?);");

        if(!$stmt->execute([$name, $email])){
            $stmt = null;
            exit();
        }

        $userid=$connection->lastInsertId();
        $stmt = null;        
        $connection = null;

        $stmt = $this->connect()->prepare("INSERT INTO users_meta (users_phone, user_id) VALUES (?, ?);");

        if(!$stmt->execute([$phone, $userid])){
            $stmt = null;
            exit();
        }
        
        return $userid;
        
    }

    protected function saveMail($message, $userid){


        $connection=$this->connect();
        $stmt = $connection->prepare("INSERT INTO emails (email_text, email_timestamp, user_id) VALUES (?, NOW(), $userid);");

        if(!$stmt->execute([$message])){
            $stmt = null;
            exit();
        }

        $emailid=$connection->lastInsertId();

        $stmt = null;
        
        $this->readyToOutput=array('status'=>1, 'srvmessage'=>'Epasts nosūtīts. Sazināšos ar jums tuvākajā laikā!');
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