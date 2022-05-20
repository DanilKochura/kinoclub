<?php 
	session_start();
	require '../config/bd.php';
	$id=$_POST['name'];
	$val = "SELECT COUNT(*) as co FROM director WHERE name_d='$id'";
	$increment = "SELECT id_d from director order by id_d desc limit 1";
	$increment = mysqli_query($conn, $increment);
	$i = mysqli_fetch_assoc($increment);
	$num = $i['id_d']+1;
	$query = "INSERT INTO director values('$num', '$id')";
	$test = mysqli_query($conn, $val);
	$test = mysqli_fetch_assoc($test);
	if($test['co']==0)
	{
		$id=mysqli_query($conn, $query);
		if(!$id){$_SESSION['message']['director']="Erorr";}

	}
	header('Location: ../admin.php');

?>