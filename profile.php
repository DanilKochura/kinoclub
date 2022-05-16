<?php
	session_start();
	if(!isset($_GET['id'])) {header("Location: index.php");}
	$id = $_GET['id'];
	if(!isset($_SESSION['user'])) { header("Location: path/login.php");}
	require 'path/header.php';
	$id_s = $_SESSION['user']['id'];
	require 'config/bd.php';
	$query = "select name_m, id_meet from movie join meeting using(id_m) left join (select * from expert_rate where id_exp = '$id') as e using(id_meet) where id_rate is NULL;";
	$res = mysqli_query($conn, $query);
	
	$query_m = "SELECT (row_number() OVER (ORDER BY `our_rate` DESC)) as `top`, `name_m`, `our_rate`, `number`, `rate`
FROM `movie` join `meeting` USING(`id_m`) join `expert_rate` using(`id_meet`) where `id_exp` = '$id'";
	$res_m = mysqli_query($conn, $query_m);
	$query_test = "SELECT count(*) as a from expert_rate WHERE id_exp = '$id'";
	$res_nam = mysqli_query($conn, $query_test);
	$nam = mysqli_fetch_assoc($res_nam);
	if($nam['a']==0){ 	
		$query_data = "SELECT name, avatar from expert where id_e = '$id'";
		$res_data = mysqli_query($conn, $query_data);
		$dat = mysqli_fetch_assoc($res_data);
		$dat['module']=0;
		$dat['amount']=0;
	} else {
	$query_data = "SELECT ROUND(AVG(rate), 1) as module, count(id_meet) as amount, name, avatar from expert_rate join expert on id_e=id_exp where id_exp = '$id'";
			$res_data = mysqli_query($conn, $query_data);
		$dat = mysqli_fetch_assoc($res_data); }
?>

  	<div class="container">
  		<div class="row user-info">
  			<div class="col-sm-1"></div>
  			<div class="col-sm-2"><img class="user-avatar" src="uploads\<?=$dat['avatar']?>"></div>
  			<div class="col-sm-4"><h1><?=$dat['name']?></h1><p>Средняя оценка: <span class="rate-ch"><?=$dat['module']?><span></p><p>Количество встреч: <?=$dat['amount']?></p><p>Дата регистрации: 12.03.2022</div>
  				<div class="col-sm-4">
  					<?php if($id===$id_s):?> 
  						<div>
  							<button type="button" onclick="document.location='pages/logout.php'" class="btn btn-danger btn-user">Выход</button>
  						</div>
  						<div>
  							<button type="button" class="btn btn-primary btn-user" data-bs-toggle="modal" data-bs-target="#userModal">Редактировать личные данные</button>
  						</div>
  							<div class="modal fade" id="userModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
 							 <div class="modal-dialog">
   							 <div class="modal-content">
    							  <div class="modal-header">
        							<h5 class="modal-title" id="exampleModalLabel">Заголовок модального окна</h5>
       									 <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
      							</div>
      						<div class="modal-body">
       						 <form action="model/update.php" method="post" enctype="multipart/form-data">
									  <div class="mb-3">
									    <div class="mb-3">
											  <input class="form-control" name="avatar"type="file" id="formFile">
											</div>
		
									  </div>
									  <div class="input-group">
										  <span class="input-group-text">Имя и фамилия</span>
										  <input type="text" aria-label="Имя и фамилия" name="name"class="form-control">
										</div>
									  <button type="submit" class="btn btn-primary">Отправить</button>
									</form>
     							 </div>
     							 <div class="modal-footer">
						        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
						        <button type="button" class="btn btn-primary">Сохранить изменения</button>
						      </div>
						    </div>
						  </div>
								</div>

  				<button type="button" class="btn btn-warning btn-user" data-bs-toggle="modal" data-bs-target="#movieAddModal">Добавить фильм</button><?php endif; ?></div>
  				<div class="modal fade" id="movieAddModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
 							 <div class="modal-dialog">
   							 <div class="modal-content">
    							  <div class="modal-header">
        							<h5 class="modal-title" id="exampleModalLabel">Заголовок модального окна</h5>
       									 <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
      							</div>
      						<div class="modal-body">
       						  <form action="model/new-rate.php" method="post">
										  <select class="form-select" name="movie"aria-label="Пример выбора по умолчанию">
											  <option selected>Выберите фильм</option>
											  <?php while($r=mysqli_fetch_assoc($res)): ?>
											  <option name="<?=$r['id_meet']?>"value="<?=$r['id_meet']?>"><?=$r['name_m']?></option>
											<?php endwhile;?>
											</select>
											<div class="mb-3">
	    												<label for="inputRate" id="rangeValue" class="form-label">
	    														Оценка: 5
															</label>
	    												<input type="range" name="rate"class="form-range" min="0" max="10" step="1" onchange="document.getElementById('rangeValue').innerText = 'Оценка: '+this.value" id="customRange">
												</div>
										  <button type="submit" class="btn btn-warning">Отправить</button>
										</form>
						    </div>
						  </div>
						</div>
					</div>
  			<div class="col-sm-1"></div>
  	
  		<div class="row">
  			<div class="col-sm-1"></div>
  			<div class="col-sm-10">
  				<h4 class="text-center">Мои оценки</h4>
  				<table class="table-user-rate table table-hover ">
  					<thead>
  						<tr>
  							<td>Название</td>
  							<td>Оценка</td>
  							<td>Средний балл</td>
  							<td>Номер встречи</td>
  							<td>Место в топе</td>
  						</tr>
  					</thead>
  					<tbody>
  						<?php while($r=mysqli_fetch_assoc($res_m)): ?>
  						<tr>
  							<td><a class="mov-nam"href="dfd"><?=$r['name_m']?></a></td>
  							<td class="rate-ch"><?=$r['rate']?></td>
 
 								<td class="rate-ch"><?=$r['our_rate']?></td>
 								<td><?=$r['number']?></td>
 								<td><?=$r['top']?></td>
 							</tr>
 						<?php endwhile;?>
  					</tbody>
  				</table>
  			</div>
  			<div class="col-sm-1"></div>
  		</div>
  	</div>
<?php require 'path/footer.php'; ?>