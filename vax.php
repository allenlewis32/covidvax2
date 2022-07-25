<?php
	session_start();
	if(!isset($_SESSION['uid'])){
		header('Location: index.php');
		exit();
	}
	include_once('db.php');
	if(isset($_POST['toapply'])){
		$cid = $_POST['toapply'];
		$date = $_POST[$cid];
		$sql = "select count(*) as total from vaccination where cid=$cid and date='$date'";
		$res = $conn->query($sql);
		if($res -> num_rows > 0){
			$row = $res -> fetch_assoc();
			if($row['total'] == 10){
				print('<script>alert("Only ten people are allowed per day in a vaccination center. Please apply for another date or center");</script>');
			}else{
				$sql = "insert into vaccination(uid, cid, date) values(".$_SESSION['uid'].", $cid, '$date')";
				if($conn->query($sql)){
					print('<script>alert("Applied successfully");</script>');
				}else{
					print('<script>alert("Unable to apply");</script>');
				}
			}
		}
	}
	$date = new DateTime("now", new DateTimeZone("Asia/Kolkata"));
	$mindate = $date->format('Y-m-d');
	$date->setTimestamp($date->getTimestamp() + 10 * 24 * 60 * 60);
	$maxdate = $date->format('Y-m-d');
?>
<!DOCTYPE html>
<html>
<head>
<title>Vaccination centers</title>
<link rel="stylesheet" href="stylesheet.css">
</head>
<body>
<h1>Vaccination centers</h1>
Welcome <?= $_SESSION['fname']?> <?=$_SESSION['lname']?> <a href='signout.php'>Sign out</a>
<div class='input_block'>
	<form method='post'>
	<table>
	<tr>
	<td><label>Search</label>
	<input type='text' name='name' placeholder='Name'></td>
	<td><label>Location</label>
	<input type='text' name='loc' placeholder='Location'></td>
	<td><br><button type='submit' name='search'>Search</button></td>
	</tr>
	</table>
	</form>
</div>
<?php
	$sql = "select * from vaccenter";
	if(isset($_POST['search'])){
		$name = $_POST['name'];
		$loc = $_POST['loc'];
		$sql .= " where name like '%$name%'";
		$sql .= " and location like '%$loc%'";
	}
	$res = $conn->query($sql);
	if($res -> num_rows > 0){
?>
		<form method='post'>
		<input type='hidden' name='submit'>
		<table border=1>
		<tr>
		<th>Name</th>
		<th>Location</th>
		<th></th>
		<th></th>
		</tr>
<?php
		while($row = $res -> fetch_assoc()){
?>
			<tr>
			<td><?=$row['name']?></td>
			<td><?=$row['location']?></td>
			<td><input type='date' min='<?=$mindate?>' max='<?=$maxdate?>' name='<?=$row["cid"]?>' value='<?=$mindate?>'></td>
			<td><button type='submit' name='toapply' value='<?=$row["cid"]?>'>Apply</td>
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
</body>
</html>
