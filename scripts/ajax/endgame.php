<?php

session_start();
$types = ['tour' => 1, 'mount' => 2];
include '../../model/PostBase.php';

$type = $_POST['mode'];

$id_m = json_decode($_POST['game'], true)[3][0]['id'];

$id_u = $_SESSION['user']['id'];

$base = new PostBase();

$base->QuizResult($types[$type], $id_u, $id_m);

