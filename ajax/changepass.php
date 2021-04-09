<?php
require_once($_SERVER['DOCUMENT_ROOT'] .'/config.php');

if((isset($_POST['pass']) && !empty($_POST['pass'])) 
    && (isset($_POST['passConfirm']) && !empty($_POST['passConfirm']))
    && (isset($_POST['token']) && !empty($_POST['token']))) {
    $pass = $_POST['pass'];
    $passConfirm = $_POST['passConfirm'];
    $token = $_POST['token'];

    if($pass != $passConfirm) {
        sendResponse(false, 'Passwords do not match.');
    } elseif(strlen($pass) < 8) {
        sendResponse(false, 'Password must be 8 or more characters long.');
    }

    $hashed_password = password_hash($pass, PASSWORD_BCRYPT);
    try {
        $stmt = $db->prepare("UPDATE " . DB_DATABASE . ".users SET password = :hashed_password, resetComplete = 'Yes'  WHERE resetToken = :token");
        $stmt->execute(array(
            ':hashed_password' => $hashed_password,
            ':token' => $token
        ));
        sendResponse(true, 'Your password has been reset, please proceed to the login page to continue.');
        exit;
    } catch(PDOException $e) {
        sendResponse(false, $e->getMessage());
    }

} else {
    sendResponse(false, 'Please fill in all fields');
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