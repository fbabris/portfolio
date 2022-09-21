<?php

include './autoloader.inc.php';

if(isset($_GET['api']) && $_GET['api'] == 'new_review'){
    $name = $_POST['name'];
    $email = $_POST['email'];
    $review = $_POST['review'];
    $honeypot = $_POST['review-url'];
    
    $addReview = new ReviewController($name, $review, $email, $honeypot);
    
    $addReview->sendReview();   
}

$getAllReviews = new RenderReviews;
$getAllReviews->getApprovedReviews();

