<?php
require_once '../config/init.php'; 
include '../includes/head.php';

$email = ((isset($_POST['email']))?sanitize($_POST['email']):'');
$email = trim($email);
$password = ((isset($_POST['password']))?sanitize($_POST['password']):'');
$password = trim($password);
//var_dump($password);
$errors = array();
?>
<style>
	body{
		background-image: url(http://www.palmbeachcodeschool.com/wp-content/uploads/2017/02/PBCS-logo1x.png);
		background-attachment: fixed;
		background-repeat: no-repeat;
		background-position: 50% 5%;
	}
	footer{
		color: #4483D7;
		margin-bottom: 15px;
	}
</style>
<div id="login-form">
	<h2 class="text-center">Admin Login</h2>
	<div class="clearfix">
		<a href="../index.php" class="btn btn-info pull-right">Back to Student Login</a>
	</div>
	<hr>
	<form action="admin_login.php" method="POST">
		<div class="form-group">
			<label for="email">Email: </label>
			<input type="email" name="email" id="email" class="form-control" value="<?=$email;?>">
		</div>
		<div class="form-group">
			<label for="password">Password: </label>
			<input type="password" name="password" id="password" class="form-control" value="<?=$password;?>">
		</div>
		<div class="form-group">
			<input type="submit" value="Login" class="btn btn-primary">
		</div>
	</form>
	<div>
		<?php 
		if ($_POST) {
				//form validation
			if(empty($_POST['email']) || empty($_POST['password'])){
				$errors[] = 'You must provide an email and password.';
			}
				//validate email
			if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
				$errors[] = 'You must enter a valid email';
			}
				//check if password is more than 6 characters 
			if (strlen($password) < 6) {
				$errors[] = 'Your password must be at least 6 characters';
			}
				//check if email exists in database
			$query = $db->query("SELECT * FROM admin WHERE email = '$email'");
			$user = mysqli_fetch_assoc($query);
			//var_dump($user);
			$userCount = mysqli_num_rows($query);
			if ($userCount < 1) {
				$errors[] = 'That email doesn\'t exist in our database';
			}
			if (!password_verify($password, $user['password'])) {
				$errors[] = 'The password does not match our records. Please try again';
			}
				//check for errors
			if (!empty($errors)) {
				echo display_errors($errors);
			} else {
					//log user in
				$user_id = $user['id'];
				login($user_id);	
			}				
		}
		?>
	</div>
</div>


<?php include '../includes/footer.php'; ?>