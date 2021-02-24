<?php
require(__DIR__. '/../config.php'); 

//if logged in redirect
if($user->is_logged_in()) {
    header('Location: index.php'); 
} 

$stmt = $db->prepare('SELECT resetToken, resetComplete FROM ' . DATABASE . '.accounts WHERE resetToken = :token');
$stmt->execute(array(':token' => $_GET['key']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
//if no token from db then kill the page
if(empty($row['resetToken'])) {
	$stop = 'Invalid token provided, please use the link provided in the reset email.';
} elseif($row['resetComplete'] == 'Yes') {
	$stop = 'Your password has already been changed!';
}

//if form has been submitted process it
if(isset($_POST['submit'])) {
	//basic validation
	if(strlen($_POST['password']) < 3) {
		$error[] = 'Password is too short.';
	}
	if(strlen($_POST['passwordConfirm']) < 3) {
		$error[] = 'Confirm password is too short.';
	}
	if($_POST['password'] != $_POST['passwordConfirm']) {
		$error[] = 'Passwords do not match.';
	}
	//if no errors have been created carry on
	if(!isset($error)) {
		//hash the password
		$hashedpassword = $user->password_hash($_POST['password'], PASSWORD_BCRYPT);
		try {
			$stmt = $db->prepare("UPDATE " . DATABASE . ".accounts SET password = :hashedpassword, resetComplete = 'Yes'  WHERE resetToken = :token");
			$stmt->execute(array(
				':hashedpassword' => $hashedpassword,
				':token' => $row['resetToken']
			));
			//redirect to index page
			header('Location: login.php?action=resetAccount');
			exit;
		//else catch the exception and show the error.
		} catch(PDOException $e) {
		    $error[] = $e->getMessage();
		}
	}
}

?>