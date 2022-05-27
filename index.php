<?php

require 'model/GetBase.php';

$base = new GetBase();
$meetings= $base->GetAllMovies();

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
