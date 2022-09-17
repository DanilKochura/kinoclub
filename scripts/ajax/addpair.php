<?php


session_start();

include '../../model/PostBase.php';

$base = new PostBase();
//print_r($_POST);

if (count($_POST['film']) != 2) {
    echo json_encode(array('state' => 0, 'text' => 'Выберите два фильма'));
    exit;
}
$user = $_SESSION['user']['id'];
$f1 = $_POST['film'][0];
$f2 = $_POST['film'][1];
$event = 'prepare';
$base->AddPair($f1, $f2, $user, $event);
echo json_encode(array('state' => 1, 'text' => 'Пара сохранена и отправлена на модерацию. После проверки, она появится в разделе новости'));