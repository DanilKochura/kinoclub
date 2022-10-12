<?php
//require PATH.'/config/bd.php';

class Movie extends DB
{
    public string $name;
    public string $original;
    public string $poster;
    public string $description;
    public int $year;
    public float $rating;
    public float $imdb;
    public int $duration;
    public string $director;
    public string $url;
    public function __construct($id)
    {
        parent::__construct();
        $q = "SELECT * from movie join director on director=id_d where id_m='$id'";
//        echo $q;
        $r = $this->Query_try($q);
//        print_r($r);
        $res = mysqli_fetch_assoc($r);
//        print_r($res);
        $this->name = $res['name_m'];
        $this->original = $res['original'];
        $this->poster = $res['poster'];
        $this->year = $res['year_of_cr'];
        $this->description = $res['description'];
        $this->rating = $res['rating_kp'];
        $this->imdb = $res['rating'];
        $this->duration = $res['duration'];
        $this->url = $res['url'];
        $this->director = $res['name_d'];
    }
    public function movie_debug()
    {
        echo $this->poster.PHP_EOL;
    }
}