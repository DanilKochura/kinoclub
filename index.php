<?php

require 'config/bd.php';
function Query_try($connection, $query) //запрос к бд и прерывание в случае ошибки
{
	if(!($result = mysqli_query($connection, $query)))
	{
		die("Query error");
	}
	return $result;
}

$meetings= array();
$descr_q = "SELECT id_meet, url, id_m, name_m, original, year_of_cr, name_d,duration,rating, our_rate,rating_kp, poster from movie
				join director on id_d=director join meeting using(id_m);";  //получение карточки фильма

$exp_q = "SELECT id_rate, id_meet, id_exp, avatar, name, rate from expert join expert_rate on id_e=id_exp  order by id_meet, rate desc
;";  // получение списка эксепрт-оценка

$genre_q ="SELECT name_g, id_meet from genre  join gen_to_mov using(id_g) join meeting using(id_m) order by id_meet;"; //получение списка жанров для фильма

$res_description=Query_try($conn, $descr_q);
$res_experts = Query_try($conn, $exp_q);
$res_genres = Query_try($conn, $genre_q);
while ($movie = mysqli_fetch_assoc($res_description)) {
	$movie['rates']=array();
	$movie['genre']=array();
	$meetings[$movie['id_m']] = $movie;

	
}
$i=0;

while($res = mysqli_fetch_assoc($res_genres))
{
	$meetings[$res['id_meet']]['genre'][] = $res['name_g'];
}
$i=0;
while($res = mysqli_fetch_assoc($res_experts))
{
	$a = [
		'avatar' => $res['avatar'],
		'name' => $res['name'],
		'id' => $res['id_exp'],
		'rate' =>$res['rate']];
	$meetings[$res['id_meet']]['rates'][] = $a;

}

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
  			<div class="col-md-2 poster"><a href="<?=$m['url'];?>"><img src="<?=$m['poster'];?>" class="img-fluid rounded"id="IM"></a></div>
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
		  		<div class="time">Длительность: <?=$m['duration'];?>мин.</div>
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
  			<?php if($m['id_meet']==9): ?>
				<div class="col-md-4 text-center">Цитаты
  			<blockquote class="blockquote text-center">
  				Дима нихуя не понимают, а анимешники ему объясняют!<br><br>
  				<footer class="blockquote-footer">Альвар</footer>
				</blockquote>
			</div>
		<?php else: ?>
  			<div class="col-md-4 text-center">Цитаты
  			<blockquote class="blockquote text-center">
  				Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer posuere erat a ante<br><br>
  				<footer class="blockquote-footer">Кто-то знаменитый в <cite title="Название источника">Название источника</cite></footer>
				</blockquote>
			</div>
				<?php endif; ?>
  		</div>
  	</div><?php endforeach;?>
<?php require 'path/footer.php';?>
