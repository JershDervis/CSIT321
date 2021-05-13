<?php
header("Content-Type: application/json", true);

/**
 *  Change a unit's publically available state. 
 */

require_once($_SERVER['DOCUMENT_ROOT'] .'/config.php');

if(!$user->isAdmin()) { // Check Admin
    header('Location: login.php');
    exit;
}
if(!isset($_POST['qid']) && empty($_POST['qid'])) { //Check Unit ID is set
    echo 'Invalid unit.';
    exit;
}

$quizID = $_POST['qid'];
$state = $_POST['newState']; //True, 1 = make public

//Update in the database
try {
    $stmt = $db->prepare('UPDATE quiz SET published = :newState WHERE id = :quizID');
    $stmt->execute(array(
        'newState'  =>  $state,
        'quizID'    =>  $quizID
    ));
} catch(PDOException $e) {
    echo $e->getMessage();
}
?>