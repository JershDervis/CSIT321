<?php 
require_once('includes/header.php');

if($user->is_logged_in()) {
    header('Location: /dashboard/index.php'); 
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
		$stmt = $db->prepare('SELECT email FROM ' . DB_DATABASE . '.accounts WHERE email = :email');
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
			$stmt = $db->prepare('INSERT INTO ' . DB_DATABASE . '.accounts (email,fullName,password,active) VALUES (:email, :fullName, :password, :active)');
			$stmt->execute(array(
				':email' => $email,
                ':fullName' => $name,
				':password' => $hashed_password,
				':active' => $activasion
			));
			$id = $db->lastInsertId('id');
			//send email
			$subject = "Registration Confirmation";
			$body = "<p>Thank you for registering at MonitorJ.net</p>
			<p>To activate your account, please click on this link: <p><a href='".DIR."session/activate.php?x=$id&y=$activasion'>".DIR."activate.php?x=$id&y=$activasion</a></p></p>
			<p>Regards Josh Davis</p>";
			$mail = new Mail();
			$mail->setFrom(SITE_EMAIL);
			$mail->addAddress($email);
			$mail->subject($subject);
			$mail->body($body);
			$mail->send();
			header('Location: register.php?action=joined');
			exit;
		} catch(PDOException $e) {
		    $error[] = $e->getMessage();
		}
	}
}

?>

<div class="wrapper">
    <div class="row align-items-center">
        <div class="col-sm">
            <div id="carousel-centre" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="assets/banners/log-reg.svg" class="d-block w-100" alt="...">
                        <div class="carousel-caption d-block">
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
                    <label for="inputName">Name</label>
                    <input type="text" class="form-control form-control-lg" name="inputName" placeholder="John Doe">
                </div>
                <div class="form-group">
                    <label for="inputEmail">Email</label>
                    <input type="email" class="form-control form-control-lg" name="inputEmail" placeholder="example@email.com">
                </div>
                <div class="form-group">
                    <label for="inputPassword">Password</label>
                    <input type="password" class="form-control form-control-lg" name="inputPassword" placeholder="********">
                </div>
                <div class="form-group">
                    <label for="inputConfirmPassword">Confirm Password</label>
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
            } else if(isset($_GET)) {
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
