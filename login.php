<?php 
require_once('includes/header.php'); 

if($user->is_logged_in()) {
    $user->sendDashboard();
}

if(isset($_POST['inputEmail']) && isset($_POST['inputPassword'])) {
    if(empty($error)) {
        $email = htmlspecialchars($_POST['inputEmail']);
        $password = htmlspecialchars($_POST['inputPassword']);
        
        if($user->login($email, $password)) { 
            $_SESSION['email'] = $email;
            $user->sendDashboard();
            exit;
        } else {
            $error[] = 'Wrong email, password, or your account hasn\'t been activated';
        }
    }
}

?>

<div class="wrapper">
    <div class="row no-gutters align-items-center">
        <div class="col-sm">
            <div id="carousel-centre" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="assets/banners/log-reg-banner.jpg" class="d-block w-100">
                        <div class="carousel-caption d-block">
                            <h1 class="font-weight-bold">Login</h1>
                            <h5>Pick up stuff from where</h5>
                            <h5>you left off</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm">
            <form id="form-login" class="border rounded" method="POST">
                <div class="form-group">
                    <label class="form-label" for="inputEmail">Email</label>
                    <input type="email" class="form-control form-control-lg" name="inputEmail" placeholder="example@email.com">
                </div>
                <div class="form-group">
                    <label class="form-label" for="inputPassword">Password</label>
                    <input type="password" class="form-control form-control-lg" name="inputPassword" placeholder="********">
                </div>
                <button type="submit" class="btn btn-primary btn-lg">Login</button>

                <div class="row no-gutters align-items-center">
                    <div class="col">
                        <div class="d-flex justify-content-center">
                            <a href="register.php">Not a member? Click here to register.</a>
                        </div>
                    </div>
                </div>
            </form>

            <?php
            if(isset($error)) {
                echo '<div class="alert alert-danger" role="alert">';
                foreach ($error as $curError) {
                    echo '<p>' . $curError . '</p>';
                } 
                echo '</div>';
            } else if(isset($_GET['action'])) {
                $action = htmlspecialchars($_GET['action']);
                if($action == 'active') {
                    echo '<div class="alert alert-success" role="alert">
                    Your account has been activated successfully. Please login to continue.
                    </div>';
                } else if($action == 'expired') {
                    echo '<div class="alert alert-warning" role="alert">
                    Your session has expired. Please login to continue.
                    </div>';
                }
            }
            ?>
        </div>
    </div>
</div>

<?php require_once('includes/footer.php'); ?>
