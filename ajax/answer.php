<?php
require_once($_SERVER['DOCUMENT_ROOT'] .'/config.php');

if(!$user->is_logged_in()) {
    header('Location: login.php');
    exit;
}

$submitted = json_decode($_POST['answers']);

if(isset($submitted)) {
    foreach ($submitted as $ans)
        $user->submitAnswer($ans);
}

echo json_encode($submitted);
?>