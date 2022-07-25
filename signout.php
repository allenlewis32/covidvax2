<?php
	session_start();
	unset($_SESSION['uid']);
	unset($_SESSION['aid']);
	unset($_SESSION['fname']);
	unset($_SESSION['lname']);
	header('Location: index.php');
	session_destroy();
?>
