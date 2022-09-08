<?php
session_start();

include '../../model/PostBase.php';

$base = new PostBase();


$id_ev = $_POST['id_event'];
$id_e = $_SESSION['user']['id'];
$id_m = $_POST['id_m'];

$base->Vote($id_ev, $id_m, $id_e);
echo json_encode(array('state'=>1, 'text'=>'Голос сохранен!'));