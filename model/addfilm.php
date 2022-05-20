<?php
echo "<pre>";
print_r($_POST);
echo "</pre>";

	require_once '../config/bd.php';
	session_start();
	$name = $_POST['name']; 
	$or = $_POST['original']; 
	$dir = $_POST['director']; 
	$ye = $_POST['year']; 
	$dur = $_POST['duration']; 
	$url = $_POST['url']; 
	$kp = $_POST['kinopoisk']; 
	$imdb = $_POST['imdb']; 
	$file = $_POST['file'];
	echo $file;
    $path = "image/".$or.".jpg";
        if (!move_uploaded_file($_FILES['avatar']['tmp_name'], "../".$path)) {
        		error_log("d");
        }
    $increment = "SELECT id_m from movie order by id_m desc limit 1";
    $increment = mysqli_query($conn, $increment);
    $increment = mysqli_fetch_assoc($increment);
    $i = $increment['id_m']+1;

    $query = "INSERT INTO `movie` (`id_m`, `name_m`, `rating`, `rating_kp`, `year_of_cr`, `duration`, `director`, `our_rate`, `original`, `poster`, `url`) VALUES ('$i', '$name', '$imdb', '$kp', '$ye', '$dur', '$dir', NULL, '$or', '$path', '$url')";
    $d = mysqli_query($conn, $query);
    if(!$d) {die("TI SUKA TUPOY CHTOLE");}
    foreach($_POST['check'] as $gen)
    {
    	$q = "INSERT INTO `gen_to_mov` (`id_s`, `id_g`, `id_m`) VALUES (NULL, '$gen', '$i')";
    	$d = mysqli_query($conn, $q);
	}
	unlink('../parser/pages/'.$file.'.html');
    header('Location: ../admin.php');

?>