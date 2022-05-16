<?php
	require_once '../config/bd.php';
	session_start();

	print_r($_POST);
	if(!$_POST['name'])
	{
		$name = $_SESSION['user']['name'];
	}
	else 
	{
		$name = $_POST['name'];
	}
	$id = $_SESSION['user']['id'];
    $path = $_SESSION['user']['login'].".jpg";
        if (!move_uploaded_file($_FILES['avatar']['tmp_name'], "../uploads/".$path)) {
            $_SESSION['message'] = $path;
            header('Location: ../profile.php');
        }
        $query = "UPDATE `expert` set `avatar` = '$path', `name`= '$name' where `id_e` = '$id';";
        $d = mysqli_query($conn, $query);
        if(!$d) {die("TI SUKA TUPOY CHTOLE");}
        $_SESSION['user']['avatar'] = $path;
        $_SESSION['user']['name'] = $name;
        header('Location: ../profile.php?id='.$id);
