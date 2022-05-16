<?php
require 'config/bd.php';
define('ROOT', dirname(__FILE__));

$meetings= array();
$descr_q = "SELECT id_meet, id_m, name_m, original, year_of_cr, name_d,duration,rating, our_rate,rating_kp, poster from movie
				join director on id_d=director join meeting using(id_m);";
$exp_q = "SELECT id_rate, id_meet, id_exp, avatar, name, rate from expert join expert_rate on id_e=id_exp  order by id_meet, rate desc
;";
$genre_q ="SELECT name_g, id_meet from genre 
						join gen_to_mov using(id_g)
						join meeting using(id_m) order by id_meet;";
$res_d=mysqli_query($conn, $descr_q);
$res_e=mysqli_query($conn, $exp_q);
$res_g=mysqli_query($conn, $genre_q);
while ($movie = mysqli_fetch_assoc($res_d)) {
	//Инициализируем цены]
	$movie['rates']=array();
	$movie['genre']=array();
	$meetings[$movie['id_m']] = $movie;

	
}
$i=0;

while($res = mysqli_fetch_assoc($res_g))
{
	$meetings[$res['id_meet']]['genre'][] = $res['name_g'];
}
$i=0;
while($res = mysqli_fetch_assoc($res_e))
{
	$a = [
		'avatar' => $res['avatar'],
		'name' => $res['name'],
		'id' => $res['id_exp'],
		'rate' =>$res['rate']];
	$meetings[$res['id_meet']]['rates'][] = $a;

}
function rateCheck($d)
{
			$r;
		if ($d>=7.0) $r= "green_zone";
		else if ($d>=5.0) $r= "grey_zone";
		else $r= "red_zone";
		return $r;
}
/*foreach($meetings as $m)
{
	echo $m['name_m'];
	echo "<br>";
	echo $m['original'];
	echo "<br>";
	echo $m['year_of_cr'];
	echo "<br>";
	echo $m['name_d'];
	echo "<br>";
	echo $m['duration'];
	echo "<br>";
	echo $m['rating'];
	echo "<br>";
	echo $m['rating_kp'];
	echo "<br>";
	echo $m['our_rate'];
	echo "<br>";
	foreach($meetings[$m['id_m']]['rates'] as $g)
	{
		foreach($g as $j)
		{
		echo $j.",";
		}
		echo "<br>";
	}
	echo "<br>";
	foreach($meetings[$m['id_m']]['genre'] as $g)
	{
		echo $g.",";
	}
	
	
	echo "<br><br><br>";

}
print_r($meetings);
/*
Array 
( 
	[1] => Array 
	( 
		id 
		name
		original
		year
		name_d
		dur
		kp
		imdb
		our
		poster
		genre array(
		g1
		g2
		...)
		rates array(
		avatar
		rate)
	) 
) 
Arr

*/
?>
<?php session_start();
require 'path/header.php';?>
  	<?php foreach($meetings as $m):?>
  	<div class="row"> '<div class="three"><h1>Заседание #<?=$m['id_meet'];?></h1></div></div>
  	
  		<div class="container rounded forum-card">
  		<div class="row">
  			<div class="col-md-2 poster"><img src="<?=$m['poster'];?>" class="img-fluid rounded"id="IM"></div>
  			<div class="col-md-4 text-left description">
		  		<p class="name"><?=$m['name_m'];?></p>
		  		<div class="original"><?=$m['original'];?></div>
		  		<div class="year">Год: <?=$m['year_of_cr'];?></div>
		  		<div class="type">Жанр: 
		  			<?php 
		  			$n = count($meetings[$m['id_m']]['genre']);
					for($j = 0; $j<$n-1; ++$j)
					{
						echo $meetings[$m['id_m']]['genre'][$j]. ", ";
					}
					echo $meetings[$m['id_m']]['genre'][$j];?> </div>
		  		<div class="director">Режиссер: <?=$m['name_d'];?></div>
		  		<div class="time">Длительность: <?=$m['duration'];?>.</div>
		  		<div class="rates"><table class="table-rate text-center">
       			<thead>
            	<tr>
                <th scope="col"><img src="image/imdb.png" class="res_logo"></th>
                <th scope="col"><img src="image/kp.png" class="res_logo"></th>
                <th scope="col"><img src="image/logogo.png" class="res_logo"></th>
                </tr>
                </thead>
                <tbody>
                <tr>
                <td class="rate-ch"><?=$m['rating']?></td>
                 <td class="rate-ch"><?=$m['rating_kp']?></td>
                <td class="rate-ch"><?=$m['our_rate']?></td>                
                      </tr>
                    </tbody>
                    </table>
                </div>
	  		</div>
  			<div class="rating-tab col-md-2 text-center">
  				<table class="table-rate">
  					<thead>
					    <tr>
					      <th scope="col">Эксперт</th>
					      <th scope="col">Оценка</th>
					    </tr>
					  </thead>
					  <tbody>
					  	<?php 
					  	/*echo "<pre>";
					  	print_r($meetings[$m['id_m']]['rates']);
					  	echo "</pre>";*/
					  	$n = count($m['rates']);
					  	for($i=0; $i<$n; ++$i): ?>
					    <tr>
					      <th scope="row"  class="ex-name"><a href="profile.php?id=<?=$m['rates'][$i]['id']?>"><img  src="uploads\<?=$m['rates'][$i]['avatar']?>" alt="Ваня" class="avatar"></th>
					      <td class="rate-ch"><?=$m['rates'][$i]['rate']?></td>
					    </tr>
						<?php endfor; ?>
					  </tbody>
  					</table>
  			</div>
  			<div class="col-md-4 text-center">Цитаты
  			<blockquote class="blockquote text-center">
  				Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer posuere erat a ante<br><br>
  				<footer class="blockquote-footer">Кто-то знаменитый в <cite title="Название источника">Название источника</cite></footer>
				</blockquote>
			</div>
  		</div>
  	</div><?php endforeach;?>
<?php require 'path/footer.php';?>
