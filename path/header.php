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
	      <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
	        <a href="/" class="d-flex align-items-center mb-2 mb-lg-0 text-white text-decoration-none">
	          <img src="image\logogo.png" class="logo" id="lgg">
	        </a>

	        <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
	          <li><a href="index.php" class="nav-link px-2 text-secondary">Главная</a></li>
	          <li><a href="statistics.php" class="nav-link px-2 text-white">Статистка (демо)</a></li>
	          <li><a href="news.php" class="nav-link px-2 text-white">Новости</a></li>
                <li><a href="feedback.php?type=advice&page=1" class="nav-link px-2 text-white">Форум</a></li>
	          <li><a href="#" class="nav-link px-2 text-white">Викторина</a></li>
	        </ul>

	        <div class="text-end">
	          <button type="button" onclick="document.location='pages/login.php'" class="btn btn-outline-light me-2">Профиль</button>
	          <button type="button" onclick="document.location='pages/login.php'" class="btn btn-warning">Вход</button>
	        </div>
	      </div>
	    </div>
  	</header>