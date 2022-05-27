<?php 
	session_start();
	require_once '../config/bd.php';
	print_r($_POST);
	$db = new DB();
	$meet = $_POST['movie'];
	$rate = $_POST['rate'];
	$id = $_SESSION['user']['id'];
	$query = "INSERT INTO `expert_rate`(`id_rate`, `id_meet`, `id_exp`, `rate`) VALUES(NULL, '$meet', '$id', '$rate')";

	$d = $db->Query_try($query);
	if(!$d) {die("Query Error!");}
	header("Location: ../profile.php?id=".$_SESSION['user']['id']);
?>