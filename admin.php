<?php 
	session_start();
	if($_SESSION['user']['id']!=29){header('Location: profile.php');}
	require 'path/header.php';
	include 'parser/parser.php';
	require 'config/bd.php';
	if(isset($_GET['name']))
	{
		$a = Parse($_GET['name']);
		//print_r($a);
	}
	$q1 = "select count(*) from director"; /*количество режиссеров*/
	$query = "SELECT id_d, name_d from director"; /*список режиссеров*/
	$res=mysqli_query($conn, $query);
	$q = "SELECT id_g, name_g from genre"; /*список жанров*/
	$q = mysqli_query($conn, $q);
	$query_meet = "SELECT name_m, id_m from movie left join meeting using(id_m) where id_meet is NULL";
	$momeet = mysqli_query($conn, $query_meet);
	function checkGenre($r, $g)
	{
		foreach ($g as $gen) {
			if($gen==$r){echo "checked"; break;}
		}
	}
	function checkDirector($r, $g)
	{
		if($g==$r){echo "selected";}
	}
?>
<div class="container">
	<div class="row">
		<div class="col-sm-5">
			<div class="forum-card new">
				<h1 class="text-center">Новый фильм</h1>
			<form action="model/addfilm.php" method="post" enctype="multipart/form-data">
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
				<button type="submit" class="btn btn-warning" formaction="model/newDirector.php" formmethod="post">Добавить режиссера</button>
			</form>
			</div>
			<div>
			<form>
				<label>Название файла</label>
				<input type="text" name="name" class="form-film ">
				<button type="submit" onclick="#" class="btn btn-warning">Проверить фильм</button>
			</form>
			</div>
		</div>
		
		<div class="col-sm-2">
			<form method="post" action="model/addMeet.php">
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