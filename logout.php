<?php 
require_once $_SERVER['DOCUMENT_ROOT'].'/php/capstone/config/init.php';
unset($_SESSION['dbuser']);
header('Location: index.php');
?>