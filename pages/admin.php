<?php 
	ini_set('display_errors', 0);
	ini_set('display_startup_errors', 0);
	error_reporting(E_ALL);

	include 'parser/parser.php';
	require 'config/bd.php';

	session_start();
	$db = new DB();
	if($_SESSION['user']['id']!=29){header('Location: ../profile');}
	$a = array(
		'name'=>"Name",
		'original'=>"Original Name",
		'year'=>"Year of creation",
		'director'=>"Director",
		'genre'=>array(),
		'rating-kp'=>"Kinopoisk rate",
		'duration'=>"Duration",
		'url'=>"Url",
		'imdb'=>"IMDB rate",
		'descr'=>"Description"
	);


	if(isset($_SESSION['file']))
	{
		$a = Parse($_SESSION['file']);
		
	}

	$q1 = "select count(*) from director"; /*количество режиссеров*/
	$query = "SELECT id_d, name_d from director"; /*список режиссеров*/
	$res=$db->Query_try($query);
	$q = "SELECT id_g, name_g from genre"; /*список жанров*/
	$q = $db->Query_try($q);
	$query_meet = "SELECT name_m, id_m from movie left join meeting using(id_m) where id_meet is NULL";
	$momeet = $db->Query_try($query_meet);
	function checkGenre($r, $g)
	{
		foreach ($g as $gen) {
			if($gen==$r){echo "checked"; break;}
		}
	}
	function checkDirector($r, $g)
	{
		if($g==$r){echo "selected";}
	}require 'path/header.php';
?>
<div class="container">
    <?PHP  debug($a); ?>
</div>
<div class="container">
	<div class="row">
		<div class="col-sm-5">
			<div class="forum-card new">
				<h1 class="text-center">Новый фильм</h1>
			<form action="../controller/AdminFormController.php?type=mov" method="post" enctype="multipart/form-data">
				<div class="form-gr">
					<div class="form-path">
						<label>Название</label>
						<input type="text" name="name" value="<?=$a['name']?>"class="form-control">
					</div>
					<div class="form-path">
						<label>Оригинально название</label>
						<input type="text" name="original" value="<?=$a['original']?>" class="form-control">
					</div>
				</div>
				<div class="form-gr">
					<div class="form-path">
						<label>Жанры</label>
						<div class="check-g">
						<?php while($r = mysqli_fetch_assoc($q)): ?>
						<div class="form-check">
							  <input class="form-check-input" type="checkbox" name="check[]" value="<?=$r['id_g']?>" id="flexCheckDefault" <?php checkGenre($r['name_g'], $a['genre']);?>>
				  			  <label class="form-check-label" for="flexCheckDefault"><?=$r['name_g']?>
				 			  </label>
						</div>
						<?php endwhile;?>
						</div>
					</div>
					<div class="form-path">
						<label>Режиссер</label>
						<select class="form-select" name="director"aria-label="Режиссер">
								<?php while($r=mysqli_fetch_assoc($res)): ?>
								<option name="<?=$r['id_d']?>"value="<?=$r['id_d']?>" <?php checkDirector($r['name_d'], $a['director']);?>><?=$r['name_d']?></option>
								<?php endwhile;?>
								</select>
						<input type="hidden" value="<?=$_GET['name']?>" name="file">
					</div>
				</div>
				<div class="form-gr">
					<div class="form-path">	
						<label>Год выпуска</label>
						<input type="text" name="year"  value="<?=$a['year']?>"class="form-control">
					</div>
					<div class="form-path">
						<label>Длительность</label>
						<input type="text" name="duration" value="<?=$a['duration']?>" class="form-control">
					</div>
				</div>
				<div class="form-al">
						<label>Обложка</label>
						<input class="form-control" name="avatar"type="file" id="formFile">
						<label>Урл</label>
						<input type="text" name="url" value="<?=$a['url']?>" class="form-control">
						<label>Синопсис</label>
						<input type="text" name="descr" value="<?=$a['descr']?>" class="form-control">
				</div>
				<div class="form-gr">
					<div class="form-path">
						<label>Оценка на КП</label>
						<input type="text" name="kinopoisk"  value="<?=$a['rating-kp']?>" class="form-control">
					</div>
					<div class="form-path">
						<label>Оценка на IMDB</label>
						<input type="text" name="imdb"  value="<?=$a['imdb']?>"class="form-control">
					</div>
				</div>
				
				<div class="form-gr btn"><button type="submit" onclick="#" class="btn btn-warning">Добавить фильм</button></div>
			</form>
				</div>
		</div>
		<div class="col-sm-5">
			<div>
			<form>
				<label>Имя режиссера</label>
				<input type="text" name="name" class="form-control" value="<?=$a['director']?>">
				<button type="submit" class="btn btn-warning" formaction="controller/AdminFormController.php?type=dir" formmethod="post">Добавить режиссера</button>
			</form>
			</div>
			<div>
			<form action="../controller/AdminFormController.php?type=install" enctype="multipart/form-data" method="post">
				<div class="form-al">
						<label>Название файла</label>
						<input class="form-control" name="file-to-parse"type="file" id="formFile">
				</div>
				<button type="submit" class="btn btn-warning">Проверить фильм</button>
			</form>
			</div>
		</div>
		
		<div class="col-sm-2">
			<form method="post" action="../controller/AdminFormController.php?type=meet">
				<label>Выберите фильм</label>
				<select class="form-select" name="film"aria-label="Фильм">
						<?php while($r=mysqli_fetch_assoc($momeet)): ?>
						<option name="<?=$r['name_m']?>"value="<?=$r['id_m']?>"><?=$r['name_m']?></option>
								<?php endwhile;?>
						</select>
				<button type="submit" onclick="#" class="btn btn-warning">Проверить фильм</button>
			</form>
		</div>
	</div>

	
</div>

<?php require 'path/footer.php';
