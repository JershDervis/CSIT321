<?php
header('Content-Type: application/json');

require_once($_SERVER['DOCUMENT_ROOT'] .'/config.php');

if(!$user->isAdmin()) { // Check Admin
    header('Location: login.php');
    exit;
}
if(!isset($_POST['qid']) && empty($_POST['qid'])) { //Check Unit Name is set
    echo 'Invalid quiz.';
    exit;
}

$quizID = $_POST['qid'];

//Update in the database
try {
    //Delete
    $stmt = $db->prepare('DELETE FROM quiz WHERE id= :qid ;');
    $stmt->execute(array(
        'qid'  =>  $quizID
    ));
} catch(PDOException $e) {
    echo $e->getMessage();
}

echo json_encode(array(
    'qid'    =>  $quizID
));

?>