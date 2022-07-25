<?php
	session_start();
	include_once('db.php');
	if(isset($_POST['submit'])){
		$email = $_POST['email'];
		$pass = password_hash($_POST['pass'], PASSWORD_BCRYPT);
		$fname = $_POST['fname'];
		$lname = $_POST['lname'];
		$sql = "select uid from users where email='$email'";
		if($conn->query($sql)->num_rows > 0){
			print('<script>alert("User already registered");</script>');
		}else{
			$sql = "insert into users(email, pass, fname, lname) values('$email', '$pass', '$fname', '$lname')";
			if($conn->query($sql)){
				$_SESSION['uid'] = $conn->insert_id;
				header('Location: vax.php');
				exit();
			}else{
				print('<script>Unable to register user</script>');
			}
		}
	}
?>
<!DOCTYPE html>
<html>
<head>
<title>Register</title>
<link rel="stylesheet" href="stylesheet.css">
</head>
<h1>Register</h1>
<body>
	<form method='post'>
		<div class="input_block">
			<label>First name</label>
			<input type="text" name="fname" placeholder="Enter your first name">
		</div>
		<div class="input_block">
			<label>Last name</label>
			<input type="text" name="lname" placeholder="Enter your last name">
		</div>
		<div class="input_block">
			<label>Email</label>
			<input type="email" name="email" placeholder="Enter your email">
		</div>
		<div class="input_block">
			<label>Password</label>
			<input type="password" name="pass" placeholder="Enter your password">
		</div>
		<button type="submit" name="submit">Register</button>
	</body>
</html>
