<?php 
	ini_set('display_errors', 0);
	ini_set('display_startup_errors', 0);
	error_reporting(E_ALL);
//		require 'path/header.php';
	include 'parser/parser.php';
	require 'config/bd.php';

	session_start();
	$db = new DB();
	if($_SESSION['user']['id']!=29){header('Location: profile.php');}
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
	if(isset($_GET['name']))
	{
		$a = Parse($_GET['name']);
		
	}
    $meet = $db->Query_try("SELECT name_m, id_meet from meeting join movie using(id_m)");
    $query_u = "SELECT id_e, name from expert where id_e != 29";
    $experts = $db->Query_try($query_u);
    $users = [];
    while($user = mysqli_fetch_assoc($experts))
    {
        $users[] = $user;
    }
	$q1 = "select count(*) from director"; /*количество режиссеров*/
	$query = "SELECT id_d, name_d from director"; /*список режиссеров*/
	$res=$db->Query_try($query);
	$q = "SELECT id_g, name_g from genre"; /*список жанров*/
	$q = $db->Query_try($q);
	$query_meet = "SELECT name_m, id_m from movie left join meeting using(id_m) where id_meet is NULL";
	$momeet = $db->Query_try($query_meet);
    $films = array();
    while($row = mysqli_fetch_assoc($momeet))
    {
        $films[]=$row;
    }
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
			<form action="controller/AdminFormController.php?type=mov" method="post" enctype="multipart/form-data">
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
			<div class="row">
			<form>
				<label>Имя режиссера</label>
				<input type="text" name="name" class="form-control" value="<?=$a['director']?>">
				<button type="submit" class="btn btn-warning" formaction="controller/AdminFormController.php?type=dir" formmethod="post">Добавить режиссера</button>
			</form>
			</div>
			<div class = "row">
			<form action="controller/AdminFormController.php?type=install" enctype="multipart/form-data" method="post">
				<div class="form-al">
						<label>Название файла</label>
						<input class="form-control" name="file-to-parse"type="file" id="formFile">
				</div>
				<button type="submit" class="btn btn-warning">Проверить фильм</button>
			</form>
			</div>
            <div class="row">
                <div class="row">
                    <form method="post" action="controller/AdminFormController.php?type=third">
                        <label>Выберите фильм</label>
                        <select class="form-select" name="film1"aria-label="Фильм">
                            <?php foreach ($films as $film): ?>
                                <option name="<?=$film['name_m']?>"value="<?=$film['id_m']?>"><?=$film['name_m']?></option>
                            <?php endforeach;?>
                        </select>
                        <select class="form-select" name="film2"aria-label="Фильм">
                            <?php foreach ($films as $film): ?>
                                <option name="<?=$film['name_m']?>"value="<?=$film['id_m']?>"><?=$film['name_m']?></option>
                            <?php endforeach;?>
                        </select>
                        <select class="form-select" name="film3"aria-label="Фильм">
                            <?php foreach ($films as $film): ?>
                                <option name="<?=$film['name_m']?>"value="<?=$film['id_m']?>"><?=$film['name_m']?></option>
                            <?php endforeach;?>
                        </select>
                        <select class="form-select" name="user"aria-label="Пользователь">
                            <?php foreach ($users as $user): ?>
                                <option name="<?=$user['name']?>"value="<?=$user['id_e']?>"><?=$user['name']?></option>
                            <?php endforeach;?>
                        </select>
                        <button type="submit" onclick="#" class="btn btn-warning">Добавить тройку</button>
                    </form>
                </div>
            </div>
            <div class="row" style="margin-top: 20px;">
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                    Launch demo modal
                </button>

                <!-- Modal -->
                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="container ">
                                <form action="" class="formAjax">
                                    <select name="meeting" id="mm">
                                    <?php while($rrr = $meet->fetch_assoc()): ?>
                                        <option value="<?=$rrr['id_meet']?>"><?=$rrr['name_m']?></option>
                                    <?php endwhile; ?>
                                    </select>
                                </form>
                                </div>
                                <hr>
                                <div class="container">
                                    <div class="form">
                                        <form method="post" action="controller/AdminFormController.php?type=rates">
                                            <input type="hidden" name="meet" id="meet_id">
                                        <div>
                                            <?php foreach ($users as $user): ?>
                                            <div class="col-md-4">
                                                <div class="row">
                                                    <div class="col-sm-5"><p><?=$user['name']?></p></div>
                                                    <div class="col-sm-3" ><input type="text" name="rate[]"id="<?=$user['id_e']?>" value=""></div>
                                                </div>
                                            </div>
                                            <?php endforeach; ?>
                                            <button type="submit" class="btn btn-yellow">Записать</button>
                                        </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary">Save changes</button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
		</div>
		
		<div class="col-sm-2">
            <div class="row">
			<form method="post" action="controller/AdminFormController.php?type=meet">
				<label>Выберите фильм</label>
				<select class="form-select" name="film"aria-label="Фильм">
                    <?php foreach ($films as $film): ?>
                        <option name="<?=$film['name_m']?>"value="<?=$film['id_m']?>"><?=$film['name_m']?></option>
                    <?php endforeach;?>
						</select>
				<button type="submit" onclick="#" class="btn btn-warning">Добавить встречу</button>
			</form>

            </div>

            <div class="row">
                <!-- Button trigger modal -->
                <label for="">Редактировать оценки</label>

            </div>

		</div>

	</div>

	
</div>
    <script
            src="https://code.jquery.com/jquery-3.6.0.min.js"
            integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
            crossorigin="anonymous"></script>
<?php require_once 'path/footer.php';