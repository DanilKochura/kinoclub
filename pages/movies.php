<?php

require PATH.'/model/movie.php';
//echo '2';
$m = new Movie((int)$_GET[0]);
//echo '2';



?>

<div class="row">
    <div class="col-sm-2">
        <img src="<?=$m->poster?>" alt="" class="img-fluid">
    </div>
    <div class="col-sm-5">
        dfdf
        <div class="row"><?=$m->name?></div>
        <div class="row"><?=$m->original?></div>
        <div class="row"><?=$m->director?></div>
        <div class="row"><?=$m->year?></div>
        <div class="row"><?=$m->rating?></div>
    </div>
</div>
