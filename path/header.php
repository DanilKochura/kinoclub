<?php
$uri = $_SERVER['REQUEST_URI'];

$uri = explode('/',(explode('?', $uri))[0])[1];
?>

<!DOCTYPE html>
<html lang="ru">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <meta name="description" content="Информационный портал киноклуба">
      <meta name="yandex-verification" content="242eb7336dec418c" />
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="styles/bootstrap.min.css">
      <?php if($uri=='profile.php'): ?>
          <link href="styles/slick.css" type="text/css" rel="stylesheet"/>
          <link href="styles/slick-theme.css" type="text/css" rel="stylesheet"/>

      <?php endif; ?>

    <link href="styles/stylesheet.css" type="text/css" rel="stylesheet"/>

    <title>IMDibil</title>
		<link rel="shortcut icon" href="image/favicon.ico" type="image/x-icon">

  </head>
  <body>
  	<header class="p-3 text-white">
	    <div class="container">
            <nav class="navbar navbar-expand-md navbar-dark" aria-label="Fourth navbar example">
                <div class="container-fluid">
                    <a href="/" class="d-flex align-items-center mb-lg-0 text-white text-decoration-none">
                        <img src="image\logogo.png" class="logo" id="lgg">
                    </a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsExample04" aria-controls="navbarsExample04" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarsExample04">
                        <ul class="navbar-nav me-auto mb-2 mb-md-0">
                            <li><a href="index.php" class="nav-link px-2 text-secondary">Главная</a></li>
                            <li><a href="statistics.php" class="nav-link px-2 text-white">Статистка (демо)</a></li>
                            <li><a href="news.php" class="nav-link px-2 text-white">Новости</a></li>
                            <li><a href="feedback.php?type=advice&page=1" class="nav-link px-2 text-white">Форум</a></li>
                            <li><a href="#" class="nav-link px-2 text-white">Викторина</a></li>
                        </ul>
                    </div>
                    <div class="text-end">
                        <button type="button" onclick="document.location='pages/login.php'" class="btn btn-outline-light me-2">Профиль</button>
                    </div>
                </div>
            </nav>
	    </div>
  	</header>