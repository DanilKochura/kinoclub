<?php 
	session_start();
	require '../model/PostBase.php';
	$base = new PostBase();

	switch ($_GET['type']) {
    case "meet":
        $base->AddMeet();
        break;
    case "dir":
        $base->AddDirector();
        break;
    case "mov":
        $base->AddMovie();
        break;
    case "install":
        $base->AddParseFile();
        break;
        case "third":
            $base->AddThird();
                break;
        case "rates":
            $base->NewRates();
            break;

    }