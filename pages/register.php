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
      <form action="../model/sign.php" method="post" enctype="multipart/form-data">
        <img class="mb-4" src="../image/logogo.png" alt="" width="300" height="100">
        <h1 class="h3 mb-3 fw-normal text-center">Регистрация</h1>

        <div class="form-floating">
          <input type="text" name="full_name" placeholder="Введите свое полное имя" class="form-control" id="name">
          <label for="name">ФИО</label>
        </div>
        <div class="form-floating">
          <input type="text" name="login" placeholder="Введите свой логин" class="form-control" id="login">
          <label for="login">Логин</label>
        </div>
        <div class="form-floating">
          <input type="email" name="email" placeholder="Введите адрес своей почты" class="form-control" id="email">
          <label for="email">Email</label>
        </div>
        
        <div class="form-floating">
          <input type="password" name="password" placeholder="Введите пароль" class="form-control" id="pw">
          <label for="pw">Пароль</label>
        </div>
        <div class="form-floating">
          <input type="password" name="password_confirm" placeholder="Подтвердите пароль" class="form-control" id="pw2">
          <label for="pw2">Подтверждение пароля</label>
        </div>
        <button class="w-100 btn btn-lg btn-warning" type="submit">Зарегистрироваться</button>
        <p>
            У вас уже есть аккаунт? - <a href="../pages/login.php">авторизируйтесь</a>!
        </p>
      </form>
    </main>

    <!--<form action="sign.php" method="post" enctype="multipart/form-data">
        <label>ФИО</label>
        <input type="text" name="full_name" placeholder="Введите свое полное имя">
        <label>Логин</label>
        <input type="text" name="login" placeholder="Введите свой логин">
        <label>Почта</label>
        <input type="email" name="email" placeholder="Введите адрес своей почты">
        <label>Изображение профиля</label>
        <input >
        <label>Пароль</label>
        <input type="password" name="password" placeholder="Введите пароль">
        <label>Подтверждение пароля</label>
        <input type="password" name="password_confirm" placeholder="Подтвердите пароль">
        <button type="submit">Зарегистрироваться</button>
        <p>
            У вас уже есть аккаунт? - <a href="login.php">авторизируйтесь</a>!
        </p>
    </form>
-->

</body>
</html>