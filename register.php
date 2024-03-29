<?php 
require_once('includes/header.php');

if($user->is_logged_in()) {
    $user->sendDashboard();
} 

if(!empty($_POST)) {
	$name = htmlspecialchars($_POST['inputName']);
    $email = htmlspecialchars($_POST['inputEmail']);
	$pass = htmlspecialchars($_POST['inputPassword']);
	$confirm = htmlspecialchars($_POST['inputConfirmPassword']);
	
	if(strlen($pass) < 8)
		$error[] = 'Password must be at least 8 characters';
	if($pass != $confirm)
		$error[] = 'Passwords do not match';
	
	if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
	    $error[] = 'Please enter a valid email address';
	} else {
        //Check if email already in use
		$stmt = $db->prepare('SELECT email FROM ' . DB_DATABASE . '.users WHERE email = :email');
		$stmt->execute(array(':email' => $email));
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		if(!empty($row['email'])){
			$error[] = 'Email provided is already in use';
		}
	}
	
	if(!isset($error)) {
        $hashed_password = password_hash($pass, PASSWORD_BCRYPT);
		$activasion = md5(uniqid(rand(),true));
		try {
			//insert into database with a prepared statement
			$stmt = $db->prepare('INSERT INTO ' . DB_DATABASE . '.users (email,fullName,password,active) VALUES (:email, :fullName, :password, :active)');
			$stmt->execute(array(
				':email' => $email,
                ':fullName' => $name,
				':password' => $hashed_password,
				':active' => $activasion
			));
			$id = $db->lastInsertId('id');

            $headers  = 'MIME-Version: 1.0' . "\r\n";
            $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
            $headers .= 'From: '.SITE_AUTO_EMAIL."\r\n".
                'Reply-To: '.SITE_AUTO_EMAIL."\r\n" .
                'X-Mailer: PHP/' . phpversion();
            if(mail(
                $email, 
                'Registration Confirmation',
                "<html><body><p>Thank you for registering at Drive2Succeed</p>
                <p>To activate your account, please click on this link: <p><a href='qlick2learn.com/session/activate.php?x=$id&y=$activasion'>qlick2learn.com/session/activate/activate.php?x=$id&y=$activasion</a></p></p>
                <p>Regards Josh Davis</p></body></html>",
                $headers
            )) {
                //Success
            } else {
                $error[] = 'Failed to email: '  . $email;
            }

            if(!isset($error)) {
                header('Location: register.php?action=joined');
                exit;
            }
		} catch(PDOException $e) {
		    $error[] = $e->getMessage();
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
                        <img src="assets/banners/log-reg-banner.jpg" class="d-block w-100" alt="...">
                        <div id="index-carousel-caption" class="carousel-caption d-block">
                            <h1 class="font-weight-bold">Register</h1>
                            <h5>It's a much better experience</h5>
                            <h5>when you have an account</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm">
            <form id="form-rego" class="border rounded" method="POST" action="<?php echo $_SERVER['PHP_SELF'];?>">
                <div class="form-group">
                    <label class="form-label" for="inputName">Name</label>
                    <input type="text" class="form-control form-control-lg" name="inputName" placeholder="John Doe">
                </div>
                <div class="form-group">
                    <label class="form-label" for="inputEmail">Email</label>
                    <input type="email" class="form-control form-control-lg" name="inputEmail" placeholder="example@email.com">
                </div>
                <div class="form-group">
                    <label class="form-label" for="inputPassword">Password</label>
                    <input type="password" class="form-control form-control-lg" name="inputPassword" placeholder="********">
                </div>
                <div class="form-group">
                    <label class="form-label" for="inputConfirmPassword">Confirm Password</label>
                    <input type="password" class="form-control form-control-lg" name="inputConfirmPassword" placeholder="********">
                </div>
                <button type="submit" class="btn btn-primary btn-lg">Register</button>
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
                if($action == 'joined') {
                    echo '<div class="alert alert-success" role="alert">
                    An email has been sent to your inbox with instructions to activate your account.
                    </div>';
                }
            }
            ?>
        </div>
    </div>
</div>

<?php require_once('includes/footer.php'); ?>
