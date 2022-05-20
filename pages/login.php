<?php
session_start();
if(isset($_SESSION['user']))
{

	header("Location: ../profile.php?id=".$_SESSION['user']['id']);
}?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Авторизация и регистрация</title>
    <link rel="stylesheet" href="..\styles\log.css">
    <link rel="stylesheet" href="..\styles\bootstrap.min.css">
</head>
<body>
<!-- Форма авторизации -->
    <main class="form-signin">
      <form action="../model/log.php" method="post" >
        <img class="mb-4" src="../image/logogo.png" alt="" width="300" height="100">
        <h1 class="h3 mb-3 fw-normal text-center">Вход</h1>

        <div class="form-floating">
          <input input type="text" name="login" placeholder="Введите свой логин" class="form-control" id="floatingInput">
          <label for="floatingInput">Логин</label>
        </div>
        <div class="form-floating">
          <input type="password" name="password" placeholder="Введите пароль" class="form-control" id="floatingPassword">
          <label for="floatingPassword">Password</label>
        </div>
        <button class="w-100 btn btn-lg btn-warning" type="submit">Sign in</button>
        <p>
            У вас нет аккаунта? - <a href="register.php">зарегистрируйтесь</a>!
        </p>
      </form>
      <?php if(isset($_SESSION['message'])){
        echo $_SESSION['message'];
        unset($_SESSION['message']);
      }?>
    </main>
   <!-- <form action="../path/log.php" method="post">
        <label>Логин</label>
        <input type="text" name="login" placeholder="Введите свой логин">
        <label>Пароль</label>
        <input type="password" name="password" placeholder="Введите пароль">
        <button type="submit">Войти</button>
        <p>
            У вас нет аккаунта? - <a href="register.php">зарегистрируйтесь</a>!
        </p>
    </form>-->

</body>
</html>