<?php
//	require 'path/header.php';
	require 'model/GetBase.php';
	$base = new GetBase();
	$thirds = $base->GetAllThirds();
	//debug($thirds);
	$j=0;
	foreach ($thirds as $third):
		if($j==3){$j=0;}
?>
	<div class="container forum-card">
  		<div class="row">
  			<div class="col-sm-12 text-center">
  				<div class="name">Добавлена тройка фильмов от пользователя <?=$third[$j]['name']?> </div>
  			</div>
  			<div class="selected" style="display: none;"><?=$third[$j]['selected']?></div>
  		</div>
  	</div>
    <div class="container forum-card">
  		<div class="row th">
  			<?php foreach($third as $film): ?>

  			<div class="col-md-4 thirds" id="id-<?=$film['id_m']?>">
  				<div class="row logo-and-rates">
  					<div class="col-sm-6 col-6">
  						<a href="<?=$film['url']?>">	<img src="<?=$film['poster']?>"class="img-fluid rounded" id="IM"></a>
  					</div>
  					<div class="col-sm-6 col-6">
  						<h5 class="name"><?=$film['name_m']?></h5>
		  				<div class="original"><?=$film['original']?></div>
		  				<div class="year">Год: <?=$film['year_of_cr']?></div>
		  				<div class="type">Жанр: 
		  					<?php 
					  			$n = count($film['genre']);
								for($i = 0; $i<$n-1; ++$i)
								{
									echo $film['genre'][$i]. ", ";
								}
								echo $film['genre'][$i];
							?>
		  				</div>
		  				<div class="director">Режиссер: <?=$film['name_d']?></div>
		  				<div class="time">Длительность: <?=$film['duration']?>мин.</div>
                        <div class="row d-sm-none mt-2">
                            <div class="col">
                                <img src="image/imdb.png" class="res_logo">
                            </div>
                            <div class="col">
                                <img src="image/kp.png" class="res_logo">
                            </div>
                            <?php if($film['our_rate']): ?>
                            <div class="col">
                                <img src="image/logogo.png" class="res_logo">
                            </div>
                            <?php endif; ?>
                        </div>
                        <div class="row d-sm-none">
                            <div class="col rate-ch">
                                <?=$film['rating']?>
                            </div>
                            <div class="col rate-ch">
                                <?=$film['rating_kp']?>
                            </div>
                            <?php if($film['our_rate']): ?>
                            <div class="col rate-ch">
                                <?=$film['our_rate']?>
                            </div>
                            <?php endif; ?>
                        </div>
                        <div class="d-none d-sm-block">
		                <table class="table-rate text-center" style="height: 100px;">
		              	    <tbody>
		              			<tr>
		              				<td><img src="image/imdb.png" class="res_logo"></td>
		              				<td class="rate-ch"><?=$film['rating']?></td>
		              			</tr>
		              			<tr>
		              				<th><img src="image/kp.png" class="res_logo"></th>
		              				<td class="rate-ch"><?=$film['rating_kp']?></td>
		              			</tr>
                                <?php if($film['our_rate']): ?>
                                <tr>
                                    <th><img src="image/logogo.png" class="res_logo"></th>
                                    <td class="rate-ch"><?=$film['our_rate']?></td>
                                </tr>
                                <?php endif; ?>
		              		</tbody>
		                </table>
                    </div>
  					</div>
  				</div>
  				<div class="row description">
  					<div class="col-sm-12 description"><?=$film['description']?></div>
  				</div>
  			</div>
  		<?php endforeach; ?>
  			
  		</div>
  	</div>
  <?php ++$j; endforeach; 
