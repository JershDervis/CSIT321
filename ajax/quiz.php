<?php
require_once($_SERVER['DOCUMENT_ROOT'] .'/config.php');

if(!$user->is_logged_in()) {
    header('Location: login.php');
    exit;
}

if(isset($_GET['name'])) {
    $quizName = htmlspecialchars($_GET['name']);
    if($user->quizExists($quizName)) {
        $quizSize = $user->getQuizSize($quizName);
        $amntAnswered = $user->getAnsweredAmnt($quizName);

        if(intval($amntAnswered) >= intval($quizSize)) {
            //Quiz complete
            echo 'QUIZ IS COMPLETE!';
            //GET SCORE
        } else {
            $question = $user->getNextQuestion($quizName);
        
            $nextQuestion = $question['question'];
            $correctAnswer = $question['correct_answer'];
            $choices = explode(',', $question['choices'] ); //TODO: FIX: answers must not contain comma currently
            $idChoices = explode(',', $question['id_choices'] );
        
            echo '  <div class="row no-gutters align-items-center justify-content-center">
                    <div class="col">RTA - QUIZ</div>
                    <div class="col">
                        <div id="ajaxLoading"></div>
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
        
            for($i = 0; $i < count($choices); ++$i) {
                echo '<div class="form-check">
                        <input class="form-check-input" type="radio" name="gridRadios" id="gridRadios' . $idChoices[$i] . '" value="' . $idChoices[$i] . '">
                        <label class="form-check-label" for="gridRadios' . $idChoices[$i] . '">';
                echo $choices[$i];
                echo '</label></div>';
            }
            echo '</div></div>';
        }
    } else {
        echo 'Invalid quiz selected. Quiz does not exist in database.';
    }
}


?>