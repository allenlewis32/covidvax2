<?php
	session_start();
	if(!isset($_SESSION['aid'])){
		header('Location: index.php');
		exit();
	}
	include_once('db.php');
	if(isset($_POST['submit'])){
		$cid = $_POST['todelete'];
		$sql = "delete from vaccenter where cid = $cid";
		if(!$conn->query($sql)){
			print('<script>alert("Unable to delete the center");</script>');
		}
		$sql = "update vaccination set cid=0 where cid = $cid";
		$conn->query($sql);
	}
?>
<!DOCTYPE html>
<html>
<head>
<title>Admin Panel</title>
<link rel="stylesheet" href="stylesheet.css">
</head>
<body>
<h1>Admin Panel</h1>
<a href='addvaccent.php'><button onclick='addVaccinationCenter()'>Add vaccination center</button></a><br>
<?php
	$sql = "select vc.*, count(v.uid) as total from vaccenter as vc left join vaccination as v on vc.cid=v.cid group by vc.cid";
	$res = $conn->query($sql);
	if($res -> num_rows > 0){
?>
		<form method='post'>
		<input type='hidden' name='submit'>
		<table border=1>
		<tr>
		<th>Name</th>
		<th>Location</th>
		<th>Dosage count</th>
		<th></th>
		</tr>
<?php
		while($row = $res -> fetch_assoc()){
?>
			<tr>
			<td><?=$row['name']?></td>
			<td><?=$row['location']?></td>
			<td><?=$row['total']?></td>
			<td><button type='submit' name='todelete' value='<?=$row["cid"]?>'>Delete</td>
			</tr>
<?php
		}
?>
		</table>
		</form>
<?php
	}else{
		print('No vaccination centers added');
	}
?>
<br><a href="signout.php">Sign out</a>
</body>
</html>
