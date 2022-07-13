<?php 
require 'model/GetBase.php';

$db = new GetBase();
$id= $_GET['id'];
$rates = $db->GetMeetRates($id);
//print_r($rates);
$rates = json_encode($rates);

echo $rates;