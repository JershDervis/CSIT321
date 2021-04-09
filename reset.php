<?php
require_once('includes/header.php');

if(isset($_GET['key']) && !empty($_GET['key'])) {
    $token = $_GET['key'];

	$stmt = $db->prepare('SELECT fullName, resetToken, resetComplete FROM ' . DB_DATABASE . '.users WHERE resetToken = :token');
	$stmt->execute(array(':token' => $_GET['key']));
	$row = $stmt->fetch(PDO::FETCH_ASSOC);
	//if no token from db then kill the page
	if(empty($row['resetToken'])) {
		echo 'Invalid token provided, please use the link provided in the reset email.';
		die();
	} elseif($row['resetComplete'] == 'Yes') {
		echo 'Your password has already been changed!';
		die();
	}

?>
<!--	Change the password	-->
<div id="container-white">
	<div class="container">
		<div class="row">
			<div class="col-6 justify-content-center align-items-center">
				<form role="form" method="post" action="" autocomplete="off">
					<h2>Change password for <?php echo $row['fullName'] ?></h2>
					<div class="form-group">
                    	<label class="form-label" for="inputPassword">Password</label>
                    	<input id="inputPass" type="password" class="form-control form-control-lg" name="inputPassword" placeholder="********">
					</div>
					<div class="form-group">
						<label class="form-label" for="inputConfirmPassword">Confirm Password</label>
						<input id="inputPassConfirm" type="password" class="form-control form-control-lg" name="inputConfirmPassword" placeholder="********">
					</div>
					<div class="row">
						<div class="col-sm" id="btn-container">
							<button id="btn-change" type="submit" class="btn btn-primary btn-lg">Update Password</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<?php 
} else {
?>

<!--	Request a password reset	-->
<div id="container-white">
	<div class="container">
		<div class="row">
			<div class="col-6 justify-content-center align-items-center">
				<form role="form" method="post" action="" autocomplete="off">
					<h2>Reset Password</h2>
					<div class="form-group">
                    	<label class="form-label" for="inputEmail">Email</label>
                    	<input type="email" id="reset-email" class="form-control form-control-lg" name="inputEmail" placeholder="example@email.com">
                	</div>
					<div class="row">
						<div class="col-sm" id="btn-container">
							<button id="btn-reset" type="submit" class="btn btn-primary btn-lg">Send Reset Link</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>


<?php 
}
echo '<script src="js/reset.js"></script>';
require_once('includes/footer.php'); 
?>