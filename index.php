<?php 
require_once 'config/init.php';
include 'includes/head.php';

$email = ((isset($_POST['email']))?sanitize($_POST['email']):'');
$email = trim($email);
$password = ((isset($_POST['password']))?sanitize($_POST['password']):'');
$password = trim($password);
$hashed = password_hash($password, PASSWORD_DEFAULT);
$errors = array();
?>
<style>
	body{
		background-image: url(http://www.palmbeachcodeschool.com/wp-content/uploads/2017/02/PBCS-logo1x.png);
		background-attachment: fixed;
		background-repeat: no-repeat;
		background-position: 50% 85%;
	}
	footer{
		color: #4483D7;
		margin-top: 150px;
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
			$query = $db->query("SELECT * FROM users WHERE email = '$email'"); 
			$user = mysqli_fetch_assoc($query);
				//check for errors
			if (!empty($errors)) {
				echo display_errors($errors);
			} else {
					//log user in
				$user_id = $user['id'];
				student_login($user_id);	
			}				
		}
		?>
	</div>
	<h2 class="text-center">Student Login</h2>
	<div class="clearfix">
		<a href="new_user.php" class="btn btn-info pull-right">Register</a>
		<a href="admin/teacher.php" class="btn btn-danger pull-left">Teachers</a>
	</div>
	<hr>
	<form action="index.php" method="POST">
		<div class="form-group">
			<label for="email">email: </label>
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
</div>
<?php include 'includes/footer.php'; ?>