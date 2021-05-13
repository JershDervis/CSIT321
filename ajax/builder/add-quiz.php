<?php
header('Content-Type: application/json');

require_once($_SERVER['DOCUMENT_ROOT'] .'/config.php');

if(!$user->isAdmin()) { // Check Admin
    header('Location: login.php');
    exit;
}
if((!isset($_POST['name']) && empty($_POST['name'])) && (!isset($_POST['uid']) && empty($_POST['uid']))) { //Check Unit Name is set
    echo 'Invalid input.';
    exit;
}

$quizName = $_POST['name'];
$unitID = $_POST['uid'];
$quizID = -1;

//Update in the database
try {
    $stmt = $db->prepare('INSERT INTO quiz (unit_id, name) VALUES ( :unitID , :quizName );');
    $stmt->execute(array(
        'unitID'    =>  $unitID,
        'quizName'  =>  $quizName
    ));
    $quizID = $db->lastInsertId();
} catch(PDOException $e) {
    echo $e->getMessage();
}

echo json_encode(array(
    'quizName'  =>  $quizName,
    'unitID'    =>  $unitID,
    'quizID'    =>  $quizID
));

?>