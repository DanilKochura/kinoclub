<?php
session_start();
require 'model/GetBase.php';
$base = new DB();
$res =$base->Query_try("SELECT COUNT(*) from meeting");
$num = mysqli_fetch_array($res);
$num = $num[0];

$page = $_GET['page'] ?: 1;
$sort = $_GET['sort'] ?:'id_meet';
$order = $_GET['order'] ?:'desc';

//function cmp($a, $b)
//{
//     $first = floatval($a[$_GET['sort']]);
//     $second = floatval($b[$_GET['sort']]);
//     echo $first, $second;
//     echo $_GET['sort'];
//     $cmp = ($first - $second);
//     $order = ($_GET['order']);
//    if($cmp>0)
//    {
//        return ($order == 'up') ? -1 : 1;
//    }
//
//    elseif ($cmp<0)
//    {
//        return ($order == 'down') ? 1 : -1;
//    }
//    elseif ($cmp == 0)
//    {
//        return 0;
//    }
//}
//function cmp_function($a, $b){
//    $ab = floatval($a['rating']);
//    $ba = floatval($b['rating']);
//    $order = $_POST['order'];
////    echo $order; exit;
//    $cmp = $ab-$ba;
//    if($order == 'rating')
//    {
//        return $cmp>0 ? 1 : -1;
//    }else
//    {
//        return $cmp>0 ? -1 : 1;
//    }
//    //return ($ab > $ba);
//}
//
//function cmp_num($a, $b){
//    return (intval($a['num'])-intval($b['num']));
//}
//function cmp_rating($a, $b){
//    return (floatval($a['rating'])-floatval($b['rating']));
//}
$base = new GetBase();
$meetings= $base->GetAllMovies($sort, $order);
//
//$func = 'cmp_'.$_GET['sort'];
//uorder($meetings, $func);
//debug($meetings);
//exit;
//exit;
require 'path/header.php';?>
<div class="container">
    <div class="row">
        <div class="col rounded forum-card">
            <div class="text-center">
                <form sort="get" action="">
                <select name="sort" id="">
                    <option value="id_meet">По номеру встречи</option>
                    <option value="rating_kp">По оценке КП</option>
                    <option value="rating">По оценке IMDB</option>
                    <option value="our_rate">По оценке IMDBil</option>
                </select>
                <select name="order" id="">
                    <option value="asc">По возрастанию</option>
                    <option value="desc">По убыванию</option>
                </select>
                    <button type="submit" class="btn btn-warning btn-sm">Подтвердить</button>
                </form>
            </div>

        </div>
    </div>
</div>

<?php
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
  						if(isset($m['citate']['text'])) echo $m['citate']['text'];
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
