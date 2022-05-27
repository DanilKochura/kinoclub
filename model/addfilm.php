<?php
	require_once '../config/bd.php';
	session_start();
	$db = new DB();
	$name = $_POST['name']; 
	$or = $_POST['original']; 
	$dir = $_POST['director']; 
	$ye = $_POST['year']; 
	$dur = $_POST['duration']; 
	$url = $_POST['url']; 
	$kp = $_POST['kinopoisk']; 
	$imdb = $_POST['imdb']; 
	$file = $_POST['file'];
	$descr = $_POST['descr'];
	echo $file;
    $path = "image/".$or.".jpg";
        if (!move_uploaded_file($_FILES['avatar']['tmp_name'], "../".$path)) {
        		error_log("d");
        }
    $increment = "SELECT id_m from movie order by id_m desc limit 1";
    $increment = $db->Query_try($increment);
    $increment = mysqli_fetch_assoc($increment);
    $i = $increment['id_m']+1;

    $query = "INSERT INTO `movie` (`id_m`, `name_m`, `rating`, `rating_kp`, `year_of_cr`, `duration`, `director`, `our_rate`, `original`, `poster`, `url`, `description`) VALUES ('$i', '$name', '$imdb', '$kp', '$ye', '$dur', '$dir', NULL, '$or', '$path', '$url', '$descr')";
    $d = $db->Query_try($query);
    if(!$d) {die("TI SUKA TUPOY CHTOLE");}
    foreach($_POST['check'] as $gen)
    {
    	$q = "INSERT INTO `gen_to_mov` (`id_s`, `id_g`, `id_m`) VALUES (NULL, '$gen', '$i')";
    	$d = $db->Query_try($q);
	}
	unlink('../parser/pages/'.$name.'.html');
    header('Location: ../admin.php');

?>