<?php 
require_once 'config/init.php';
include 'includes/head.php';
?>

<style>
	body{
		background-image: url(http://www.palmbeachcodeschool.com/wp-content/uploads/2017/02/PBCS-logo1x.png);
		background-attachment: fixed;
		background-repeat: no-repeat;
		background-position: 50% 5%;
		background-color: #EFEFEF;
	}
	footer{
		color: #4483D7;
		margin-bottom: 15px;
	}
</style>
<div id="login-form">
	<div>
		<?php 
		$first_name = ((isset($_POST['first_name']))?sanitize($_POST['first_name']):'');
		$first_name = trim($first_name);
		$last_name = ((isset($_POST['last_name']))?sanitize($_POST['last_name']):'');
		$last_name = trim($last_name);
		$email = ((isset($_POST['email']))?sanitize($_POST['email']):'');
		$email = trim($email);
		$phone_number = ((isset($_POST['phone_number']))?sanitize($_POST['phone_number']):'');
		$phone_number = trim($phone_number);
		$password = ((isset($_POST['password']))?sanitize($_POST['password']):'');
		$password = trim($password);
		$hashed = password_hash($password, PASSWORD_DEFAULT);
		$errors = array();
		$permission = 'student';
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
				//check for errors
			if (!empty($errors)) {
				echo display_errors($errors);
			} else {
				$user_sql = "INSERT INTO users 
				(first_name, last_name, phone_number, email, user_password, permissions) 
								 			VALUES 
				('$first_name', '$last_name', '$phone_number', '$email', '$hashed', '$permission')";
				$db->query($user_sql);
				//log user in
				$_SESSION['success_flash'] = 'Welcome ' .$first_name. ', please log in.';
				header('Location: index.php');				
			}				
		}
		?>
	</div>
	<h2 class="text-center">New User</h2><hr>
	<form action="new_user.php" method="POST">
		<div class="form-group">
			<label for="first_name">First Name: </label>
			<input type="text" name="first_name" id="first_name" class="form-control" value="<?=$first_name;?>">
		</div>
		<div class="form-group">
			<label for="last_name">Last Name: </label>
			<input type="text" name="last_name" id="last_name" class="form-control" value="<?=$last_name;?>">
		</div>
		<div class="form-group">
			<label for="email">Email: </label>
			<input type="email" name="email" id="email" class="form-control" value="<?=$email;?>">
		</div>
		<div class="form-group">
			<label for="phone_number">Phone Number: </label>
			<input type="tel" name="phone_number" id="phone_number" class="form-control" value="<?=$phone_number;?>">
		</div>
		<div class="form-group">
			<label for="password">Password: </label>
			<input type="password" name="password" id="password" class="form-control" value="<?=$password;?>">
		</div>
		<div class="form-group">
			<input type="submit" value="Submit" class="btn btn-primary">
		</div>
	</form>
</div>


<?php include 'includes/footer.php'; ?>
