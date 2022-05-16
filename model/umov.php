<?php
	session_start();
	$id = $_SESSION['user']['id'];
	require '../config/bd.php';

$query = "select name_m, id_m from movie join meeting using(id_m) left join (select * from expert_rate where id_exp = '$id') as e using(id_meet) where id_rate is NULL;";
$res = mysqli_query($conn, $query);
while($r = mysqli_fetch_assoc($res))
{
	print_r($r);
}

	
?>