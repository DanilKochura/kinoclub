<?php 
	session_start();
	require '../model/AuthBase.php';
	$base = new AuthBase();

	switch ($_GET['type']) 
	{
    case "log":
        $base->Login();
        break;
    case "sign":
        $base->Signup();
        break;
    }