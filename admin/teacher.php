<?php
require_once '../config/init.php'; 
include '../includes/head.php';

$email = ((isset($_POST['email']))?sanitize($_POST['email']):'');
$email = trim($email);
$password = ((isset($_POST['password']))?sanitize($_POST['password']):'');
$password = trim($password);
$errors = array();
?>
<style>
	body{
		background-image: url(http://www.palmbeachcodeschool.com/wp-content/uploads/2017/02/PBCS-logo1x.png);
		background-repeat: no-repeat;
		background-position: 50% 5%;
	}
	footer{
		color: #4483D7;
		margin-bottom: 15px;
	}
</style>
<div id="login-form">
	<div>
		<?php 
		if ($_POST) {
				//form validation
			if(empty($_POST['email']) || empty($_POST['password'])){
				$errors[] = 'You must provide a username and password.';
			}
				//check if password is more than 6 characters 
			if (strlen($password) < 6) {
				$errors[] = 'Your password must be at least 6 characters';
			}
				//check if user exists in database
			$query = $db->query("SELECT * FROM users WHERE email = '$email'"); // CHANGE TO PDO
			$user = mysqli_fetch_assoc($query);
				//check for errors
			if (!empty($errors)) {
				echo display_errors($errors);
			} else {
					//log user in
				$user_id = $user['id'];
				$user_permission = $user['permissions'];
				if ($user_permission != 'teacher') {
					teacherLoginErrorRedirect();
				} else {
					teacher_login($user_id);
				}
			}				
		}
		?>
	</div>
	<h2 class="text-center">Teacher Login</h2>
	<div class="clearfix">
		<a href="new_teacher.php" class="btn btn-warning pull-left">Register</a>
		<a href="../index.php" class="btn btn-info pull-right">Back to Student Login</a>
	</div>
	<hr>
	<form action="teacher.php" method="POST">
		<div class="form-group">
			<label for="email">Email: </label>
			<input type="text" name="email" id="email" class="form-control" value="<?=$email;?>">
		</div>
		<div class="form-group">
			<label for="password">Password: </label>
			<input type="password" name="password" id="password" class="form-control" value="<?=$password;?>">
		</div>
		<div class="form-group">
			<input type="submit" value="Login" class="btn btn-primary">
		</div>
	</form>
</div>


<?php include '../includes/footer.php'; ?>