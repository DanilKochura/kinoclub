<?php
//session_start();
ini_set('display_errors', false);
error_reporting(0);
session_start();

//include '../../model/PostBase.php';
//require '../../model/Rate.php';
//require '../../model/User.php';
require '../model/loader.php';
//$arr = array(
//    'state'=>0,
//    'text' =>'Ошибка!'
//);
//echo json_encode($arr);
//exit;
//file_put_contents(__DIR__.'/0.txt', print_r($_GET, 1));

if(!$_GET['movie'])
{
    $arr = array(
        'state'=>0,
        'text' =>'Фильм не выбран!'
    );
    echo json_encode($arr);
    exit;
}
if(!$_GET['rating'])
{
    $arr = array(
        'state'=>0,
        'text' =>'Оценка не выбрана!'
    );
    echo json_encode($arr);
    exit;
}


$rate = $_GET['rating'];
$meet = $_GET['movie'];
$token = $_GET['token'];
$db = new DB();
$res = $db->Query_try("SELECT id_e from expert where token = '$token'");
if($res->num_rows > 0)
{

    $id = $res->fetch_assoc()['id_e'];
    $user = new User($id);

} else {
    http_response_code(401);
    $arr = array(
        'state'=>0,
        'text' =>'Пользователь не найден!'
    );
    echo json_encode($arr);
}


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