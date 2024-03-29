<?php
require 'model/GetBase.php';
$base = new DB();
$res =$base->Query_try("SELECT COUNT(*) from meeting");
$num = mysqli_fetch_array($res);
$num = $num[0];

$show = $_GET['show'] ?: 5;
$page = $_GET['page'] ?: 1;
$sort = $_GET['sort'] ?:'id_meet';
$order = $_GET['order'] ?:'desc';

$start = ($page-1)*$show;

$base = new GetBase();
//$meetings= $base->GetAllMovies($sort, $order);
$meetings= $base->GetMoviesPage($sort, $order, $start, $show); ?>
<div class="container content" id="test-div">
    <div class="row">
        <div class="col rounded forum-card  mt-4 d-none d-md-block">
            <div class="text-center">
                <form method="get" action="">
                    <div class="row justify-content-center">
                        <div class="col-3">
                        <select name="sort" class="form-select form-select-sm" id="">
                            <option value="id_meet">По номеру встречи</option>
                            <option value="rating_kp">По оценке КП</option>
                            <option value="rating">По оценке IMDB</option>
                            <option value="our_rate">По оценке IMDBil</option>
                        </select>
                        </div>
                        <div class="col-3">
                        <select name="order"  class="form-select  form-select-sm" id="">
                            <option value="asc">По возрастанию</option>
                            <option value="desc">По убыванию</option>
                        </select>
                        </div>
                        <div class="col-1">
                        <select name="show" class="form-select form-select-sm" id="">
                            <option value="5">5</option>
                            <option value="10">10</option>
                            <option value="20">20</option>
                            <option value="50">50</option>
                        </select>
                        </div>
                        <div class="col-3">
                            <button type="submit" class="btn btn-warning btn-sm">Подтвердить</button>
                        </div>
                        </div>
                </form>
            </div>

        </div>
    </div>
</div>

<?php
$month = ['', 'Jan' => 'января', 'Feb' => 'февраля', 'Mar' => 'марта', 'Apr' => 'апреля', 'May' => 'мая', 'Jun' => 'июня', 'Jul' => 'июля', 'Aug' => 'августа', 'Sep' => 'сентября', 'Oct' => 'октября', 'Nov' => 'ноября', 'Dec' => 'декабря'];
foreach($meetings as $m):
    ?>
    <div class="row m-0" style="justify-content: center"><div class="three"><h1>Заседание #<?=$m['num']?></h1></div></div>


    <div class="container rounded forum-card mt-4">
    <div class="row " >
        <div class="col-md-2 poster"><a href="<?=$m['url'];?>" target="_blank"><img src="<?=$m['poster'];?>" class="img-fluid rounded"id="IM"></a></div>
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
                        <th class="bg-main" scope="col"><img src="image/imdb.png" class="res_logo"></th>
                        <th class="bg-main" scope="col"><img src="image/kp.png" class="res_logo"></th>
                        <th  class="bg-main" scope="col"><img src="image/logogo.png" class="res_logo"></th>
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
            <div><span><?=date("d", strtotime($m['date_at']))?> <?=$month[date("M",strtotime( $m['date_at']))]?>  <?=date("Y", strtotime($m['date_at']))?> </span></div>
        </div>
        <div class="rating-tab col-md-4 col-xl-3">
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
                            <a href="profile/<?=$m['rates'][$i]['id']?>">
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
                            <a href="profile/<?=$m['rates'][$i]['id']?>">
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
        <div class="col-md-3 text-center d-none d-xl-block">Цитаты
            <blockquote class="blockquote text-center">
                <?php if(isset($m['citate'])):
                if(isset($m['citate']['text'])) echo $m['citate']['text'];
                else echo "Упс! Тут ничего нет! Возможно, скоро появится."
                ?>
                <br><br>
                <footer class="blockquote-footer"><?php if(isset($m['citate']['author'])) echo $m['citate']['author']; ?></cite></footer>
            </blockquote>
        </div>
        <?php endif; ?>
    </div>
    </div><?php  endforeach;?>
<style>
    .user-av
    {
        max-width: 100%;
    }
    .body{
        border-left: 2px solid white;
    }
    .attachments
    {
        max-height: 100px;
        transition: 1s;
    }
    .attachments:hover
    {
        transform: scale(5) translateX(100px) translateY(-20px);
    }
    .tab
    {
        display: table-cell;
    }
    .row.tab
    {
        display: table;
    }
    .pagination {
        width:100%;
        text-align:center;
        padding: 10px;
        margin:10px auto;
        border: 1px solid #ddd;
    }
    .pagination ul{
        width:100%;
        padding:0px;
        margin:0px;
    }
    .pagination ul li {
        display:inline-block;
        list-style:none;
        margin:5px 5px;
        font-size:14px;
        text-align:center;
    }
    .pagination ul li a, .pagination ul li a:visited {
        display:block;
        text-decoration:none;
        color: black;
        background: repeat-x scroll 0 0 gold;

        -webkit-border-radius: 50%;
        -moz-border-radius: 50%;
        -ms-border-radius: 50%;
        border-radius: 50%;

        height: 28px;
        width: 28px;
        line-height: 26px;
        top: -1px;

    }
    a{
        text-decoration: none;
        color: white;
        font-size: 20px;
    }
    a:hover
    {
        color: gold;
        cursor: pointer;
    }

</style>
<!--<div id="floating-switch">-->
<!--    <label class="d-flex align-items-center mb-3">-->
<!--        <span class="px-3 user-select-none" id="floating-switch-label">Barbie</span>-->
<!--        <input class="d-none-cloaked" type="checkbox" id="floating-switch-btn" name="switch-checkbox" value="1" checked>-->
<!--        <i class="switch-icon bg-main"></i>-->
<!--    </label>-->
<!--</div>-->
<div class="container text-center">
    <div class="pagination">
        <ul>
            <?php for($i=1; $i<$num/$show+1; $i++):?>
                <li><a href="?page=<?=$i?>&sort=<?=$sort?>&order=<?=$order?>&show=<?=$show?>" title="Страница <?=$i?>"><?=$i?></a></li>
            <?php endfor; ?>
        </ul>
    </div>
</div>
</div>
</div>


