<?php 
require_once('includes/header.php'); 

if(!$user->is_logged_in()) {
    header('Location: login.php');
    exit;
}

if(!isset($_GET['name'])) {
    header('Location: lessons.php?action=invalid'); //TODO: handle invalid quiz name in lessons.php
    exit;
}

$unit = htmlspecialchars($_GET['name']);
$unitID = $user->getUnitID($unit);

if(!$user->unitExists($unit)) {
    header('Location: lessons.php?action=notexist');
    exit;
}

try {
    $stmt = $db->prepare('SELECT t.title, t.link FROM theory t WHERE t.unit_id= :unitID ;');
    $stmt->execute(array(
        'unitID'  =>  $unitID
    ));
    $theoryLinks = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    echo $e->getMessage();
}

?>
<div id="container-white">
    <div class="d-flex justify-content-center">
        <div class="wrapper">
            <div class="row no-gutters align-items-center justify-content-center">
                <div class="col">
                    <h1><?php echo ucfirst($unit); ?></h1>
                </div>
            </div>
            <div class="row no-gutters align-items-center justify-content-center">
                <div class="col">
                    <div class="list-group list-group-horizontal-xl" id="quiz-list" role="tablist">
                        <a class="list-group-item list-group-item-action active" data-toggle="list" href="#theory" role="tab">Theory</a>
                        <a class="list-group-item list-group-item-action" data-toggle="list" href="#info" role="tab">Information</a>
                        <a class="list-group-item list-group-item-action" data-toggle="list" href="#quiz" role="tab">Quizzes</a>
                    </div>
                </div>
            </div>
            <div class="row no-gutters align-items-center justify-content-center">
                <div class="col">
                    <div class="tab-content">
                        <div class="tab-pane active" id="theory" role="tabpanel">
                            <div class="container-theory border rounded">
                                Theory
                                <?php
                                if(isset($theoryLinks)) {
                                    foreach($theoryLinks as $link) {
                                        echo '<p><a href="' . $link['link'] . '" target="_blank">' . $link['title'] . '</a></p>';
                                    }
                                }
                                ?>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="info" role="tabpanel">
                            <div class="container-info border rounded">
                                Eligibility Criteria
                            </div>
                        </div>
                        <div class="tab-pane fade" id="quiz" role="tabpanel">
                            <div id="container-quiz" class="container-quiz border rounded">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$j(document).ready(function () {
    $j('#quiz-list a:last-child').tab('show');

    var unitID = <?php echo $unitID; ?>;

    //Display list
    displayQuizList(unitID);

    $j(document).on("click", "#quiz-back", function(){
        displayQuizList(unitID);
    });

    $j(document).on("click", "#quiz-next", function() {
        var qid = $j(this).data('quiz-id');
        var answerIDS = [];
        $j('input[name=selectableAnswer]:checked').each(function() {
            answerIDS.push(this.value);
        });
        if(answerIDS != null) {
            $j.ajax({
                type: "POST",
                url: "/ajax/answer.php",
                dataType: 'text',
                data: {
                    answers: JSON.stringify(answerIDS)
                },
                beforeSend: function(){
                    $j('#quiz-nav').html('<div class="spinner-border" role="status"><span class="sr-only">Loading...</span></div>');
                },
                success: function(result) {
                    $j('#quiz-nav').html('<button id="quiz-next" type="button" class="btn btn-primary" data-quiz-id="' + qid + '">Next</button>');
                    nextQuestion(qid);
                },
                error: function(result) {
                    alert('Invalid Response');
                }
            });
        } else {
            alert('Please select an answer before continuing');
        }
    });
});

//Prints a response from PHP
function nextQuestion(quizID) {
    if (quizID == "") {
        document.getElementById("quiz-content").innerHTML = "";
        return;
    } else {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("container-quiz").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET","ajax/quiz.php?id="+quizID,true);
        xmlhttp.send();
    }
}

function displayQuizList(unitID) {
    if (unitID == "") {
        document.getElementById("quiz-content").innerHTML = "";
        return;
    } else {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("container-quiz").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET","ajax/quiz-list.php?id="+unitID,true);
        xmlhttp.send();
    }
}
</script>

<?php 
require_once('includes/footer.php'); 
?>
