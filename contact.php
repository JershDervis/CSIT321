<?php require_once('includes/header.php'); ?>

<div id="container-white">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1 class="text-center" color="black">Get in touch</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <h5><?php echo 'Address: <a target="_blank" href="https://maps.google.com/?q=:' . SITE_ADDR . '">' . SITE_ADDR . '</a>'; ?></h5>
                <h5><?php echo 'Email: <a href="mailto:' . SITE_EMAIL . '">' . SITE_EMAIL . '</a>'; ?></h5>
                <h5><?php echo 'Phone: <a href="tel:' . str_replace(' ', '', SITE_PHONE) . '">' . SITE_PHONE . '</a>'; ?></h5>
            </div>
        </div>
    </div>
</div>

<?php require_once('includes/footer.php'); ?>
