<?php
header('Content-Type: application/json');

require_once($_SERVER['DOCUMENT_ROOT'] .'/config.php');

if(!$user->isAdmin()) { // Check Admin
    header('Location: login.php');
    exit;
}

$required = ['quizID', 'question', 'answers', 'correct'];

foreach($required as $ex) {
    if((!isset($_POST[$ex]) && empty($_POST[$ex]))) {
        echo json_encode('Didn\'t received expected input');
        exit;
    }
}

if((isset($_POST['fileID']) && !empty($_POST['fileID']))) {
    $fileID = $_POST['fileID']; //This can be null
}

$quizID = $_POST['quizID'];
$question = $_POST['question'];
$answers = $_POST['answers'];
$correctness = $_POST['correct'];

//Update in the database
try {
    if(isset($fileID)) {
        $stmt = $db->prepare('INSERT INTO quiz_question (quiz_id, question, question_img) VALUES ( :quizID , :question , :fileID );');
        $stmt->execute(array(
            'quizID'    =>  $quizID,
            'question'  =>  $question,
            'fileID'    =>  $fileID
        ));
    } else {
        $stmt = $db->prepare('INSERT INTO quiz_question (quiz_id, question) VALUES ( :quizID , :question );');
        $stmt->execute(array(
            'quizID'    =>  $quizID,
            'question'  =>  $question
        ));
    }
    $questionID = $db->lastInsertId();

    for($i=0; $i<count($answers); $i++) {
        $stmt = $db->prepare('INSERT INTO quiz_answer (question_id, choice, is_correct) VALUES ( :questionID , :choice , :correct );');
        $stmt->execute(array(
            'questionID'    =>  $questionID,
            'choice'        =>  $answers[$i],
            'correct'       =>  $correctness[$i]
        ));
    }
} catch(PDOException $e) {
    echo $e->getMessage();
}

$output = array(
    'id'        =>  $questionID,
    'quizID'    =>  $quizID,
    'question'  =>  $question
);

if(isset($fileID)) {
    $output['fileID'] = $fileID;
}

echo json_encode($output);

?>