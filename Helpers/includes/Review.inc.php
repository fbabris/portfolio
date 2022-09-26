<?php

include './autoloader.inc.php';

if(!empty($_GET['api']) && $_GET['api'] == 'new_review'){
    $name = $_POST['name'];
    $email = $_POST['email'];
    $review = $_POST['review_text'];
    $honeypot = $_POST['review-url'];
    if(!empty($_FILES['profile_picture'])){
        $picture = $_FILES['profile_picture'];
    }
    else{
        $picture = false;
    }
    $addReview = new ReviewController($name, $review, $email, $honeypot, $picture);
    
    $addReview->sendReview();   
}

$getAllReviews = new RenderReviews;
$getAllReviews->getApprovedReviews();

