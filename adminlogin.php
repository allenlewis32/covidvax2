<?php
	session_start();
	include_once('db.php');
	if(isset($_POST['submit'])){
		$uname = $_POST['uname'];
		$pass = $_POST['pass'];
		$sql = "select aid, pass from admins where uname='$uname'";
		$result = $conn -> query($sql);
		if($result -> num_rows == 1){
			$row = $result -> fetch_assoc();
			if(password_verify($pass, $row['pass'])){
				$_SESSION['aid'] = $row['aid'];
				header('Location: admin.php');
				exit();
			}else{
				print('<script>alert("Invalid password");</script>');
			}
		}else{
			print('<script>alert("Invalid username");</script>');
		}
	}
?>
<!DOCTYPE html>
<html>
<head>
<title>Admin Login</title>
<link rel="stylesheet" href="stylesheet.css">
</head>
<h1>Admin Login</h1>
<body>
	<form method='post'>
		<div class="input_block">
			<label>Username</label>
			<input type="text" name="uname" placeholder="Enter your username">
		</div>
		<div class="input_block">
			<label>Password</label>
			<input type="password" name="pass" placeholder="Enter your password">
		</div>
		<button type="submit" name='submit'>Login</button>
	</body>
</html>
