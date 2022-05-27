<?php
	session_start();
    require_once '../config/bd.php';
    $db = new DB();
    $login = $_POST['login'];
    $password = md5($_POST['password']);
    echo $login.$password;
    $query = "SELECT * FROM `expert` WHERE `login` = '$login' AND `password` = '$password'";
    $check_user = $db->Query_try($query);
    if (mysqli_num_rows($check_user) > 0) {

        $user = mysqli_fetch_assoc($check_user);

        $_SESSION['user'] = [
            "id" => $user['id_e'],
            "name" => $user['name'],
            "login" => $user['login'],
            "avatar"=> $user['avatar']
        ];

        header('Location: ../profile.php?id='.$_SESSION['user']['id']);
    } else {
        $_SESSION['message'] = 'Неверный логин или пароль';
        header('Location: ../pages/login.php');
        print_r($check_user);
    }

?>