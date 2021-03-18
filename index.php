<?php require_once('includes/header.php'); ?>

<div class="carousel slide" data-ride="carousel">
    <div class="carousel-inner">
        <div class="carousel-item active">
            <img src="assets/banners/home-banner.jpg" class="d-block w-100"/>
            <div id="index-carousel-caption" class="carousel-caption d-block">
                <h1 class="font-weight-bold">A Unique Driving School</h1>
                <h5>Offering Simulation Based</h5>
                <h5>Online Theory Test</h5>

                <div class="row">
                    <div class="col-md-12">
                        <!-- 1 -->
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <!-- 2 -->
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <!-- 3 -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="container-white">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1 class="text-center" color="black">Vehicle Type</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <h5 class="text-center" color="black">We offer a wide range of driving theory test preparations</5>
            </div>
        </div>
        <div class="row align-items-center">
            <div class="col-sm">
                <figure class="figure">
                    <img src="assets/icons/bike.svg" class="figure-img img-fluid rounded" alt="motorbike" unselectable="on">
                    <figcaption class="figure-caption text-center font-weight-bold">Bike</figcaption>
                </figure>
            </div>
            <div class="col-sm">
                <figure class="figure">
                    <img src="assets/icons/car.svg" class="figure-img img-fluid rounded" alt="car" unselectable="on">
                    <figcaption class="figure-caption text-center font-weight-bold">Car</figcaption>
                </figure>
            </div>
            <div class="col-sm">
                <figure class="figure">
                    <img src="assets/icons/bus.svg" class="figure-img img-fluid rounded" alt="bus" unselectable="on">
                    <figcaption class="figure-caption text-center font-weight-bold">Bus</figcaption>
                </figure>
            </div>
            <div class="col-sm">
                <figure class="figure">
                    <img src="assets/icons/truck.svg" class="figure-img img-fluid rounded" alt="truck" unselectable="on">
                    <figcaption class="figure-caption text-center font-weight-bold">Truck</figcaption>
                </figure>
            </div>
            <div class="col-sm">
                <figure class="figure">
                    <img src="assets/icons/fork.svg" class="figure-img img-fluid rounded" alt="fork-lift" unselectable="on">
                    <figcaption class="figure-caption text-center font-weight-bold">Fork-lift</figcaption>
                </figure>
            </div>
        </div>
    </div>
</div>

<div id="container-blue">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1 class="text-center">Why Choose Us?</h1>
            </div>
        </div>

        <div class="row">
            <div class="col-sm text-center">
                <figure class="figure">
                    <img src="assets/icons/quality.svg" class="figure-img img-fluid rounded" alt="quality assessment" unselectable="on">
                    <figcaption class="figure-caption text-center font-weight-bold">Quality Assessment</figcaption>
                    <figcaption class="figure-caption text-center">With our tailored theory roadmap and quizzes you can make up to the mark</figcaption>
                </figure>
            </div>
            <div class="col-sm text-center">
                <figure class="figure">
                    <img src="assets/icons/customer.svg" class="figure-img img-fluid rounded" alt="customer centric" unselectable="on">
                    <figcaption class="figure-caption text-center font-weight-bold">Customer Centric</figcaption>
                    <figcaption class="figure-caption text-center">To understand our customer needs better and deliver them a friendly and reliable service</figcaption>
                </figure>
            </div>
            <div class="col-sm text-center">
                <figure class="figure">
                    <img src="assets/icons/professional.svg" class="figure-img img-fluid rounded" alt="professional" unselectable="on">
                    <figcaption class="figure-caption text-center font-weight-bold">Professional Instructors</figcaption>
                    <figcaption class="figure-caption text-center">Our DVM instructors make sure that you get the best experience</figcaption>
                </figure>
            </div>
        </div>
    </div>
</div>

<div id="container-white">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-5">
                <h1>Get in Touch</h1>
                <p>Leave us a message and one of our team will contact you as soon as possible</p>
            </div>
            <div class="col-sm">
                <form id="form-contact" class="border rounded">
                    <div class="form-group">
                        <label for="inputName">Name</label>
                        <input type="text" class="form-control form-control-lg" id="inputName" placeholder="John Doe">
                    </div>
                    <div class="form-group">
                        <label for="inputEmail">Email</label>
                        <input type="email" class="form-control form-control-lg" id="inputEmail" placeholder="example@email.com">
                    </div>
                    <div class="form-group">
                        <label for="inputMessage">Message</label>
                        <textarea type="text" class="form-control form-control-lg" id="inputMessage" placeholder="Type your message here.."></textarea>
                    </div>
                    <div id="contact-load">
                        <button type="submit" id="contact-submit" class="btn btn-primary btn-lg">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="js/contact.js"></script>

<?php require_once('includes/footer.php'); ?>