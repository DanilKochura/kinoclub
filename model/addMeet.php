<?php 
	/*$id=$_POST['film'];
	$db = new DB();
	$q = "INSERT INTO meeting values(NULL, '$id')";
	$q = $db->Query_try($q);
	header('Location: admin.php');*/
	session_start();
	require '../model/PostBase.php';
	$base = new PostBase();

	if($_GET['type']=="meet")
	{
		$base->AddMeet();
	}
	else if($_GET['type']=="dir")
	{
		$base->AddDirector();
	}
?>