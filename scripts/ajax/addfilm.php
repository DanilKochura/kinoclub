<?php
require_once '../../config/bd.php';
$db = new DB();
file_put_contents(__DIR__.'/0.txt', print_r($_POST, 1).PHP_EOL);
if(!$_POST['description'] or !$_POST['filmLength']
    or !$_POST['genres'] or !$_POST['nameRu'] or !$_POST['posterUrl']
    or !$_POST['ratingImdb'] or !$_POST['ratingKinopoisk'] or !$_POST['webUrl'] or
    !$_POST['director'] or !$_POST['year'])
{
    echo 'Не все поля заполнены';
    exit;
}
$descr = $_POST['description'];
$length = $_POST['filmLength'];
$name = $_POST['nameRu'];
$origin = $_POST['nameOriginal'] ?: $_POST['nameEn'];
$genres = explode(' ', $_POST['genres']);
$imdb = $_POST['ratingImdb'];
$kp = $_POST['ratingKinopoisk'];
$poster = $_POST['posterUrl'];
$url = $_POST['webUrl'];
$director = $_POST['director'];
$year = $_POST['year'];
$test = $db->Query_try("SELECT * from movie where name_m = '$name' and year_of_cr = '$year'");
if($test->num_rows > 0)
{
    echo 'Этот фильм уже есть в базе';
    exit;
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

$query = "INSERT INTO `movie`(`id_m`,`name_m`, `rating`, `rating_kp`, `year_of_cr`, 
                    `duration`, `director`, `our_rate`, `original`, `poster`, `url`, 
                    `description`) VALUES ('$id_m','$name', '$imdb', '$kp', '$year', '$length', '$id_dir', null, '$origin', '$poster', '$url', '$descr')";
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
echo 'Фильм успешно записан в базу';