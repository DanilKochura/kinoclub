<?php
include '../../model/PostBase.php';
$base = new PostBase();

$id = $_POST['id'];

$base->DeleteThird($id);
echo json_encode(array('state'=>1,'text'=>'Тройка успешно удалена!'));
