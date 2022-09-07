<?php

session_start();

include '../../model/PostBase.php';

$base = new PostBase();
//print_r($_POST);

if(count($_POST['film'])!=3)
{
    echo json_encode(array('state'=>0,'text'=>'Выберите три фильма'));
    exit;
}
$user = $_SESSION['user']['id'];
$f1 = $_POST['film'][0];
$f2 = $_POST['film'][1];
$f3 = $_POST['film'][2];

$base->AddThird($f1, $f2, $f3, $user);
echo json_encode(array('state'=>1, 'text'=>'Тройка сохранена и отправлена на модерацию. После проверки, она появится в разделе новости'));