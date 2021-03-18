        
        </div>
        <!-- Page Footer -->
        <footer id="footer" class="mainfooter" role="contentinfo">
            <div class="footer-middle">
            <div class="container">
                <div class="row">
                    <div class="col-sm-5">
                        <div class="footer-pad">
                            <img id="footer-logo" src="assets/logo-w.svg" alt="Drive 2 Succeed">
                            <p>
                            Drive to Succeed Driving School (DSSD), 
                            business goal is to offer one-stop facility for
                            the aspirants who wish to have a driving 
                            license.
                            </p>
                        </div>
                    </div>
                    <div class="col-sm">
                        <div class="footer-pad">
                        <h4>Quick Links</h4>
                        <ul class="list-unstyled">
                            <?php
                            foreach ($pages as $filename => $pageTitle) {
                                echo '<li><a href="' . $filename . '">' . $pageTitle . '</a></li>';
                            }
                            ?>
                        </ul>
                        </div>
                    </div>

                    <div class="col-sm">
                        <div class="footer-pad">
                        <h4>Have a Question?</h4>
                        <ul class="list-unstyled">
                            <?php
                            echo '<li><a href="mailto:' . SITE_EMAIL . '">' . SITE_EMAIL . '</a></li>';
                            echo '<li><a target="_blank" href="https://maps.google.com/?q=:' . SITE_ADDR . '">' . SITE_ADDR . '</a></li>';
                            echo '<li><a href="tel:' . str_replace(' ', '', SITE_PHONE) . '">' . SITE_PHONE . '</a></li>';
                            ?>
                        </ul>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 copy">
                        <p class="text-center">&copy; Copyright 2021 - D2S.  All rights reserved.</p>
                    </div>
                </div>


            </div>
            </div>
        </footer>


        </div>
        <script src="js/footer.js"></script>
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
    </body>
</html>
