<?php require_once('includes/header.php'); ?>

<?php require_once('includes/header.php'); ?>

<div id="container-white">
    <div class="container">

        <div class="row">
            <div class="col-md-12">
                <h1 class="text-center" color="black">FAQS</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="panel-group" id="accordion">
                    <div class="faqHeader"><h5>General questions</h5></div>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseOne">Is account registration required?</a>
                                </h4>
                            </div>
                            <div id="collapseOne" class="panel-collapse collapse in">
                                <div class="panel-body">
                                    Account registration at <strong><?php echo SITE_NAME ?></strong> is required if you wish to attempt any 
                                    quizzes or access any of our learnable content
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">Is it free to sign up?</a>
                                </h4>
                            </div>
                            <div id="collapseTwo" class="panel-collapse collapse">
                                <div class="panel-body">
                                    You can register an account today for free! Click <a href="register.php">here</a> to start the sign up process.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once('includes/footer.php'); ?>


<?php require_once('includes/footer.php'); ?>
