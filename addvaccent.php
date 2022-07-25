<?php
	session_start();
	if(!isset($_SESSION['aid'])){
		header('Location: index.php');
		exit();
	}
	include_once('db.php');
	if(isset($_POST['submit'])){
		$name = $_POST['name'];
		$loc = $_POST['loc'];
		$sql = "insert into vaccenter(name, location) values('$name', '$loc')";
		if($conn->query($sql)){
			print('<script>alert("Vaccination center added successfully");</script>');
		}else{
			print('<script>alert("Unable to add vaccination center");</script>');
		}
	}
?>
<!DOCTYPE html>
<html>
<head>
<title>Add vaccination center</title>
<link rel="stylesheet" href="stylesheet.css">
</head>
<h1>Add vaccination center</h1>
<body>
	<form method='post'>
		<div class="input_block">
			<label>Name</label>
			<input type="text" name="name">
		</div>
		<div class="input_block">
			<label>Location</label>
			<textarea name="loc" placeholder="Enter the location of the vaccination center"></textarea>
		</div>
		<button type="submit" name='submit'>Add</button><br>
		<a href="admin.php">Go back</a><br>
	</body>
</html>

