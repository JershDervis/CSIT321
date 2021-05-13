<?php 
require_once($_SERVER['DOCUMENT_ROOT'] .'/config.php');

if(!$user->isAdmin()) { // Check Admin
    header('Location: login.php');
    exit;
}
if(!isset($_GET['id']) && empty($_GET['id'])) { //Check Unit ID is set
    echo 'Invalid quiz.';
    exit;
}

$quizID = $_GET['id'];

$questions = null;
try {
    $stmt = $db->prepare('SELECT * FROM quiz_question qq WHERE qq.quiz_id= :quizID ;');
    $stmt->execute(array(
        'quizID'  =>  $quizID
    ));
    $questions = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    echo $e->getMessage();
}

?>

<h7>Questions</h7>
<div id="quiz-question-list-<?php echo $quizID ?>" class="list-group">
    <?php foreach($questions as $q) { ?>
        <div id="qq-question-<?php echo $q['id']; ?>">
            <div class="row">
                <div class="col-lg">
                    <button disabled type="button" class="quiz-question list-group-item list-group-item-action" data-toggle="modal" data-target="#editQuizDialog" data-qid="<?php echo $q['id'] ?>">
                        <?php echo $q['question'] ?>
                    </button>
                </div>
                <div class="col-md-auto align-self-center">
                    <button type="button" class="btn-remove-question btn btn-outline-danger float-right" data-qid="<?php echo $q['id'] ?>">
                        Remove
                    </button>
                </div>
            </div>
        </div>
    <?php } ?>
</div>

<div class="row my-3">
    <div class="col">
        <button type="button" id="addQuestionModal" class="btn btn-secondary btn-block" data-toggle="modal" data-target="#addQuestionDialog" data-qid="<?php echo $quizID; ?>">
            Add Question
        </button>
    </div>
</div>