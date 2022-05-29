<?php
	session_start();

	if(!isset($_SESSION['user'])) { header("Location: path/login.php");}
	$id=$_SESSION['user']['id'];
	if(isset($_GET['id']))
	{	
		$id = $_GET['id'];
	}
	require 'path/header.php';
	$id_s = $_SESSION['user']['id'];
	require 'model/GetBase.php';

	$base = new GetBase();
	
	
	$res = $base->GetAcceptedRate($id);
	$res_m = $base->GetUserRates($id);
	$dat = $base->GetUserInfo($id);
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
       						 <form action="controller/UserFormController.php?type=update" method="post" enctype="multipart/form-data">
									  <div class="mb-3">
									    <div class="mb-3">
											  <input class="form-control" name="avatar"type="file" id="formFile">
											</div>
		
									  </div>
									  <div class="input-group">
										  <span class="input-group-text">Имя и фамилия</span>
										  <input type="text" aria-label="Имя и фамилия" name="name"class="form-control">
										</div>
										<div class="input-group">
										  <span class="input-group-text">Новый пароль</span>
										  <input type="password" aria-label="Новый пароль" name="new-pass"class="form-control">
										</div>
										<div class="input-group">
										  <span class="input-group-text">Подтвердите пароль</span>
										  <input type="password" aria-label="Подтвердите пароль" name="new-pass-confirm"class="form-control">
										</div>
										<div class="input-group">
										  <span class="input-group-text">Текущий пароль</span>
										  <input type="password" aria-label="Текущий пароль" name="old-pass"class="form-control">
										</div>
									  <button type="submit" class="btn btn-primary">Отправить</button>
									</form>
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
       						  <form action="controller/UserFormController.php?type=add" method="post">
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
  						<?php while($r=mysqli_fetch_assoc($res_m)):
  							$tmp_id = $r['id_meet']; ?>
  						<tr>
  							<td><a class="mov-nam"href="dfd"><?=$r['name_m']?></a></td>
  							<td class="rate-ch"><?=$r['rate']?></td>
 
 								<td class="rate-ch"><?=$r['our_rate']?></td>
 								<td><?=$r['id_meet']?></td>
 								<td><?=$r['top']?></td>
 								<td><a class="unrate" href="controller/UserFormController.php?type=unrate&id=<?=$tmp_id?>">Удалить запись</a></td>
 							</tr>
 						<?php endwhile;?>
  					</tbody>
  				</table>
  			</div>
  			<div class="col-sm-1"></div>
  		</div>
  	</div>
<?php require 'path/footer.php'; ?>