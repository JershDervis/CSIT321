<?php
require_once($_SERVER['DOCUMENT_ROOT'] .'/config.php');

if(!$user->is_logged_in()) {
    header('Location: login.php');
    exit;
}

if(isset($_GET['name'])) {
    $quizName = htmlspecialchars($_GET['name']);

    $question = $user->getNextQuestion($quizName);
    $answers = $user->getQuestionOptions($question['qid']);
    $choices = array();
    $idChoices = array();

    foreach($answers as $option) {
        array_push($choices, $option['choice']);
        array_push($idChoices, $option['id']);
    }
    $nextQuestion = $question['question'];

    $response[] = array(
        'size'          =>  $user->getQuizSize($quizName),
        'answered'      =>  $user->getAnsweredAmnt($quizName),
        'question'      =>  $nextQuestion,
        'choices'       =>  $choices,
        'id_choices'    =>  $idChoices
    );

    //Respond
    echo json_encode($response);
    die;
}

?>