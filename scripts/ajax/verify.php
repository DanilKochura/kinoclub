<?php


require '../../config/bd.php';

$db = new DB();

$code = $db->Query_try("SELECT code from expert where id_e = '{$_POST['id']}'");

if($code->fetch_assoc()['code'] == $_POST['code'])
{
    $db->Query_try("UPDATE expert set verify = 1 where id_e = '{$_POST['id']}'");
    echo json_encode(['state' => 1, 'text' => 'Почта успешно подтверждена!']);

}
else {
    echo json_encode(['state' => 0, 'text' => 'Код неверный']);

}