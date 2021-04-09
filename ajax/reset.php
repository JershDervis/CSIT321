<?php
require_once($_SERVER['DOCUMENT_ROOT'] .'/config.php');

if(isset($_POST['email']) && !empty($_POST['email'])) {
    $email = $_POST['email'];
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        sendResponse(false, 'Please enter a valid email address.');
    }

    //Check if email is regsitered.
    $stmt = $db->prepare('SELECT email FROM ' . DB_DATABASE . '.users WHERE email = :email');
    $stmt->execute(array(':email' => $email));
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if(!empty($row['email'])) {
        //Found email in database, create a reset token
        $token = md5(uniqid(rand(),true));
        try {
            $stmt = $db->prepare("UPDATE " . DB_DATABASE . ".users SET resetToken = :token, resetComplete='No' WHERE email = :email");
            $stmt->execute(array(
                ':email' => $row['email'],
                ':token' => $token
            ));

            //Send email
            $subject = SITE_NAME . " - Password Reset Request";
            $body = "<p>Someone requested that the password be reset.</p>
            <p>If this was a mistake, just ignore this email and nothing will happen.</p>
            <p>To reset your password, visit the following address: <a href='".SITE_URL."/reset.php?key=$token'>".SITE_URL."/reset.php?key=$token</a></p>";
            $headers  = 'MIME-Version: 1.0' . "\r\n";
            $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
            $headers .= 'From: '.SITE_AUTO_EMAIL."\r\n".
                'Reply-To: '.SITE_AUTO_EMAIL."\r\n" .
                'X-Mailer: PHP/' . phpversion();

            if(mail(
                $email, 
                $subject,
                $body,
                $headers
            )) {
                //Success
                sendResponse(true, "An email has been sent to you with instructions on how to reset your password.");
            } else {
                sendResponse(false, "Failed to email $email");
            }
        } catch(PDOException $e) {
            sendResponse(false, $e->getMessage());
		}

    } else {
        sendResponse(false, 'No user is registered under this email address.');
    }
}

function sendResponse($didSucceed, $message) {
    echo json_encode(array(
        'success'   =>  $didSucceed,
        'output'    =>  $message
    ));
    if(!$didSucceed) {
        die();
    }
}
?>