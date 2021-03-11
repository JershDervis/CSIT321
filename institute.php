<?php require_once('includes/header.php'); 

echo '<script>
function initMap() {
    const myLatLng = { lat: -25.363, lng: 131.044 };
    const map = new google.maps.Map(document.getElementById("map"), {
      zoom: 4,
      center: myLatLng,
    });
    new google.maps.Marker({
      position: myLatLng,
      map,
      title: "Hello World!",
    });
}
</script>';
?>

<div id="carouselInstitute" class="carousel slide" data-ride="carousel">
    <ol class="carousel-indicators">
        <li data-target="#carouselInstitute" data-slide-to="0" class="active"></li>
        <li data-target="#carouselInstitute" data-slide-to="1"></li>
    </ol>
    <div class="carousel-inner">
        <div class="carousel-item active">
            <img src="assets/banners/home-banner.jpg" height="700" class="d-block w-100" alt="...">
            <div class="carousel-caption d-none d-md-block">
                <h5>First slide label</h5>
                <p>Nulla vitae elit libero, a pharetra augue mollis interdum.</p>
            </div>
        </div>
    <div class="carousel-item">
        <img src="assets/banners/motorbike.jpg"  height="700" class="d-block w-100" alt="...">
        <div class="carousel-caption d-none d-md-block">
                <h5>Second slide label</h5>
                <p>Nulla vitae elit libero, a pharetra augue mollis interdum.</p>
        </div>
    </div>
    </div>
    <a class="carousel-control-prev" href="#carouselInstitute" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#carouselInstitute" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
    </a>
</div>

<div id="container-white">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1 class="text-center" color="black">Location</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <h5 class="text-center" color="black"><?php echo SITE_ADDR; ?></h5>
            </div>
        </div>
        <div class="row"> 
            <div class="col-md-12 text-center">
                <iframe width="600" height="500" id="gmap_canvas" src="https://maps.google.com/maps?q=Northfields%20Ave,%20Wollongong%20NSW&t=&z=13&ie=UTF8&iwloc=&output=embed" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe>
            </div>
        </div>
    </div>
</div>

<?php require_once('includes/footer.php'); ?>
