<?php 
require 'model/getbase.php';

$m = new GetBase();
$arr = $m->GetAllRates();


echo json_encode($arr);