<?php

include './autoloader.inc.php';

$name = $_POST['contact_name'];
$email = $_POST['contact_email'];
$phone = $_POST['contact_phone'];
$message = $_POST['contact_message'];
$honeypot = $_POST['url'];

$sendMail = new EmailController($name, $message, $phone, $email, $honeypot);

$sendMail->sendEmail();