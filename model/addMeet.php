<?php 
	require '../config/bd.php';
	$id=$_POST['film'];
	$q = "INSERT INTO meeting values(NULL, '$id')";
	$q = mysqli_query($conn, $q);
	header('Location: admin.php');
?>