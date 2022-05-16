<?php 
	require_once '../config/bd.php';
	session_start();
	$name = $_POST['full_name'];
    $login = $_POST['login'];
    $email = $_POST['email'];
	if ($_POST['password'] === $_POST['password_confirm']) {
        
        $password = md5($_POST['password']);
        $query = "INSERT INTO `expert` (`id_e`, `name`, `login`, `password`) VALUES (NULL, '$name', '$login', '$password');";
        $d = mysqli_query($conn, $query);
        if(!$d) {die("TI SUKA TUPOY CHTOLE");}

        
        
        $_SESSION['message'] = 'Регистрация прошла успешно!';
        header('Location: ../index.php');


    } else {
        $_SESSION['message'] = 'Пароли не совпадают';
        header('Location: ../model/sign.php');
    }
    
?>