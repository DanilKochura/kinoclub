<?php
//session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();

//include '../../model/PostBase.php';
//require '../../model/Rate.php';
//require '../../model/User.php';
require '../../model/loader.php';
//$arr = array(
//    'state'=>0,
//    'text' =>'Ошибка!'
//);
//echo json_encode($arr);
//exit;
//file_put_contents(__DIR__.'/0.txt', print_r($_POST, 1));

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
$user = new User($id);

$RateModel = new Rate($rate, $user, $meet);
if(!$user or !$RateModel)
{
    $arr = array(
        'state'=>0,
        'text' =>'Ошибка!'
    );
    echo json_encode($arr);
    exit;
}
//$base->AddRate($rate, $meet, $id);
$arr = $RateModel->save();
echo $arr;
exit;