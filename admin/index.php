<?php 
require_once '../config/init.php';
if (!isLoggedIn()) {
	header('Location: admin_login.php');
}
include '../includes/head.php';
include '../includes/admin_navigation.php';
?>

Administrator Home

<?php
include '../includes/footer.php'; 
?>