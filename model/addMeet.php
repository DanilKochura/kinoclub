<?php 
	require '../config/bd.php';
	$id=$_POST['film'];
	$db = new DB();
	$q = "INSERT INTO meeting values(NULL, '$id')";
	$q = $db->Query_try($q);
	header('Location: admin.php');
?>