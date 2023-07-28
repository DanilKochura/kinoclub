<?php
ini_set('display_errors', false);
error_reporting(0);


require '../model/GetBase.php';
$base = new DB();



$base = new GetBase();
//$meetings= $base->GetAllMovies($sort, $order);
$meetings= $base->GetAllThirdsMobile();

echo json_encode(['data' => $meetings]);