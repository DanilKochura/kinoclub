<?php
//	require 'path/header.php';
	require 'model/GetBase.php';
	$base = new GetBase();
	$thirds = $base->GetAllThirds();
//	debug($thirds);
//    exit;
	$j=0;
    $itera = 0;
	foreach ($thirds as $third):
        $itera++;
		if($j==3){$j=0;}
?>
	<div class="container forum-card mt-4 content">
  		<div class="row">
  			<div class="col-sm-12 text-center">
  				<div class="name">Добавлена тройка фильмов от пользователя <?=$third[$j]['name']?> </div>
  			</div>
  			<div class="selected" style="display: none;"><?=$third[$j]['selected']?></div>
  		</div>
  	</div>
    <div class="container forum-card mt-4">
  		<div class="row th">
  			<?php foreach($third as $film): ?>

  			<div class="col-md-4 thirds" style="display: flex; flex-direction: column;justify-content: space-between;" id="id-<?=$film['id_m']?>">
  				<div class="row logo-and-rates">
  					<div class="col-sm-6 col-6">
  						<a href="<?=$film['url']?>" target="_blank">	<img src="<?=$film['poster']?>"class="img-fluid rounded" id="IM"></a>
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
                <?php if(!$film['ended']): ?>
                <div class="row vote p-2">
                    <p class="name">Проголосовавшие:</p>
                    <?php if(!$film['ended']): ?>
                    <div class="col-4 btn-vote-<?=$itera?>">
                        <button class="btn btn-warning " onclick="vote('<?=$film['id_event']?>', <?=$film['id_m']?>, <?=$itera?>)">Проголосовать</button>
                    </div>
                    <?php endif; ?>
                    <div class="col mx-2">
                        <?php foreach($film['votes'] as $item): ?>
                        <img src="https://imdibil.ru/uploads/<?=$item?>" alt="" class="w-30p h-30p avatar">
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>

            </div>
  		<?php endforeach; ?>
  			
  		</div>
  	</div>
  <?php ++$j; endforeach; ?>
<div class="toast-container position-absolute bottom-0 end-0 p-3">
    <div class="toast" id="answer" role="alert" aria-atomic="true">
        <div class="toast-header text-white bg-success">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-circle" viewBox="0 0 16 16">
                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                <path d="M10.97 4.97a.235.235 0 0 0-.02.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05z"/>
            </svg>
            <strong class="me-auto mx-1">IMDbil</strong>
            <small class="text-muted">just now</small>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body">

        </div>
    </div>
    <div class="toast" id="err" role="alert" aria-atomic="true">
        <div class="toast-header text-white bg-danger">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-exclamation-circle" viewBox="0 0 16 16">
                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                <path d="M7.002 11a1 1 0 1 1 2 0 1 1 0 0 1-2 0zM7.1 4.995a.905.905 0 1 1 1.8 0l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 4.995z"/>
            </svg>
            <strong class="me-auto mx-1">IMDbil</strong>
            <small class="text-white">just now</small>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body">

        </div>
    </div>

    <!--        <div class="toast" id="test" role="alert" aria-live="assertive" aria-atomic="true">-->
    <!--            <div class="toast-header">-->
    <!--                <img src="..." class="rounded me-2" alt="...">-->
    <!--                <strong class="me-auto">Bootstrap</strong>-->
    <!--                <small class="text-muted">2 seconds ago</small>-->
    <!--                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>-->
    <!--            </div>-->
    <!--            <div class="toast-body">-->
    <!--                Heads up, toasts will stack automatically-->
    <!--            </div>-->
    <!--        </div>-->
</div>

