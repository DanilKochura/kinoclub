<?php
session_start();
require 'model/GetBase.php';

$base = new GetBase();
$meetings= $base->GetAllMovies();
//debug($meetings);
require 'path/header.php';
foreach($meetings as $m):
	?>
  	<div class="row"> '<div class="three"><h1>Заседание #<?=$m['num']+1?></h1></div></div>
  	
  		<div class="container rounded forum-card">
  		<div class="row">
  			<div class="col-md-2 poster"><a href="<?=$m['url'];?>"><img src="<?=$m['poster'];?>" class="img-fluid rounded"id="IM"></a></div>
  			<div class="col-md-4 text-left description">
		  		<p class="name"><?=$m['name_m'];?></p>
		  		<div class="original"><?=$m['original'];?></div>
		  		<div class="year">Год: <?=$m['year_of_cr'];?></div>
		  		<div class="type">Жанр: 
		  			<?php 
		  			$n = count($m['genre']);
					for($j = 0; $j<$n-1; ++$j)
					{
						echo $m['genre'][$j]. ", ";
					}
					echo $m['genre'][$j];?> </div>
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
  			<div class="rating-tab col-md-3 text-center">
  				<!--<table class="table-rate">
  					<thead>
					    <tr>
					      <th scope="col">Эксперт</th>
					      <th scope="col">Оценка</th>
					    </tr>
					  </thead>
					  <tbody>
					  	<?php /*
					  	$n = count($m['rates']);
					  	for($i=0; $i<$n; ++$i): */?>
					    <tr>
					      <th scope="row"  class="ex-name"><a href="profile.php?id=<?/*=$m['rates'][$i]['id']*/?>"><img  src="uploads\<?/*=$m['rates'][$i]['avatar']*/?>" alt="Ваня" class="avatar"></th>
					      <td class="rate-ch"><?/*=$m['rates'][$i]['rate']*/?></td>
					    </tr>
						<?php /*endfor; */?>
					  </tbody>
  					</table>-->
                <?php
				$n = count($m['rates']);
                $i=0;
                $j=0;?>
                <table class="table-rate text-center" style="margin-top: 30px">
                    <tbody>



                <tr>
                <?php for($i; $i<$n/2; ++$i): ?>
                    <td scope="row"  class="ex-name">
                        <a href="profile.php?id=<?=$m['rates'][$i]['id']?>">
                            <img  src="uploads\<?=$m['rates'][$i]['avatar']?>" alt="Ваня" class="avatar">
                        </a>
                    </td>
                    <?php endfor; ?>
                </tr>
                    <tr>
                <?php for($j; $j<$n/2; ++$j): ?>
                    <td class="rate-ch"><?=$m['rates'][$j]['rate']?></td>
                <?php endfor; ?>
                    </tr>

                <tr><td scope="row" colspan="4"><hr style="color: gold; border: 1px solid gold; border-radius: 1px; opacity: 0.8"></td></tr>
                <tr>
                    <?php for($i; $i<$n; ++$i): ?>
                        <td scope="row"  class="ex-name">
                            <a href="profile.php?id=<?=$m['rates'][$i]['id']?>">
                                <img  src="uploads\<?=$m['rates'][$i]['avatar']?>" alt="Ваня" class="avatar">
                            </a>
                        </td>
                    <?php endfor; ?>
                </tr>
                <tr>
                    <?php for($j; $j<$n; ++$j): ?>
                        <td class="rate-ch"><?=$m['rates'][$j]['rate']?></td>
                    <?php endfor; ?>
                </tr>
                    </tbody>
                </table>
                </div>
  			<div class="col-md-3 text-center">Цитаты
  			<blockquote class="blockquote text-center">
  				<?php if(isset($m['citate'])):
  						if(isset($m['citate'][0]['text'])) echo $m['citate'][0]['text'];
  						else echo "Упс! Тут ничего нет! Возможно, скоро появится."
  				?>
  				<br><br>
  				<footer class="blockquote-footer"><?php if(isset($m['citate'][0]['author'])) echo $m['citate'][0]['author']; ?></cite></footer>
				</blockquote>
			</div>
				<?php endif; ?>
  		</div>
  	</div><?php  endforeach;?>
<?php require 'path/footer.php';?>
