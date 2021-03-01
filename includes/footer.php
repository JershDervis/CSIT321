        
        </div>

        <!-- Page Footer -->
        <footer class="mainfooter" role="contentinfo">
            <div class="footer-middle">
            <div class="container">
                <div class="row">
                    <div class="col-sm-5">
                        <!--Column1-->
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
                        <!--Column1-->
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
                    <!-- <div class="col-sm">
                        <h4>Follow Us</h4>
                        <ul class="social-network social-circle">
                        <li><a href="#" class="icoFacebook" title="Facebook"><i class="fa fa-facebook"></i></a></li>
                        <li><a href="#" class="icoLinkedin" title="Linkedin"><i class="fa fa-linkedin"></i></a></li>
                        </ul>				
                    </div> -->

                    <div class="col-sm">
                        <!--Column1-->
                        <div class="footer-pad">
                        <h4>Have a Question?</h4>
                        <ul class="list-unstyled">
                            <?php
                            echo '<li><a href="mailto:' . $SITE_EMAIL . '">' . $SITE_EMAIL . '</a></li>';
                            echo '<li><a target="_blank" href="https://maps.google.com/?q=:' . $SITE_ADDR . '">' . $SITE_ADDR . '</a></li>';
                            echo '<li><a href="tel:' . str_replace(' ', '', $SITE_PHONE) . '">' . $SITE_PHONE . '</a></li>';
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
        <script src="js/jquery-3.5.1.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/util.js"></script>
    </body>
</html>
