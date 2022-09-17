<?php
include '../../model/PostBase.php';
$base = new PostBase();

$id = $_POST['id'];
if($_GET['type'] == 'pair')
{
    $base->DeletePair($id);
    echo json_encode(array('state'=>1,'text'=>'Пара успешно удалена!'));
}
elseif($_GET['type'] == 'third')
{
    $base->DeleteThird($id);
    echo json_encode(array('state'=>1,'text'=>'Тройка успешно удалена!'));
}

