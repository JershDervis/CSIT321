<?php
require_once($_SERVER['DOCUMENT_ROOT'] .'/config.php');

if(!$user->isAdmin()) { // Check Admin
    header('Location: login.php');
    exit;
}
if(!isset($_GET['id']) && empty($_GET['id'])) { //Check Unit ID is set
    echo 'Invalid unit.';
    exit;
}

$unitID = $_GET['id'];
//Load image for unit.
try {
    $stmt = $db->prepare('SELECT f.file_name, f.loc_name FROM files f LEFT JOIN unit u ON u.unit_img=f.id WHERE u.id= :unitID ;');
    $stmt->execute(array(
        'unitID'  =>  $unitID
    ));
    $unitImg = $stmt->fetch(PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    echo $e->getMessage();
}
if(empty($unitImg) || $unitImg == null) {
    $unitImg['file_name'] = 'Temporary Filler';
    $unitImg['loc_name'] = '../assets/icons/filler.svg';
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

try {
    $stmt = $db->prepare('SELECT i.title, i.info FROM information i WHERE i.unit_id= :unitID ;');
    $stmt->execute(array(
        'unitID'  =>  $unitID
    ));
    $infoArticles = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    echo $e->getMessage();
}

$quizzes = $user->getUnitQuizes($unitID);

?>

<div class="row">
    <div class="col-3">
        <div class="nav flex-column nav-pills" id="v-pills-tab-<?php echo $unitID; ?>" role="tablist" aria-orientation="vertical">
            <a class="nav-link active" id="v-pills-general-tab-<?php echo $unitID; ?>" data-toggle="pill" href="#v-pills-general-<?php echo $unitID; ?>" role="tab" aria-controls="v-pills-general-<?php echo $unitID; ?>" aria-selected="true">General</a>
            <a class="nav-link" id="v-pills-theory-tab-<?php echo $unitID; ?>" data-toggle="pill" href="#v-pills-theory-<?php echo $unitID; ?>" role="tab" aria-controls="v-pills-theory-<?php echo $unitID; ?>" aria-selected="true">Theory</a>
            <a class="nav-link" id="v-pills-info-tab-<?php echo $unitID; ?>" data-toggle="pill" href="#v-pills-info-<?php echo $unitID; ?>" role="tab" aria-controls="v-pills-info-<?php echo $unitID; ?>" aria-selected="false">Information</a>
            <a class="nav-link" id="v-pills-quizzes-tab-<?php echo $unitID; ?>" data-toggle="pill" href="#v-pills-quizzes-<?php echo $unitID; ?>" role="tab" aria-controls="v-pills-quizzes-<?php echo $unitID; ?>" aria-selected="false">Quizzes</a>
        </div>
    </div>
    <div class="col-9">
        <div class="tab-content" id="v-pills-tabContent-<?php echo $unitID; ?>">
            <div class="tab-pane fade show active" id="v-pills-general-<?php echo $unitID; ?>" role="tabpanel" aria-labelledby="v-pills-general-tab-<?php echo $unitID; ?>">
                <h5>General</h5>
                <div class="card" style="width: 18rem;">
                    <img id="unit-card-<?php echo $unitID; ?>" class="card-img-top" src="<?php echo 'uploads/' . $unitImg['loc_name']; ?>" alt="<?php echo $unitImg['file_name']; ?>">
                    <div class="card-body">
                        <h5 class="card-title">Unit Card</h5>
                        <p class="card-text">Click Browse to Update the image.</p>
                        <a id="btn-update-unit-img" class="btn btn-primary" onclick="document.getElementById('unit-img-file-<?php echo $unitID; ?>').click();" data-btn-img-unit="<?php echo $unitID; ?>">Browse</a>
                        <input type="file" class="unit-file-update" id="unit-img-file-<?php echo $unitID; ?>" name="image" data-img-unit="<?php echo $unitID; ?>" style="display:none;"/>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade show" id="v-pills-theory-<?php echo $unitID; ?>" role="tabpanel" aria-labelledby="v-pills-theory-tab-<?php echo $unitID; ?>">
                <h5>Theory</h5>
                <div id="theory-list-<?php echo $unitID; ?>">
                    <?php
                    if(isset($theoryLinks)) {
                        foreach($theoryLinks as $link) {
                            echo '<p><a href="' . $link['link'] . '" target="_blank">' . $link['title'] . '</a></p>';
                        }
                    }
                    ?>
                </div>
                <div class="row my-3">
                    <div class="col">
                        <button type="button" id="addTheoryModal" class="btn btn-secondary btn-block" data-toggle="modal" data-target="#addTheoryDialog" data-uid="<?php echo $unitID; ?>">
                            Add Theory Link
                        </button>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="v-pills-info-<?php echo $unitID; ?>" role="tabpanel" aria-labelledby="v-pills-info-tab-<?php echo $unitID; ?>">
                <h5>Information</h5>
                <div id="info-list-<?php echo $unitID; ?>">
                    <?php
                    if(isset($infoArticles)) {
                        foreach($infoArticles as $info) {
                            echo '<h5>' . $info['title'] . '</h5>';
                            echo '<p>' . $info['info'] . '</p>';
                        }
                    }
                    ?>
                </div>
                <div class="row my-3">
                    <div class="col">
                        <button type="button" id="addInfoModal" class="btn btn-secondary btn-block" data-toggle="modal" data-target="#addInfoDialog" data-uid="<?php echo $unitID; ?>">
                            Add Info Article
                        </button>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="v-pills-quizzes-<?php echo $unitID; ?>" role="tabpanel" aria-labelledby="v-pills-quizzes-tab-<?php echo $unitID; ?>">
                <h5>Quizzes</h5>
                <div class="row">
                    <div class="col">
                        <div class="accordion-inner" id="quiz-list-<?php echo $unitID; ?>">
                            <?php foreach($quizzes as $q) { ?>
                                <div id="card-quiz-<?php echo $q['id']; ?>" class="card">
                                    <div class="card-header" id="heading-quiz-<?php echo $q['id']; ?>">
                                        <div class="row">
                                            <div class="col">
                                                <h5 class="mb-0">
                                                    <button class="btn-inner-accordion btn btn-link" data-toggle="collapse" data-target="#collapse-quiz-<?php echo $q['id']; ?>" aria-expanded="true" aria-controls="collapse-quiz-<?php echo $q['id']; ?>" data-qid="<?php echo $q['id']; ?>">
                                                        <?php echo ucfirst($q['name']); ?>
                                                    </button>
                                                </h5>
                                            </div>
                                            <!-- Toggle quiz available to public -->
                                            <div class="col-md-auto align-self-center">
                                                <div class="custom-control custom-switch">
                                                    <input type="checkbox" class="quiz-published-check custom-control-input" id="switch-public-quiz-<?php echo $q['id']; ?>" data-qid="<?php echo $q['id']; ?>" <?php echo ($q['published'] == 1 ? 'checked' : ''); ?>>
                                                    <label class="custom-control-label" for="switch-public-quiz-<?php echo $q['id']; ?>" data-toggle="tooltip" title="Toggle content visibility for all users">Public</label>
                                                </div>
                                            </div>
                                            <!-- Remove Quiz -->
                                            <div class="col col-lg-2 align-self-center">
                                                <button type="button" class="btn-remove-quiz btn btn-outline-danger float-right" data-qid="<?php echo $q['id']; ?>">
                                                    Remove
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="collapse-quiz-<?php echo $q['id']; ?>" class="collapse" aria-labelledby="heading-quiz-<?php echo $q['id']; ?>" data-parent="#quiz-list-<?php echo $unitID; ?>">
                                        <div class="card-body">
                                            <div id="quiz-content-<?php echo $q['id']; ?>">
                                                <div class="d-flex justify-content-center">
                                                    <div class="spinner-border" role="status">
                                                        <span class="sr-only">Loading...</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <!-- TODO: Button to add quiz -->
                <div class="row my-3">
                    <div class="col">
                        <button type="button" id="addQuizModal" class="btn btn-secondary btn-block" data-toggle="modal" data-target="#addQuizDialog" data-uid="<?php echo $unitID; ?>">
                            Add Quiz
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>