<?php 
require_once('includes/header.php'); 

if(!$user->is_logged_in()) {
    header('Location: login.php');
    exit;
}
?>

<style>
#user-form {
    width: 25em;
}
</style>

<div id="container-white">
    <div class="d-flex justify-content-center">
        <form id="user-form">
            <div class="form-group row">
                <label for="staticName" class="col-sm-2 col-form-label">Name</label>
                <div class="col-sm-10">
                    <input type="text" readonly class="form-control" id="staticName" value="<?php echo $_SESSION['name'] ?>">
                </div>
                <label for="staticEmail" class="col-sm-2 col-form-label">Email</label>
                <div class="col-sm-10">
                    <input type="text" readonly class="form-control" id="staticEmail" value="<?php echo $_SESSION['email'] ?>">
                </div>
            </div>
        </form>
    </div>
</div>


<?php 
require_once('includes/footer.php'); 
?>
