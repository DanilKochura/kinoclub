<?php
	require_once '../config/bd.php';
	session_start();
	$db = new DB();
	print_r($_POST);
	if(!$_POST['name'])
	{
		$name = $_SESSION['user']['name'];
	}
	else 
	{
		$name = $_POST['name'];
	}
	if(!$_POST['old-pass'])
		{
			header('Location: ../profile.php?id='.$id);
		}
	$id = $_SESSION['user']['id'];
	$q = "SELECT password from expert where id_e ='$id'";
	$pw = $db->Query_try($q);
	$pw = mysqli_fetch_assoc($pw);

	if($pw['password']!=md5($_POST['old-pass']))
		{
			header('Location: ../profile.php?id='.$id);
		}
	$pass = $pw['password'];
	echo $pass;
	if(isset($_POST['new-pass']))
	{
		if($_POST['new-pass']==$_POST['new-pass-confirm'])
		{
			$pass = md5($_POST['new-pass']);
		}
		else
		{
			header('Location: ../profile.php?id='.$id);
		}
	}
	
	print_r($_FILES['avatar']);
    $path = $_SESSION['user']['login'].".jpg";
        if (!move_uploaded_file($_FILES['avatar']['tmp_name'], "../uploads/".$path)) {
            $_SESSION['message'] = $path;
            header('Location: ../profile.php');
        }
        $query = "UPDATE `expert` set `avatar` = '$path', `name`= '$name', `password` = '$pass' where `id_e` = '$id';";
        $d = $db->Query_try($query);
        if(!$d) {die("TI SUKA TUPOY CHTOLE");}
        $_SESSION['user']['avatar'] = $path;
        $_SESSION['user']['name'] = $name;
        header('Location: ../profile.php?id='.$id);
?>
