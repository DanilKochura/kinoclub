<?php
ini_set('display_errors', false);
error_reporting(0);
require '../config/bd.php';
file_put_contents(__DIR__.'/0.txt', print_r($_GET, 1), FILE_APPEND);

$password = $_GET['password'];
$login = $_GET['login'];

$db = new DB();


$res = $db->Query_try("SELECT * from expert where login = '$login'");
if($res->num_rows > 0)
{
    $row = $res->fetch_assoc();
    if(md5($password) == $row['password'])
    {
        die($row['token']);

    }else {
        http_response_code(401);
        die('no!');
    }
} else {
    http_response_code(401);
    die('no!');
}




