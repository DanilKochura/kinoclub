<?php
session_start();

?>

<!DOCTYPE html>
<html lang="ru">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <meta name="description" content="Информационный портал киноклуба МГТУ им. Баумана">
      <meta name="yandex-verification" content="242eb7336dec418c" />

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="<?=ROOT?>/scheduler/assets/css/vendor_bundle.min.css">
      <link rel="stylesheet" href="<?=ROOT?>/scheduler/assets/css/vendor.datatables.css">
      <link rel="stylesheet" href="<?=ROOT?>/scheduler/assets/css/vendor.fancybox.min.css">
      <link rel="stylesheet" href="<?=ROOT?>/scheduler/assets/css/core.min.css">

      <?php if($routed_file=='profile.php'): ?>
          <link href="<?=ROOT?>/styles/slick.css" type="text/css" rel="stylesheet"/>
          <link href="<?=ROOT?>/styles/slick-theme.css" type="text/css" rel="stylesheet"/>

      <?php endif; ?>

    <link href="<?=ROOT?>/styles/stylesheet.css" type="text/css" rel="stylesheet"/>

    <title>IMDibil</title>
		<link rel="shortcut icon" href="<?=ROOT?>/image/favicon.ico" type="image/x-icon">
    <style>
        * {
            box-sizing: border-box;
        }
        body {
            background-color: #00350e;
        }
        canvas {
            z-index: -1;
            height: 100vh;
            width: 100vw;
            -webkit-filter: blur(2px);
            filter: blur(2px);
            position: absolute;
        }


        .lightrope {
            text-align: center;
            white-space: nowrap;
            overflow: hidden;
            position: absolute;
            z-index: 1;
            /*margin: -15px 0 0 0;*/
            padding: 0;
            top: 70px;
            pointer-events: none;
            width: 100%;
        }

        .lightrope li {
            position: relative;
            animation-fill-mode: both;
            animation-iteration-count: infinite;
            list-style: none;
            margin: 0;
            padding: 0;
            display: block;
            width: 12px;
            height: 28px;
            border-radius: 50%;
            margin: 20px;
            display: inline-block;
            background: #00f7a5;
            box-shadow: 0px 4.66667px 24px 3px #00f7a5;
            animation-name: flash-1;
            animation-duration: 2s;
        }

        .lightrope li:nth-child(2n+1) {
            background: cyan;
            box-shadow: 0px 4.66667px 24px 3px rgba(0, 255, 255, 0.5);
            animation-name: flash-2;
            animation-duration: 0.4s;
        }

        .lightrope li:nth-child(4n+2) {
            background: #f70094;
            box-shadow: 0px 4.66667px 24px 3px #f70094;
            animation-name: flash-3;
            animation-duration: 1.1s;
        }

        .lightrope li:nth-child(odd) {
            animation-duration: 1.8s;
        }

        .lightrope li:nth-child(3n+1) {
            animation-duration: 1.4s;
        }

        .lightrope li:before {
            content: "";
            position: absolute;
            background: #222;
            width: 10px;
            height: 9.33333px;
            border-radius: 3px;
            top: -4.66667px;
            left: 1px;
        }

        .lightrope li:after {
            content: "";
            top: -14px;
            left: 9px;
            position: absolute;
            width: 52px;
            height: 18.66667px;
            border-bottom: solid #222 2px;
            border-radius: 50%;
        }

        .lightrope li:last-child:after {
            content: none;
        }

        .lightrope li:first-child {
            margin-left: -40px;
        }
        
        @media (max-width: 900px) {
            .lightrope {
                top: 52px;
            }
        }

        @keyframes flash-1 {
            0%, 100% {
                background: #f70000;
                box-shadow: 0px 4.66667px 24px 3px #f70000;
            }

            50% {
                background: rgba(153, 3, 2, 0.4);
                box-shadow: 0px 4.66667px 24px 3px rgba(156, 2, 2, 0.2);
            }
        }

        @keyframes flash-2 {
            0%, 100% {
                background: white;
                box-shadow: 0px 4.66667px 24px 3px white;
            }

            50% {
                background: rgba(225, 225, 225, 0.4);
                box-shadow: 0px 4.66667px 24px 3px rgba(225, 225, 225, 0.2);
            }
        }

        @keyframes flash-3 {
            0%, 100% {
                background: #f6c700;
                box-shadow: 0px 4.66667px 24px 3px #f6c700d6;
            }

            50% {
                background: #f6c7008f;
                box-shadow: 0px 4.66667px 24px 3px #f6c70073;
            }
        }
    </style>
  </head>
  <body class="header-sticky header-fixed">
  <ul class="lightrope">
      <li></li>
      <li></li>
      <li></li>
      <li></li>
      <li></li>
      <li></li>
      <li></li>
      <li></li>
      <li></li>
      <li></li>
      <li></li>
      <li></li>
      <li></li>
      <li></li>
      <li></li>
      <li></li>
      <li></li>
      <li></li>
      <li></li>
      <li></li>
      <li></li>
      <li></li>
      <li></li>
      <li></li>
      <li></li>
      <li></li>
      <li></li>
      <li></li>
      <li></li>
      <li></li>
      <li></li>
      <li></li>
      <li></li>
      <li></li>
      <li></li>
      <li></li>
      <li></li>
      <li></li>
      <li></li>
      <li></li>
      <li></li>
      <li></li>
  </ul>
    <header class="p-1 text-white header" >

        <div class="container position-relative">
            <nav class="navbar navbar-expand-lg navbar-dark text-white justify-content-lg-between justify-content-md-inherit">

                <div class="align-items-start">

                    <!-- mobile menu button : show -->
                    <button class="navbar-toggler collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMainNav" aria-controls="navbarMainNav" aria-expanded="false" aria-label="Toggle navigation">
                        <svg width="25" viewBox="0 0 20 20">
                            <path fill="#fff" d="M 19.9876 1.998 L -0.0108 1.998 L -0.0108 -0.0019 L 19.9876 -0.0019 L 19.9876 1.998 Z"></path>
                            <path fill="#fff" d="M 19.9876 7.9979 L -0.0108 7.9979 L -0.0108 5.9979 L 19.9876 5.9979 L 19.9876 7.9979 Z"></path>
                            <path fill="#fff" d="M 19.9876 13.9977 L -0.0108 13.9977 L -0.0108 11.9978 L 19.9876 11.9978 L 19.9876 13.9977 Z"></path>
                            <path fill="#fff" d="M 19.9876 19.9976 L -0.0108 19.9976 L -0.0108 17.9976 L 19.9876 17.9976 L 19.9876 19.9976 Z"></path>
                        </svg>
                    </button>

                    <!-- navbar : brand (logo) -->
                    <a class="navbar-brand" href="/">
<!--                        <img src="--><?php //=ROOT?><!--/image/logogo.png" width="110" height="38" alt="..." class="logo-head">-->
                        <img src="<?=ROOT?>/image/newyear.png" width="110" height="38" alt="..." class="logo-head">
                    </a>

                </div>

                <div class="navbar-collapse navbar-animate-fadein collapse" id="navbarMainNav" style="">


                    <!-- navbar : mobile menu -->
                    <div class="navbar-xs d-none"><!-- .sticky-top -->

                        <!-- mobile menu button : close -->
                        <button class="navbar-toggler pt-0 collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMainNav" aria-controls="navbarMainNav" aria-expanded="false" aria-label="Toggle navigation">
                            <svg width="20" viewBox="0 0 20 20">
                                <path d="M 20.7895 0.977 L 19.3752 -0.4364 L 10.081 8.8522 L 0.7869 -0.4364 L -0.6274 0.977 L 8.6668 10.2656 L -0.6274 19.5542 L 0.7869 20.9676 L 10.081 11.679 L 19.3752 20.9676 L 20.7895 19.5542 L 11.4953 10.2656 L 20.7895 0.977 Z"></path>
                            </svg>
                        </button>

                        <!--
                            Mobile Menu Logo
                            Logo : height: 70px max
                        -->
                        <a class="navbar-brand" href="/">
                            <img src="<?=ROOT?>/image/newyear.png" width="110" height="38" alt="...">
<!--                            <img src="--><?php //=ROOT?><!--/image/logogo.png" width="110" height="38" alt="...">-->
                        </a>

                    </div>
                    <!-- /navbar : mobile menu -->



                    <!-- navbar : navigation -->
                    <ul class="navbar-nav">

                        <!-- mobile only image + simple search (d-block d-sm-none) -->
                        <li class="nav-item d-block d-sm-none">





                        </li>


                        <!-- home -->
                        <li class="nav-item active">

                            <a href="/" id="mainNavHome" class="nav-link">
                                Главная
                            </a>

                        </li>


                        <!-- pages -->
                        <li class="nav-item">

                            <a href="/statistics" id="mainNavPages" class="nav-link">
                                Аналитика
                            </a>


                        </li>


                        <!-- features -->
                        <li class="nav-item dropdown">

                            <a href="/news" class="nav-link">Новости</a>


                        </li>


                        <!-- blog -->
                        <li class="nav-item dropdown">

                            <a href="/feedback" class="nav-link">Форум</a>



                        </li>

                        <!-- demos -->
<!--                        <li class="nav-item dropdown active">-->
<!---->
<!--                            <a href="/game" class="nav-link">Викторина</a>-->
<!---->
<!--                        </li>-->

<!--                        <li class="nav-item dropdown">-->
<!---->
<!--                            <a href="/special" class="animate-blink nav-link text-warning">-->
<!--                                5 сезон-->
<!--                            </a>-->
<!---->
<!---->
<!---->
<!--                        </li>-->
                        <li class="nav-item dropdown">

                            <a href="/seasons" class=" nav-link">
                                Статистика по сезонам
                            </a>



                        </li>









                        <!-- social icons : mobile only -->
                        <li class="nav-item d-block d-sm-none text-center mb-4">


                        </li>





                    </ul>
                    <!-- /navbar : navigation -->


                </div>





                <!-- OPTIONS -->
                <ul class="list-inline list-unstyled mb-0 d-flex align-items-end">

                    <li class="list-inline-item mx-1 dropdown">

                        <div class="dropdown dropstart">
                            <div class="bi bi-person-circle"  data-bs-toggle="dropdown" aria-expanded="false">
                                <?php if(isset($_SESSION['user']['avatar'])): ?>
                                    <img  src="<?=ROOT?>/uploads/<?=$_SESSION['user']['avatar']?>" alt="Ваня" class="avatar">
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
                                <?php if($_SESSION['user']): ?>
                                    <li><a class="text-decoration-none text-white" href="/profile">Профиль</a></li>

                                    <li><a class="text-decoration-none text-white" href="/logout">Выход</a></li>
                                <?php endif; ?>
                            </ul>
                        </div>


                        <!--

                            Dropdown Classes
                                .dropdown-menu-dark 		- dark dropdown (desktop only, will be white on mobile)
                                .dropdown-menu-hover 		- open on hover
                                .dropdown-menu-clean 		- no background color on hover
                                .dropdown-menu-invert 		- open dropdown in oposite direction (left|right, according to RTL|LTR)
                                .dropdown-click-ignore 		- keep dropdown open on inside click (useful on forms inside dropdown)

                                Dropdown prefix icon (optional, if enabled in variables.scss)
                                    .prefix-link-icon .prefix-icon-dot 		- link prefix
                                    .prefix-link-icon .prefix-icon-line 	- link prefix
                                    .prefix-link-icon .prefix-icon-ico 		- link prefix
                                    .prefix-link-icon .prefix-icon-arrow 	- link prefix

                                    .prefix-icon-ignore 					- ignore, do not use on a specific link

                        -->


                    </li>



                </ul>
                <!-- /OPTIONS -->



            </nav>
        </div>
        <!-- /Navbar -->

    </header>
