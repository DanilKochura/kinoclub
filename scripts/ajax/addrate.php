<?php
//session_start();
//ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();
include '../../model/PostBase.php';

file_put_contents(__DIR__.'/0.txt', print_r($_POST, 1));

if(!$_POST['movie'])
{
    $arr = array(
        'state'=>0,
        'text' =>'Фильм не выбран!'
    );
    echo json_encode($arr);
    exit;
}
if(!$_POST['rating'])
{
    $arr = array(
        'state'=>0,
        'text' =>'Оценка не выбрана!'
    );
    echo json_encode($arr);
    exit;
}

$base = new PostBase();

$rate = $_POST['rating'];
$meet = $_POST['movie'];
$id = $_SESSION['user']['id'];
if(!$id)
{
    $arr = array(
        'state'=>0,
        'text' =>'Пользователь не найден'
    );
    echo json_encode($arr);
    exit;
}

$base->AddRate($rate, $meet, $id);
$arr = array(
    'state'=>1,
    'text' =>'Оценка сохранена!'
);
echo json_encode($arr);
exit;