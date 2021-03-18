<?php
require_once($_SERVER['DOCUMENT_ROOT'] .'/config.php');

if(!$user->is_logged_in()) {
    header('Location: login.php');
    exit;
}

if(isset($_GET['id'])) {
    $quizID = htmlspecialchars($_GET['id']);
    if($user->quizExists($quizID)) {
        $quizSize = $user->getQuizSize($quizID);
        $amntAnswered = $user->getAnsweredAmnt($quizID);

        //Check if quiz complete..
        if(intval($amntAnswered) >= intval($quizSize)) {
            echo 'You scored: ' . (intval($user->getAmntCorrect($quizID)) / intval($quizSize) * 100) . '%';
            echo '<div class="col text-left"><button id="quiz-back" type="button" class="btn btn-primary">Exit</button></div>';
        } else { //If not complete display next quesiton..
            $question = $user->getNextQuestion($quizID);
            $answers = $user->getQuestionOptions($question['qid']);
            $choices = array();
            $idChoices = array();

            foreach($answers as $option) {
                array_push($choices, $option['choice']);
                array_push($idChoices, $option['id']);
            }
            $nextQuestion = $question['question'];
                    
            echo '  <div class="row no-gutters align-items-center justify-content-center">
                    <div id="db-quiz" class="col">Quiz-' . $quizID . '</div>
                    <div class="col">
                    </div>
                    <div id="quiz-position" class="col text-right">
                        Question: ' . strval((intval($amntAnswered) + 1)) . '/' . $quizSize . '
                    </div>
                    </div>

                    <div class="row no-gutters align-items-center justify-content-center">
                    <div id="quiz-question" class="col">' . $nextQuestion . '</div> <!-- Question -->
                    </div>
                    <div class="row no-gutters align-items-center justify-content-center">
                    <div id="quiz-answer" class="col">';
        
            for($i = 0; $i < sizeof($choices); ++$i) {
                echo '<div class="form-check">
                        <input class="form-check-input" type="radio" name="gridRadios" id="gridRadios' . $idChoices[$i] . '" value="' . $idChoices[$i] . '">
                        <label class="form-check-label" for="gridRadios' . $idChoices[$i] . '">';
                echo $choices[$i];
                echo '</label></div>';
            }
            echo '</div></div>

            <div id="quiz-nav" class="row no-gutters">
                <div class="col text-left"><button id="quiz-back" type="button" class="btn btn-primary">Exit</button></div>
                <div class="col text-right"><button id="quiz-next" type="button" class="btn btn-primary">Next</button></div>
            </div>
            ';
        }
    } else {
        echo 'Invalid quiz selected. Quiz does not exist in database.';
    }
}


?>