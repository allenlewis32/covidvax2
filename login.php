<?php
	session_start();
	include_once('db.php');
	if(isset($_POST['submit'])){
		$email = $_POST['email'];
		$pass = $_POST['pass'];
		$sql = "select * from users where email='$email'";
		$result = $conn -> query($sql);
		if($result -> num_rows == 1){
			$row = $result -> fetch_assoc();
			if(password_verify($pass, $row['pass'])){
				$_SESSION['uid'] = $row['uid'];
				$_SESSION['fname'] = $row['fname'];
				$_SESSION['lname'] = $row['lname'];
				header('Location: vax.php');
				exit();
			}else{
				print('<script>alert("Invalid password");</script>');
			}
		}else{
			print('<script>alert("User not registered");</script>');
		}
	}
?>
<!DOCTYPE html>
<html>
<head>
<title>Login</title>
<link rel="stylesheet" href="stylesheet.css">
</head>
<h1>Login</h1>
<body>
	<form method='post'>
		<div class="input_block">
			<label>Email</label>
			<input type="email" name="email" placeholder="Enter your email">
		</div>
		<div class="input_block">
			<label>Password</label>
			<input type="password" name="pass" placeholder="Enter your password">
		</div>
		<button type="submit" name='submit'>Login</button>
	</body>
</html>
