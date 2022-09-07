<?php
$text = $_POST['text'];

require '../../config/bd.php';
$db = new DB();
$res = $db->Query_try('SELECT name_m, id_m from movie where name_m like "%'.$text.'%" limit 10');
$data = array();

while($row = $res->fetch_assoc())
{
    $data[] = $row;
}

echo(json_encode($data));