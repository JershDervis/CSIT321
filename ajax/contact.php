<?php

require_once($_SERVER['DOCUMENT_ROOT'] .'/config.php');

if(isset($_POST['name']) && isset($_POST['email']) && isset($_POST['message'])) {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $message = htmlspecialchars($_POST['message']);

    $headers  = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    $headers .= 'From: '.SITE_AUTO_EMAIL."\r\n".
        'Reply-To: '.SITE_AUTO_EMAIL."\r\n" .
        'X-Mailer: PHP/' . phpversion();
        
    if(mail(
        SITE_CONTACT_EMAIL, 
        'Web Enquiry',
        "<html><body><p><b>FROM: </b>" + $name + "</p><p><b>Email: </b>" + $email + "</p><p>" + $message + "</p></body></html>",
        $headers
    )) {
        //Success
    } else {
        //Error
    }
}

?>