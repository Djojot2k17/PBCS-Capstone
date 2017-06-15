<?php
$db = mysqli_connect('127.0.0.1', 'root', '', 'Capstone');
if (mysqli_connect_errno()) {
	echo 'Database connection failed with following errors: ' . mysqli_connect_error();
	die();
} else {
	//echo 'Connection Successful!';
}
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] .'/php/capstone/config/config.php';
require_once BASEURL . 'config/helpers.php';

$student_id = '';
if (isset($_COOKIE[STUDENT_COOKIE])) {
	$student_id = sanitize($_COOKIE[STUDENT_COOKIE]);
}
//var_dump($_COOKIE);
if (isset($_SESSION['dbuser'])) {
	$user_id = $_SESSION['dbuser'];
	$query = $db->query("SELECT * FROM users WHERE id = '$user_id'");
	$user_data = mysqli_fetch_assoc($query);
}
if (isset($_SESSION['success_flash'])) {
	echo '<div class="bg-success"><p class="text-success text-center">'.$_SESSION['success_flash'] .'</p></div>';
	unset($_SESSION['success_flash']);
}
if (isset($_SESSION['error_flash'])) {
	echo '<div class="bg-danger"><p class="text-danger text-center">'.$_SESSION['error_flash'] .'</p></div>';
	unset($_SESSION['error_flash']);
}