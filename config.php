<?php
//server info
$servername ="SERVERNAME";
$username = "USERNAME";
$password = "PASSWORD";
$dbname = "DB_NAME";

//change based on server time zone
$timeChange = -7;

// used for room data connections
$conn = new mysqli($servername, $username, $password, $dbname);

// used for sql account connections
$link = mysqli_connect($servername, $username, $password, $dbname);

//email info
$awardspaceEmail = "EMAIL"; 
$recipientEmail  = "PHONE_NUMBER";
$from = "From: Mail Contact Form <" . $awardspaceEmail . ">";
$to = $recipientEmail;
$subject = "Room Update";

//sends text notifying dentist
$text = function ($body) use ($to, $subject, $from) {
    global $messageStatus;
    if (mail($to, $subject, $body, $from)) {
        $messageStatus = 'Dentist notified!';
    } else {
        $messageStatus = 'ERROR: Dentist not notified!';
    }
};
