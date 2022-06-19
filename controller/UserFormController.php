<?php 
session_start();
	require '../model/PostBase.php';
	$base = new PostBase();

	switch ($_GET['type']) {
    case "add":
        $base->AddRate();

        break;
    case "unrate":
        $base->Unrate();
        break;
    case "update":
        $base->UpdateProfile();
        break;

        case "feedback":
            $base->NewMessage();
            break;


    }