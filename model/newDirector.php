<?php 
	session_start();
	require '../model/PostBase.php';
	/*$id=$_POST['name'];
	$db = new DB();
	$val = "SELECT COUNT(*) as co FROM director WHERE name_d='$id'";
	$increment = "SELECT id_d from director order by id_d desc limit 1";
	$increment = $db->Query_try($increment);
	$i = mysqli_fetch_assoc($increment);
	$num = $i['id_d']+1;
	$query = "INSERT INTO director values('$num', '$id')";
	$test = $db->Query_try($val);
	$test = mysqli_fetch_assoc($test);
	if($test['co']==0)
	{
		$id=$db->Query_try($query);
		if(!$id){$_SESSION['message']['director']="Erorr";}

	}
	header('Location: ../admin.php?name='.$id);*/
	$base = new PostBase();
	$base->AddDirector();

?>