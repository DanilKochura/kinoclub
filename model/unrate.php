<?php 
	session_start();
	require '../config/bd.php';
	$db = new DB();
	$id=$_SESSION['user']['id'];
	if(!isset($_GET['id'])){header('Location: ../profile.php?id='.$id);}
	$id_m = $_GET['id'];

	$query = "DELETE FROM `expert_rate` where `id_meet` = '$id_m' and `id_exp` = '$id'";
	$res = $db->Query_try($query);
	if(!$res)
	{
		echo "Fatal error";
	} else
	{
		header('Location: ../profile.php?id='.$id);
	}
?>