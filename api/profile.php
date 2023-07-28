<?php
ini_set('display_errors', false);
error_reporting(0);
require '../model/GetBase.php';
require '../model/User.php';

$token = $_GET['token'];

$base = new GetBase();


$db = new DB();
$res = $db->Query_try("SELECT id_e from expert where token = '$token'");
if($res->num_rows > 0)
{

    $id = $res->fetch_assoc()['id_e'];
    $count = $db->Query_try("SELECT count(*) as co from meeting")->fetch_assoc()['co'];

    $user = new User($id);
    $user->allFilms = [];
    echo json_encode(['data'=>$user, 'count' => $count]);

} else {
    http_response_code(401);
    die('no!');
}




