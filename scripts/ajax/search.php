<?php
$text = $_POST['text'];

require '../../config/bd.php';
$db = new DB();
$res = $db->Query_try('SELECT name_m, id_m from movie where name_m like "%'.$text.'%"');
$data = array();

while($row = $res->fetch_assoc())
{
    $data[] = $row;
}

print_r(json_encode($data));