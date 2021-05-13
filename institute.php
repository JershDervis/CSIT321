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
