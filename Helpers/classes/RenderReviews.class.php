<?php

class RenderReviews extends Dbh {

    public function getApprovedReviews(){
        $reviews = [];
        $connection = $this->connect();
        $stmt = $connection->query("SELECT u.user_name, r.review_text, r.review_date, r.review_picture FROM users u JOIN reviews r ON u.user_id = r.user_id WHERE r.review_status = TRUE;")->fetchAll(PDO::FETCH_ASSOC);
        
        foreach ($stmt as $row){
            array_push($reviews, $row);
        }

        if(!$stmt){
            $stmt = null;
            exit();
        }

        print_r(json_encode($reviews, JSON_FORCE_OBJECT));

        die();
    }
}


