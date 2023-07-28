<?php
//ini_set('display_errors', true);
//error_reporting(E_ALL);
ini_set('display_errors', false);
error_reporting(0);

require '../model/GetBase.php';
$base = new DB();
$res =$base->Query_try("SELECT COUNT(*) from meeting");
$num = mysqli_fetch_array($res);
$num = $num[0];

$show = $_GET['show'] ?: 50;
$page = $_GET['page'] ?: 1;
$sort = $_GET['sort'] ?: 'id_meet';
$order = $_GET['order'] ?: 'desc';

$start = ($page-1)*$show;

$base = new GetBase();
//$meetings= $base->GetAllMovies($sort, $order);
$meetings= $base->GetMoviesMobile($sort, $order, $start, $show);
echo json_encode(['data' => $meetings]);