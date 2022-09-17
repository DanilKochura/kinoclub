<?php
session_start();

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
    <link rel="stylesheet" href="<?=ROOT?>/styles/bootstrap.min.css">
      <?php if($routed_file=='profile.php'): ?>
          <link href="<?=ROOT?>/styles/slick.css" type="text/css" rel="stylesheet"/>
          <link href="<?=ROOT?>/styles/slick-theme.css" type="text/css" rel="stylesheet"/>

      <?php endif; ?>

    <link href="<?=ROOT?>/styles/stylesheet.css" type="text/css" rel="stylesheet"/>

    <title>IMDibil</title>
		<link rel="shortcut icon" href="<?=ROOT?>/image/favicon.ico" type="image/x-icon">

  </head>
  <body>
  	<header class="p-3 text-white">
	    <div class="container">
            <nav class="navbar navbar-expand-md navbar-dark" aria-label="Fourth navbar example">
                <div class="container-fluid">
                    <a href="/" class="d-flex align-items-center mb-lg-0 text-white text-decoration-none">
                        <img src="<?=ROOT?>/image/logogo.png" class="logo" id="lgg">
                    </a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsExample04" aria-controls="navbarsExample04" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarsExample04">
                        <ul class="navbar-nav me-auto mb-2 mb-md-0 fs-5">
                            <li><a href="/" class="nav-link px-2 text-white">Главная</a></li>
                            <li><a href="/statistics" class="nav-link px-2 text-white">Аналитика</a></li>
                            <li><a href="/news" class="nav-link px-2 text-white">Новости</a></li>
                            <li><a href="/feedback" class="nav-link px-2 text-white">Форум</a></li>
                            <li><a href="/game" class="nav-link px-2 text-white">Викторина</a></li>
                            <li><a href="/special" class="nav-link px-2 text-white">3 сезон</a></li>
                        </ul>
                    </div>
<!--                    <div class="text-end">-->
<!--                        <button type="button" onclick="document.location='pages/login.php'" class="btn btn-outline-light me-2">Профиль</button>-->
<!--                    </div>-->
                    <div class="text-end">
                        <div class="dropdown dropstart">
                            <div class="bi bi-person-circle"  data-bs-toggle="dropdown" aria-expanded="false">
                            <?php if(isset($_SESSION['user']['avatar'])): ?>
                                <img  src="<?=ROOT?>/uploads/<?=$_SESSION['user']['avatar']?>" alt="Ваня" class="avatar header">
                            <?php else: ?>
                                <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="currentColor"  viewBox="0 0 16 16">
                                    <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/>
                                    <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z"/>
                                </svg>

                            <?php endif; ?>
                            </div>

                            <ul class="dropdown-menu forum-card bg-gradient" aria-labelledby="dropdownMenuButton1">
                                <?php if(!$_SESSION['user']): ?>
                                    <li><a class="text-decoration-none text-white" href="/login">Вход</a></li>
                                <?php endif; ?>
                                <li><a class="text-decoration-none text-white" href="/profile">Профиль</a></li>
                                <?php if($_SESSION['user']): ?>
                                    <li><a class="text-decoration-none text-white" href="/logout">Выход</a></li>
                                <?php endif; ?>
                            </ul>
                        </div>

                    </div>
                </div>
            </nav>
	    </div>
  	</header>