<?php
	require '../config/bd.php';
	session_start();

	Class AuthBase extends DB 
	{
		function __construct()
		{
			parent::__construct();
		}

		public function Signup()
		{
			$name = $_POST['full_name'];
    		$login = $_POST['login'];
            $logcheck = $this->Query_try("SELECT * from expert where login = '$login'");
            if($logcheck->num_rows != 0)
            {
                $_SESSION['message'] = 'Логин уже занят';
                header('Location: https://imdibil.ru/register');
                die();
            }
//   			$email = $_POST['email'];
			if ($_POST['password'] === $_POST['password_confirm']) {
		        
		        $password = md5($_POST['password']);
		        $query = "INSERT INTO `expert` (`id_e`, `name`, `login`, `password`) VALUES (NULL, '$name', '$login', '$password');";
		        $d = $this->Query_try($query);
		        if(!$d) {die("TI SUKA TUPOY CHTOLE");}

		        
                $_SESSION['user']['id'] = $this->insrtid();
		        $_SESSION['message'] = 'Регистрация прошла успешно!';
		        header('Location: https://imdibil.ru/profile');


		    } 
		    else 
		    {
		        $_SESSION['message'] = 'Пароли не совпадают';
		        header('Location: https://imdibil.ru/register');
		    }   
		}

		public function Login()
		{
			$login = $_POST['login'];
   			$password = md5($_POST['password']);
		    $query = "SELECT * FROM `expert` WHERE `login` = '$login' AND `password` = '$password'";
		    $check_user = $this->Query_try($query);
		    if (mysqli_num_rows($check_user) > 0) {

		        $user = mysqli_fetch_assoc($check_user);

		        $_SESSION['user'] = [
		            "id" => $user['id_e'],
		            "name" => $user['name'],
		            "login" => $user['login'],
		            "avatar"=> $user['avatar']
		        ];

		        header('Location: ../profile');
		    } 
		    else 
		    {
		        $_SESSION['message'] = 'Неверный логин или пароль';
		        header('Location: /login');
		        print_r($check_user);
		    }
				
		}

		function __destruct()
		{
			parent::__destruct();
		}
	}			