<?php

ini_set('display_errors', false);
error_reporting(0);
/*
 * let url = 'https://kinopoiskapiunofficial.tech/api/v2.2/films/'+$('#movie_input').val();
	fetch(url, {
		method: 'GET',
		headers: {
			'X-API-KEY': 'f71d6402-9cb4-4201-bfd5-e1f1536b0605',
			'Content-Type': 'application/json',
		},
	})
 */
////
//ini_set('display_errors', true);
//error_reporting(E_ALL);
//require '../config/bd.php';
require '../model/PostBase.php';
file_put_contents(__DIR__.'/0.txt', print_r($_POST, 1), FILE_APPEND);

$db = new DB();
$base = new PostBase();

$films = [$_POST['movies0'],$_POST['movies1'],$_POST['movies2']];

$url  = '';
$resp = [

];
$token = $_POST['token'];
$res = $db->Query_try("SELECT id_e from expert where token = '$token'");
if($res->num_rows > 0)
{

    $id = $res->fetch_assoc()['id_e'];


} else {
    http_response_code(401);
    die('Не удалось авторизоваться!');
}



foreach ($films as $film)
{
    $film = explode('/', $film)[4];

    $opts = array(
        'http'=>array(
            'method'=>"GET",
            'header'=>"X-API-KEY: f71d6402-9cb4-4201-bfd5-e1f1536b0605"
        )
    );

    $context = stream_context_create($opts);
// Open the file using the HTTP headers set above
    $file = file_get_contents('https://kinopoiskapiunofficial.tech/api/v2.2/films/'.$film, false, $context);
//$fp = fopen('https://kinopoiskapiunofficial.tech/api/v2.2/films/'.$id, 'r', true, $context);
    $json = json_decode($file, true);

//echo '<pre>';
//print_r($json);
//echo '</pre>';
//die();
    $descr = $json['description'];
    $length = $json['filmLength'];
    $name = $json['nameRu'];
    $origin = $json['nameOriginal'] ?: ($json['nameEn'] ?: ' ');
    $genres = $json['genres'];
    $imdb = $json['ratingImdb'];
    $kp = $json['ratingKinopoisk'];
    $poster = $json['posterUrl'];
    $url = $json['webUrl'];
    $director = $json['director'];
    $year = $json['year'];
//$p = PATH;
    $path = '../';
    $root = 'https://imdibil.ru/';
    $name_f= $origin;
    if($origin != ' ')
    {
        $name_f = uniqid();
        file_put_contents(__DIR__.'/0.txt', $name_f.' '.$origin.PHP_EOL, 8);

    }
    $local = 'image/'.$name_f.'.jpg';
    $test = $db->Query_try("SELECT * from movie where name_m = '$name' and year_of_cr = '$year'");
    if($test->num_rows > 0)
    {
        $test = $test->fetch_assoc();
        $resp[] = $test['id_m']; continue;
    }
    $query = "SELECT id_d from director where name_d = '$director'";
    $res_d = $db->Query_try($query);
    if($res_d->num_rows > 0)
    {
        $id_dir = ($res_d->fetch_assoc())['id_d'];
    }
    else{
        $increment = "SELECT id_d from director order by id_d desc limit 1";
        $inc = $db->Query_try($increment);
        $inc = $inc->fetch_assoc();
        $id_dir = (int)$inc['id_d']  + 1;
        $query = "INSERT into director(id_d, name_d) values('$id_dir','$director')";
        $res_new_d = $db->Query_try($query);
    }
    $increment = "SELECT id_m from movie order by id_m desc limit 1";
    $increment = $db->Query_try($increment);
    $increment = mysqli_fetch_assoc($increment);
    $id_m = $increment['id_m']+1;
    $p = file_put_contents($path.$local, file_get_contents($poster)) ? $root.$local : $poster;
    $query = "INSERT INTO `movie`(`id_m`,`name_m`, `rating`, `rating_kp`, `year_of_cr`, 
                    `duration`, `director`, `our_rate`, `original`, `poster`, `url`, 
                    `description`) VALUES ('$id_m','$name', '$imdb', '$kp', '$year', '$length', '$id_dir', null, '$origin', '$p', '$url', '$descr')";
    $db->Query_try($query);



    foreach ($genres as $genre)
    {
        $query = "SELECT id_g from genre where name_g= '$genre'";
        file_put_contents(__DIR__.'/0.txt', $query.PHP_EOL, FILE_APPEND);
        $res_g = $db->Query_try($query);
        if($res_g->num_rows > 0)
        {

            $gen = ($res_g->fetch_assoc())['id_g'];
//        $db->Query_try("INSERT into gen_to_mov(id_g, id_m) values('$gen', '$id_m')");
            $q = "INSERT INTO `gen_to_mov` (`id_s`, `id_g`, `id_m`) VALUES (NULL, '$gen', '$id_m')";
            $d = $db->Query_try($q);
//        file_put_contents(__DIR__.'/0.txt', $q.PHP_EOL, FILE_APPEND);

        }

    }
    $resp[] = $id_m;

}

if (count(array_unique($resp)) != 3)
{
    http_response_code(401);
    die('Произошла ошибка
    !');
}
$base->AddThird($resp[0], $resp[1], $resp[2], $id);
echo 'Тройка отправлена на модерацию!';

