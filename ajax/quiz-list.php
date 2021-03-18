<?php
require_once($_SERVER['DOCUMENT_ROOT'] .'/config.php');

if(!$user->is_logged_in()) {
    header('Location: login.php');
    exit;
}
if(isset($_GET['id'])) {
    $unitID = htmlspecialchars($_GET['id']);

    echo '<div class="list-group">';
    $quizes = $user->getUnitQuizes($unitID);
    $score = intval($user->getUserQuizScore($unitID));

    foreach($quizes as $quiz) {
        $isComplete = $user->isQuizComplete($quiz['id']);
    
        echo '<a href="#' . $quiz['id'] . '" onclick="nextQuestion(' . $quiz['id'] . ');" class="list-group-item list-group-item-action' . ($isComplete ? ' disabled' : '') . '">' . $quiz['name'];
        if($isComplete) { //Display score
            echo '
            <div class="progress">
                <div class="progress-bar' . ($score >= 50 ? ' bg-success' : ' bg-danger') . '" role="progressbar" style="width: ' . $score . '%;" aria-valuenow="' . $score . '" aria-valuemin="0" aria-valuemax="100">' . $score . '%</div>
            </div>';
        }
        echo '</a>';
    }
    echo '</div>';
} else {
    die;
}
?>