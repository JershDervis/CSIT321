<?php
require_once('config.php');

if(isset($_GET['name'])) {
    $quizName = htmlspecialchars($_GET['name']);
    $quizSize = $user->getQuizSize($quizName);
    $question = $user->getNextQuestion($quizName);

    $nextQuestion = $question['question'];
    $correctAnswer = $question['correct_answer'];
    $choices = explode(',', $question['choices'] );
    $idChoices = explode(',', $question['id_choices'] );


    echo '  <form id="quiz-form">
            <div class="col">RTA - QUIZ</div>
            <div class="col">

            </div>
            <div id="quiz-position" class="col">
                Question: ../' . $quizSize . '
            </div>
            </div>
            <div class="row no-gutters align-items-center justify-content-center">
            <div id="quiz-question" class="col">' . $nextQuestion . '</div> <!-- Question -->
            </div>
            <div class="row no-gutters align-items-center justify-content-center">
            <div id="quiz-answer" class="col">
';

for($i = 0; $i < count($choices); ++$i) {
    echo '<div class="form-check">
            <input class="form-check-input" type="radio" name="gridRadios" id="gridRadios' . $idChoices[$i] . '" value="' . $idChoices[$i] . '">
            <label class="form-check-label" for="gridRadios' . $idChoices[$i] . '">';
    echo $choices[$i];
    echo '</label></div>';
}


echo '</div></div>
</form>
';
}


?>