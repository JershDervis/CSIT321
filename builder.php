<?php
require_once('includes/header.php');

if(!$user->isAdmin()) {             //If admin? ..
    header('Location: login.php');  //If not, get out of here
    exit;                           //If not, end of the road.
}

$units = $user->getUnits(); //Get array of existing units
?>

<!-- Modal add theory -->
<div class="modal fade" id="addTheoryDialog" tabindex="-1" role="dialog" aria-labelledby="addTheoryModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addTheoryModalLabel">Add Theory</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="add-question-modal-body" class="modal-body">
                <div class="form-group">
                    <label for="add-theory-title" class="col-form-label">Title:</label>
                    <input type="text" class="form-control" id="add-theory-title" required>

                    <label for="add-theory-link" class="col-form-label">URL:</label>
                    <input type="text" class="form-control" id="add-theory-link" required>
                </div>
                Enter the url title and link to redirect users.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <div class="btn-add-theory-outer">
                    <button id="btn-add-theory" type="submit" class="btn btn-primary">Add</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal add INFO -->
<div class="modal fade" id="addInfoDialog" tabindex="-1" role="dialog" aria-labelledby="addInfoModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addInfoModalLabel">Add Info</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="add-question-modal-body" class="modal-body">
                <div class="form-group">
                    <label for="add-info-title" class="col-form-label">Title:</label>
                    <input type="text" class="form-control" id="add-info-title" required>

                    <label for="add-info-link" class="col-form-label">Content:</label>
                    <input type="text" class="form-control" id="add-info-link" required>
                </div>
                Enter a title and some text
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <div class="btn-add-info-outer">
                    <button id="btn-add-info" type="submit" class="btn btn-primary">Add</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Remove modal dialog -->
<div class="modal fade" id="removeUnitDialog" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabel">Remove</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form> <!-- TODO: Post form via ajax -->
                    <div class="form-group">
                        <label for="remove-unit-name" class="col-form-label">Unit Name:</label>
                        <input type="text" class="form-control" id="remove-unit-name" disabled>
                    </div>
                </form>
                Are you sure you'd like to remove this unit? This will remove all content within this unit!
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <div class="btn-remove-unit-outer">
                    <button id="btn-remove-unit" type="button" class="btn btn-danger">Remove</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add modal dialog -->
<div class="modal fade" id="addUnitDialog" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addModalLabel">Add Unit</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="add-modal-body" class="modal-body">
                    <div class="form-group">
                        <label for="add-unit-name" class="col-form-label">Unit Name:</label>
                        <input type="text" class="form-control" id="add-unit-name" required>
                    </div>
                Enter the name of the unit you'd like to add.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <div class="btn-add-unit-outer">
                    <button id="btn-add-unit" type="submit" class="btn btn-primary">Add</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add quiz modal dialog -->
<div class="modal fade" id="addQuizDialog" tabindex="-1" role="dialog" aria-labelledby="addQuizModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addQuizModalLabel">Add Quiz</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="add-quiz-modal-body" class="modal-body">
                    <div class="form-group">
                        <label for="add-quiz-name" class="col-form-label">Quiz Name:</label>
                        <input type="text" class="form-control" id="add-quiz-name" required>
                    </div>
                Enter the name of the quiz you'd like to add.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <div class="btn-add-quiz-outer">
                    <button id="btn-add-quiz" type="submit" class="btn btn-primary">Add</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add question modal -->
<div class="modal fade" id="addQuestionDialog" tabindex="-1" role="dialog" aria-labelledby="addQuestionModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addQuestionModalLabel">Add Question</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="add-question-modal-body" class="modal-body">
                <div class="form-group">
                    <label for="add-question-name" class="col-form-label">Question:</label>
                    <input type="text" class="form-control" id="add-question-name" required>

                    <div class="custom-file mt-2">
                        <input type="file" class="custom-file-input" id="questionFile">
                        <label class="custom-file-label" for="questionFile">Choose file</label>
                    </div>
                </div>
                Enter the quiz question and an optional image

                <!-- Skeleton to append to.. -->
                <div id="add-question-response"> 

                </div>
                <a id="add-response" href="" data-count="0">Click to add answer..</a>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <div class="btn-add-question-outer">
                    <button id="btn-add-question" type="submit" form="add-question-form" class="btn btn-primary">Add</button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <h1>Content Builder</h1>
    <div class="row">
        <div class="col">
            <div class="accordion" id="accordion">
                <?php
                foreach($units as $u) { //Loop Through all existing units
                    ?>
                    <!-- Unit Title Card: -->
                    <div id="card-<?php echo $u['id']; ?>" class="card">
                        <div class="card-header" id="heading-<?php echo $u['id']; ?>">
                            <div class="row">
                                <div class="col">
                                    <h5>
                                        <button class="btn btn-link" data-toggle="collapse" data-target="#collapse-<?php echo $u['id']; ?>" aria-expanded="true" aria-controls="collapse-<?php echo $u['id']; ?>" data-whatever="<?php echo $u['id']; ?>">
                                            <?php echo ucfirst($u['name']); ?>
                                        </button>
                                    </h5>
                                </div>

                                <!-- Toggle unit available to public TODO: check if unit is public and mark as checked -->
                                <div class="col-md-auto align-self-center">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="privacy-cb custom-control-input" id="switch-public-<?php echo $u['id']; ?>" data-whatever="<?php echo $u['id']; ?>" <?php echo ($u['published'] == 1 ? 'checked' : ''); ?>>
                                        <label class="custom-control-label" for="switch-public-<?php echo $u['id']; ?>" data-toggle="tooltip" title="Toggle content visibility for all users">Public</label>
                                    </div>
                                </div>

                                <!-- Remove Unit -->
                                <div class="col col-lg-2 align-self-center">
                                    <button type="button" id="removeModal" class="btn btn-outline-danger float-right" data-toggle="modal" data-target="#removeUnitDialog" data-whatever="<?php echo $u['name']; ?>">
                                        Remove
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Unit Content: -->
                        <div id="collapse-<?php echo $u['id']; ?>" class="collapse" aria-labelledby="heading-<?php echo $u['id']; ?>" data-parent="#accordion">
                            <div class="card-body">
                                <div id="unit-content-<?php echo $u['id']; ?>">
                                    <div class="d-flex justify-content-center">
                                        <div class="spinner-border" role="status">
                                            <span class="sr-only">Loading...</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>
    </div>

    <div class="row my-3">
        <div class="col">
            <button type="button" id="addUnitModal" class="btn btn-secondary btn-lg btn-block" data-toggle="modal" data-target="#addUnitDialog">
                Add Unit
            </button>
        </div>
    </div>
</div>


<script src="js/builder.js"></script>

<?php require_once('includes/footer.php') ?>