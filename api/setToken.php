<?php

require '../config/bd.php';

file_put_contents(__DIR__.'/0.txt', print_r($_GET, 1), FILE_APPEND);

$access = $_GET['access'];
$token = $_GET['token'];

$db = new DB();

$user = 0;
if($access)
{
    $res = $db->Query_try("SELECT * from expert where token = '$access'");
    $user = $res->fetch_assoc()['id_e'];
}
$res = $db->Query_try("SELECT * from tokens where token = '$token'");
if($res->num_rows > 0)
{
    $res = $db->Query_try("UPDATE `tokens` SET `user`= '$user' where token = '$token'");
}else
{
    file_put_contents(__DIR__.'/0.txt', $db->affected(), FILE_APPEND);
    $res = $db->Query_try("INSERT INTO `tokens`(`token`, `user`) VALUES ('$token', '$user')");
}



echo "fssg";

