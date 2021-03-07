<?php 
require_once('includes/header.php'); 

if(!$user->is_logged_in()) {
    header('login.php');
}

?>

<div id="container-white">
    <div class="d-flex justify-content-center">
        <div class="wrapper">
            <div class="row no-gutters align-items-center justify-content-center">
                <div class="col">
                    <div class="list-group list-group-horizontal-xl" id="quiz-list" role="tablist">
                        <a class="list-group-item list-group-item-action active" data-toggle="list" href="#theory" role="tab">Theory</a>
                        <a class="list-group-item list-group-item-action" data-toggle="list" href="#info" role="tab">Information</a>
                        <a class="list-group-item list-group-item-action" data-toggle="list" href="#quiz" role="tab">Quizes</a>
                    </div>
                </div>
            </div>
            <div class="row no-gutters align-items-center justify-content-center">
                <div class="col">
                    <div class="tab-content">
                        <div class="tab-pane active" id="theory" role="tabpanel">Theory page</div>
                        <div class="tab-pane fade" id="info" role="tabpanel">Info page</div>
                        <div class="tab-pane fade" id="quiz" role="tabpanel">
                            <div class="container-quiz">
                            <div id="quiz-content"></div>
                            <div class="row no-gutters align-items-center justify-content-center">
                                <div id="quiz-next-btn" class="col"></div>  <!-- Next -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
  $(function () {
    $('#quiz-list a:last-child').tab('show')
  })
</script>

<script src="js/quiz.js"></script>


<?php require_once('includes/footer.php'); ?>
