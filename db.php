<?php
	$hostname="localhost";
	$username="covidvax";
	$password="password";
	$dbname="covidvax";
	$conn = new mysqli($hostname, $username, $password, $dbname);
	if($conn->connect_error)
		die("Connection failed: " + $conn->connect_error);
?>
