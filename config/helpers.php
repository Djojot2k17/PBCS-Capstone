<?php 
function display_errors($errors){
	$display = '<ul class="bg_danger">';
	foreach ($errors as $error) {
		$display .= '<li class="text-danger">'.$error.'</li>';
	}
	$display .= '</ul>';
	return $display;
}

function sanitize($dirty){
	return htmlentities($dirty, ENT_QUOTES, "UTF-8");
}
function money($number){
	return '$'.number_format($number, 2);
} 
function login($user_id){
	$_SESSION['dbuser'] = $user_id;
	global $db;
	$date = date('Y-m-d H:i:s');
	$db->query("UPDATE admin SET last_login = '$date' WHERE id = '$user_id'");
	$_SESSION['success_flash'] = 'You are now logged in!';
	header('Location: dashboard.php');
}
function student_login($user_id){
	$_SESSION['dbuser'] = $user_id;
	global $db;
	$date = date('Y-m-d H:i:s');
	$db->query("UPDATE users SET last_login = '$date' WHERE id = '$user_id'");
	$_SESSION['success_flash'] = 'You are now logged in!';
	header('Location: student/dashboard.php');
}
function teacher_login($user_id){
	$_SESSION['dbuser'] = $user_id;
	global $db;
	$date = date('Y-m-d H:i:s');
	$db->query("UPDATE users SET last_login = '$date' WHERE id = '$user_id'");
	$_SESSION['success_flash'] = 'You are now logged in!';
	header('Location: ../teacher/index.php');
}
function isLoggedIn(){
	if (isset($_SESSION['dbuser']) && $_SESSION['dbuser'] > 0) {
		return true;
	}
	else {
		return false;
	}
}
function teacherLoginErrorRedirect($url = 'teacher.php'){
	$_SESSION['error_flash'] = 'You must be logged in to access this page';
	header('Location: '.$url);
}
function hasPermission($permission = 'admin'){
	global $user_data;
	$permissions = explode(',', $user_data['permissions']);
	if (in_array($permission, $permissions, true)) {
		return true;
	} else {
		return false;
	}
}
function hasTeacherPermission($permission = 'teacher'){
	global $user_data;
	$permissions = explode(',', $user_data['permissions']);
	if (in_array($permission, $permissions, true)) {
		return true;
	} else {
		return false;
	}
}
function permissionErrorRedirect($url = 'index.php'){
	$_SESSION['error_flash'] = 'You do not have permission to access this page';
	header('Location: '.$url);
}

?>