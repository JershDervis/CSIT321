<?php
require_once($_SERVER['DOCUMENT_ROOT'] .'/config.php');

if($user->is_logged_in()) {
    $user->logout();
}
?>