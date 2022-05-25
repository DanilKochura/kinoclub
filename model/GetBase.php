<?php 
	require 'config/bd.php';
	function GetAllMovies() //функция получения супер-массива с данными о всех фильмах
	{
		$meetings= array();
		$descr_q = "SELECT id_meet, url, id_m, name_m, original, year_of_cr, name_d,duration,rating, our_rate,rating_kp, poster from movie
				join director on id_d=director join meeting using(id_m);";  //получение карточки фильма

		$exp_q = "SELECT id_rate, id_meet, id_exp, avatar, name, rate from expert join expert_rate on id_e=id_exp  order by id_meet, rate desc;";  // получение списка эксепрт-оценка

		$genre_q ="SELECT name_g, id_meet from genre  join gen_to_mov using(id_g) join meeting using(id_m) order by id_meet;"; //получение списка жанров для фильма

		$res_description=Query_try($descr_q);
		$res_experts = Query_try($exp_q);
		$res_genres = Query_try($genre_q);
		while ($movie = mysqli_fetch_assoc($res_description)) {
			$movie['rates']=array();
			$movie['genre']=array();
			$meetings[$movie['id_m']] = $movie;

	
		}

		while($res = mysqli_fetch_assoc($res_genres))
		{
			$meetings[$res['id_meet']]['genre'][] = $res['name_g'];
		}
	
		while($res = mysqli_fetch_assoc($res_experts))
		{
			$expert = [
				'avatar' => $res['avatar'],
				'name' => $res['name'],
				'id' => $res['id_exp'],
				'rate' =>$res['rate']];
			$meetings[$res['id_meet']]['rates'][] = $expert;

		}
		return $meetings;
	}
	function GetMovieDescription($id)
	{
		//$movie= array();
		$descr_q = "SELECT `id_meet`, `url`, `id_m`, `name_m`, `original`, `year_of_cr`, `name_d`,`duration`,`rating`, `our_rate`,`rating_kp`, `poster` from `movie`
				join `director` on `id_d`=`director` join `meeting` using(`id_m`) where `id_m`=".$id;  //получение карточки фильма



		$res_description=Query_try($descr_q);
		
		$movie = mysqli_fetch_assoc($res_description);
		$movie['rates']=array();
		$movie['genre']=array();
		return $movie;
	}
	function GetMovieGenres($id)
	{
		$genres = array();
		$genre_q ="SELECT `name_g`, `id_meet` from `genre`  join `gen_to_mov` using(`id_g`) join `meeting` using(`id_m`) where `id_m`=".$id; //получение списка жанров для фильма
		$res_genres = Query_try($genre_q);
		while($res = mysqli_fetch_assoc($res_genres))
		{
			$genres[] = $res['name_g'];
		}
		return $genres;
	}
	function GetExpertsRate($id)
	{
		$experts = array();
		$exp_q = "SELECT `id_rate`, `id_meet`, `id_exp`, `avatar`, `name`, `rate` from `expert` join `expert_rate` on `id_e`=`id_exp` join `meeting` using(`id_meet`)  where `id_m`=".$id." order by `rate` desc";  // получение списка эксепрт-оценка
		$res_experts = Query_try($exp_q);
		while($res = mysqli_fetch_assoc($res_experts))
			{
				$exp = [
					'avatar' => $res['avatar'],
					'name' => $res['name'],
					'id' => $res['id_exp'],
					'rate' =>$res['rate']];
				$experts[] = $exp;

			}
			return $experts;
	}
	function GetAllThirds()
	{
		$thirds = array();
		$query = "SELECT `movie`.*, `name`, `name_d`, `thirds`.`selected` from `movie` join `thirds` on `id_m`=`first` or `id_m`=`second` or `id_m`=`third` join `expert` using(`id_e`) join `director` on `director`=`id_d` order by `id_t` desc, `id_m` asc";
		$query_g = "SELECT name_g, id_m from movie join thirds on id_m=first or id_m=second or id_m=third join gen_to_mov using(id_m) join genre using(id_g) order by id_t desc, id_m asc ";
		$gen_res = Query_try($query_g);
		$thirds_res = Query_try($query);
		$i=0;
		$j=0;
		while($res = mysqli_fetch_assoc($thirds_res))
		{
			if($i==3)
			{
				$i=0;
				++$j;
			}
			$thirds[$j][]=$res;
			++$i;
				
		}
		$i = 0;
		$j=0;
		$res = mysqli_fetch_assoc($gen_res);
		$id = $res['id_m'];
		for($k = 0; $k<($gen_res->num_rows)-1; ++$k){
			if($id!=$res['id_m'])
			{
				$id=$res['id_m'];
				++$i;
				if($i==3)
				{
					$i=0;
					++$j;
				}
			}
			$thirds[$j][$i]['genre'][]=$res['name_g'];
			$res = mysqli_fetch_assoc($gen_res);
			//debug($res);
		}
		return $thirds;
	}
	function debug($arr)
	{
		echo "<pre>";
		print_r($arr);
		echo "</pre>";
	}

?>

