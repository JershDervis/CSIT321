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

            if(isset($question['question_img'])) {
                try {
                    $stmt = $db->prepare('SELECT f.loc_name FROM files f WHERE f.id= :imageID ;');
                    $stmt->execute(array(
                        'imageID'  =>  $question['question_img']
                    ));
                    $fileLocation = $stmt->fetch(PDO::FETCH_ASSOC)['loc_name'];
                } catch(PDOException $e) {
                    echo $e->getMessage();
                }
            }

            //Check if should be radio or checkbox question:
            //SELECT * FROM quiz_answer qa WHERE qa.is_correct=1 AND qa.question_id = 1;
            try {
                $stmt = $db->prepare('SELECT COUNT(*) "total" FROM quiz_answer qa WHERE qa.is_correct=1 AND qa.question_id = :questionID ;');
                $stmt->execute(array(
                    'questionID'  =>  $question['qid']
                ));
                $isCheckbox = intval($stmt->fetch(PDO::FETCH_ASSOC)['total']) > 1 ? true : false;
            } catch(PDOException $e) {
                echo $e->getMessage();
            }

            $choices = array();
            $idChoices = array();

            foreach($answers as $option) {
                array_push($choices, $option['choice']);
                array_push($idChoices, $option['id']);
            }
            $nextQuestion = $question['question'];

            echo '  <div class="row no-gutters align-items-center justify-content-center mb-3">
            <div id="db-quiz" class="col">Quiz</div>
            <div class="col">
            </div>
            <div id="quiz-position" class="col text-right">
                Question: ' . strval((intval($amntAnswered) + 1)) . '/' . $quizSize . '
            </div>
            </div>

            <div class="row no-gutters align-items-center justify-content-center mb-3">
            <div id="quiz-question" class="col"><b>' . $nextQuestion . '</b></div> <!-- Question -->
            </div>
            <div class="row no-gutters align-items-center justify-content-center mb-3">';
            if(isset($fileLocation)) {
                echo '<img width="200px" height="200px" src="uploads/' . $fileLocation . '"></img>';
            }
            echo '</div>
            <div class="row no-gutters align-items-center justify-content-center">
            <div id="quiz-answer" class="col">';

            for($i = 0; $i < sizeof($choices); ++$i) {
                if($isCheckbox) {
                    echo '<div class="form-check">
                    <input class="form-check-input" type="checkbox" name="selectableAnswer" id="gridSelectable' . $idChoices[$i] . '" value="' . $idChoices[$i] . '">
                    <label class="form-check-label" for="gridSelectable' . $idChoices[$i] . '">';
                    echo $choices[$i];
                    echo '</label></div>';
                } else {
                    echo '<div class="form-check">
                            <input class="form-check-input" type="radio" name="selectableAnswer" id="gridSelectable' . $idChoices[$i] . '" value="' . $idChoices[$i] . '">
                            <label class="form-check-label" for="gridSelectable' . $idChoices[$i] . '">';
                    echo $choices[$i];
                    echo '</label></div>';
                }
            }

            echo '</div></div>
            <div id="quiz-nav" class="row no-gutters mt-3">
                <div class="col text-left"><button id="quiz-back" type="button" class="btn btn-primary">Exit</button></div>
                <div class="col text-right"><button id="quiz-next" type="button" class="btn btn-primary" data-quiz-id="' . $quizID . '">Next</button></div>
            </div>
            ';
        }
    } else {
        echo 'Invalid quiz selected. Quiz does not exist in database.';
    }
}


?>