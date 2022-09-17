<?php

    if(!$_SESSION['user']['id'])
    {
        header('Location: /login');
    }

	$id=$_SESSION['user']['id'];

    if($_GET[0]!='')
	{
		$id = $_GET[0];
	}

	$id_s = $_SESSION['user']['id'];
	require_once PATH.'/model/User.php';

    $user = new User($id);

    //    echo $user->name;
//$user->debug();



?>

  	<div class="container main">
  		<div class="row user-info">
  			<div class="col-sm-1"></div>
  			<div class="col-sm-2 col-6">
                <img class="user-avatar" src="<?=ROOT?>/uploads/<?=$user->avatar?>">
            </div>
            <div class="col-sm-4 col-6">
                <h1><?=$user->name?></h1>
                <p>Средняя оценка: <span class="rate-ch"><?=$user->module?></span></p>
                <p>Количество встреч: <?=$user->amount?></p>
                <p class="d-none">Дата регистрации: 12.03.2022</p>


            </div>
  				<div class="col-sm-4">
  					<?php if($id===$id_s):?>
  						<div>
  							<button type="button" class="btn btn-primary btn-user m-0 mt-2" data-bs-toggle="modal" data-bs-target="#userModal">Редактировать личные данные</button>
  						</div>
  							<div class="modal fade" id="userModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
 							 <div class="modal-dialog">
   							 <div class="modal-content">
    							  <div class="modal-header">
        							<h5 class="modal-title" id="exampleModalLabel">Заголовок модального окна</h5>
       									 <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
      							</div>
      						<div class="modal-body">
       						 <form action="<?=ROOT?>/controller/UserFormController.php?type=update" method="post" enctype="multipart/form-data">
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

  				<div><button type="button" class="btn btn-warning btn-user m-0 mt-2" data-bs-toggle="modal" data-bs-target="#rateAddModal">Добавить оценку</button></div>
  				<div class="modal fade" id="rateAddModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
 							 <div class="modal-dialog">
   							 <div class="modal-content">
    							  <div class="modal-header">
        							<h5 class="modal-title" id="exampleModalLabel">Заголовок модального окна</h5>
       									 <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
      							</div>
      						<div class="modal-body">
       						  <form action="#" method="post" id="Addrate">
										  <select class="form-select" name="movie"aria-label="Пример выбора по умолчанию" required>
											  <option selected disabled>Выберите фильм</option>
											  <?php foreach ($user->allowed as $r): ?>
											  <option name="<?=$r['id_meet']?>"value="<?=$r['id_meet']?>"><?=$r['name_m']?></option>
											<?php endforeach;?>
											</select>
											<div class="mb-3">
												<div class="rating-area">
													<input type="radio" id="star-10" name="rating" value="10">
													<label for="star-10" title="Оценка «10»"></label>	
													<input type="radio" id="star-9" name="rating" value="9">
													<label for="star-9" title="Оценка «9»"></label>    
													<input type="radio" id="star-8" name="rating" value="8">
													<label for="star-8" title="Оценка «8»"></label>  
													<input type="radio" id="star-7" name="rating" value="7">
													<label for="star-7" title="Оценка «7»"></label>    
													<input type="radio" id="star-6" name="rating" value="6">
													<label for="star-6" title="Оценка «6»"></label>
													<input type="radio" id="star-5" name="rating" value="5">
													<label for="star-5" title="Оценка «5»"></label>	
													<input type="radio" id="star-4" name="rating" value="4">
													<label for="star-4" title="Оценка «4»"></label>    
													<input type="radio" id="star-3" name="rating" value="3">
													<label for="star-3" title="Оценка «3»"></label>  
													<input type="radio" id="star-2" name="rating" value="2">
													<label for="star-2" title="Оценка «2»"></label>    
													<input type="radio" id="star-1" name="rating" value="1">
													<label for="star-1" title="Оценка «1»"></label>
												</div>
												</div>
										  <button type="submit" class="btn btn-warning">Отправить</button>
										</form>
						    </div>
						  </div>
						</div>
					</div>
                <div><button type="button" class="btn btn-warning btn-user m-0 mt-2" data-bs-toggle="modal" data-bs-target="#thirdAddModal">Добавить тройку</button></div>
  				    <div class="modal fade" id="thirdAddModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
 							 <div class="modal-dialog">
   							 <div class="modal-content">
    							  <div class="modal-header">
        							<h5 class="modal-title" id="exampleModalLabel">Добавить тройку</h5>
       									 <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
      							</div>
      						<div class="modal-body">
                                <?php if(!count($user->third)): ?>
       						  <form action="" method="post">
                                  <input type="text" class="search w-100" id="" placeholder="Интерстеллар">

										</form>
                                <div class="results">

                                </div>
                                <div class="row">
                                    <div class="col selected t">

                                    </div>
                                    <form action="" id="thirdadd" class="text-center mt-3">

                                    </form>
                                </div>
                                <?php else: ?>
                                <div class="row">
                                    <p class="text-center">Вы уже отправили тройку на модерацию.</p>

                                    <?php foreach($user->third as $film): ?>
                                    <div class="col-4"><img src="<?=$film['poster']?>"  class="img-fluid rounded" style="width: 100px; height: 140px"alt=""></div>
                                <?php endforeach;?>
                                    <button class="btn btn-warning mt-3" onclick="delete_user_third(<?=$user->id?>)">Удалить</button>
                                </div>
                                <?php endif; ?>
						    </div>
						  </div>
						</div>
					</div>
               <div></div> <button type="button" class="btn btn-warning btn-user m-0 mt-2" data-bs-toggle="modal" data-bs-target="#movieAddModal">Добавить фильм в базу</button>
                    <button type="button" class="btn btn-danger btn-user m-0 mt-2" data-bs-toggle="modal" data-bs-target="#pairAddModal">Добавить пару</button></div>
            <div class="modal fade" id="pairAddModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Добавить пару</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
                        </div>
                        <div class="modal-body">
                            <?php if(!count($user->pair)): ?>
                                <form action="" method="post">
                                    <input type="text" class="search" id="pair" class="w-100" placeholder="Интерстеллар">

                                </form>
                                <div class="results">

                                </div>
                                <div class="row">
                                    <div class="col selected p">

                                    </div>
                                    <form action="" id="pairadd" class="text-center mt-3">

                                    </form>
                                </div>
                            <?php else: ?>
                                <div class="row text-center">
                                    <p class="text-center">Вы уже отправили пару на модерацию.</p>

                                    <?php foreach($user->pair as $film): ?>
                                        <div class="col-6"><img src="<?=$film['poster']?>"  class="img-fluid rounded" style="width: 150px; height: 200px"alt=""></div>
                                    <?php endforeach;?>
                                    <button class="btn btn-warning mt-3" onclick="delete_user_pair(<?=$user->id?>)">Удалить</button>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div><?php endif; ?></div>
  				    <div class="modal fade" id="movieAddModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
 							 <div class="modal-dialog">
   							 <div class="modal-content">
    							  <div class="modal-header">
        							<h5 class="modal-title" id="exampleModalLabel">Добавить фильм в бд</h5>
       									 <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
      							</div>
      						<div class="modal-body">
                                <form action="/" class="search-m">
                                <div class="container">
                                    <div class="row text-center">

                                            <div class="col-md-7">
                                                <input type="text" required pattern="[0-9]+" name="name-movie" class="h-100" id="movie_input" placeholder="ID фильма на КП">
                                            </div>
                                        <div class="col-md-5">
                                            <input type="submit" class="btn btn-warning">
                                        </div>

                                    </div>
                                </div>
                                </form>

       						    <div class="container">
                                    <div class="row m-2 p-2 b1-warning">
                                        <div class="col-md-5">
                                            <img src="" id="posterUrl" class="img-fluid rounded"alt="">
                                        </div>
                                        <div class="col-md-7">
                                            <div class="row name">
                                                <span id="nameRu"></span>
                                            </div>
                                            <div class="row">
                                                <span id="nameOriginal"></span>
                                            </div>
                                            <div class="row">
                                                <span id="filmLength"></span>
                                            </div>
                                            <div class="row">
                                                <div class="col-6">
                                                    <span id="ratingImdb" class=""></span>
                                                </div>
                                                <div class="col-6">
                                                    <span id="ratingKinopoisk" class=""></span>
                                                </div>

                                            </div>
                                            <div class="row">
                                                <span id="year"></span>
                                            </div>

                                        </div>

                                    </div>
                                    <div class="row  text-center">
                                        <form action="" id="addForm">

                                        </form>
                                    </div>
                                </div>
						    </div>
						  </div>
						</div>
					</div>
  			<div class="col-sm-1"></div>
        </div>
        <div class="row" style="margin: 30px 0 0; overflow: hidden">

            <div class="col-sm-1"></div>
                <div class="col-sm-10 selected mt-3" style="overflow: hidden">
                    <div class="row">
                        <div class="col">
                            <p class="h2">Упущенные возможности</p>
                        </div>
                    </div>
                    <div class="row">
            <div class="your-class" style="height: 250px;">
                <?php foreach($user->advices as $mo): ?>
                <div class="slide-cust" style="">
                    <a href="<?=$mo['url']?>">
                        <img src="<?=$mo['poster']?>" class="img-fluid"  alt="">
                    </a>
                </div>

                <?php endforeach; ?>
            </div>
                </div>
                </div>
            <div class="col-sm-1"></div>
            </div>

  		<div class="row">
  			<div class="col-sm-1"></div>
  			<div class="col-sm-10 p-0">
  				<h4 class="text-center"><?=$id===$id_s ? 'Мои оценки' : 'Оценки '.$user->name?></h4>
  				<table class="table-user-rate table table-hover m-0 ">
  					<thead>
  						<tr>
  							<td>Название</td>
  							<td>Оценка</td>
  							<td>Средний балл</td>
  						</tr>
  					</thead>
  					<tbody>
  						<?php foreach($user->rates as $r):
  							$tmp_id = $r['id_meet']; ?>
  						<tr>
  							<td><a class="mov-nam"href="<?=$r['url']?>"><?=$r['name_m']?></a></td>
  							<td class="rate-ch"><?=$r['rate']?></td>
 
 								<td class="rate-ch"><?=$r['our_rate']?></td>
 								<?php if($id===$id_s):?> 
 								<td><a class="unrate" href="<?=ROOT?>/controller/UserFormController.php?type=unrate&id=<?=$tmp_id?>">Удалить запись</a></td>
 							<?php endif; ?>
 							</tr>
 						<?php endforeach;?>
  					</tbody>
  				</table>
  			</div>
  			<div class="col-sm-1"></div>
  		</div>
  	</div>
<!--    <div class="modal fade" id="answerM" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">-->
<!--        <div class="modal-dialog">-->
<!--            <div class="modal-content">-->
<!--                <div class="modal-header">-->
<!--                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>-->
<!--                </div>-->
<!--                <div class="modal-body">-->
<!--                    <div class="row text-center text-success">-->
<!--                        <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="currentColor" class="bi bi-check-circle" viewBox="0 0 16 16">-->
<!--                            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>-->
<!--                            <path d="M10.97 4.97a.235.235 0 0 0-.02.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05z"/>-->
<!--                        </svg>-->
<!--                    </div>-->
<!--                    <div class="row">-->
<!--                        <p class="answer text-success text-center">-->
<!---->
<!--                        </p>-->
<!--                    </div>-->
<!--                </div>-->
<!---->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->

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
<?php
