<?php 
	require 'config/bd.php';
	

	Class GetBase extends DB
	{
		function __construct()
		{
			parent::__construct();
		}

		public function GetAllMovies() //функция получения супер-массива с данными о всех встречах
		{
			$meetings= array();
			$descr_q = "SELECT id_meet, url, id_m, name_m, original, year_of_cr, name_d,duration,rating, our_rate,rating_kp, poster from movie
					join director on id_d=director join meeting using(id_m);";  //получение карточки фильма

			$exp_q = "SELECT id_rate, id_meet, id_exp, avatar, name, rate from expert join expert_rate on id_e=id_exp where rate is not null   order by id_meet, rate desc;";  // получение списка эксепрт-оценка

			$genre_q ="SELECT name_g, id_meet from genre  join gen_to_mov using(id_g) join meeting using(id_m) order by id_meet;"; //получение списка жанров для фильма
			$citates = "SELECT text, author, id_m from citate";
			$citates = $this->Query_try($citates);

			$res_description=$this->Query_try($descr_q);
			$res_experts = $this->Query_try($exp_q);
			$res_genres = $this->Query_try($genre_q);
			$i=0;
			while ($movie = mysqli_fetch_assoc($res_description)) 
			{
				$movie['rates']=array();
				$movie['genre']=array();
				$movie['citate']=array();
				$movie['num'] = $i;
				$meetings[$movie['id_meet']] = $movie;
				++$i;

		
			}
			while($cit = mysqli_fetch_assoc($citates))
			{
				$meetings[$cit['id_m']]['citate'][] = array(
					'text'=> $cit['text'],
					'author' =>$cit['author']);
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
		public function GetMovieDescription($id)  //получение данных на один фильм
		{
			//$movie= array();
			$descr_q = "SELECT `id_meet`, `url`, `id_m`, `name_m`, `original`, `year_of_cr`, `name_d`,`duration`,`rating`, `our_rate`,`rating_kp`, `poster` from `movie`
					join `director` on `id_d`=`director` join `meeting` using(`id_m`) where `id_m`=".$id; 



			$res_description=$this->Query_try($descr_q);
			
			$movie = mysqli_fetch_assoc($res_description);
			$movie['rates']=array();
			$movie['genre']=array();
			return $movie;
		}
		public function GetMovieGenres($id)
		{
			$genres = array();
			$genre_q ="SELECT `name_g`, `id_meet` from `genre`  join `gen_to_mov` using(`id_g`) join `meeting` using(`id_m`) where `id_m`=".$id; //получение списка жанров для фильма
			$res_genres = $this->Query_try($genre_q);
			while($res = mysqli_fetch_assoc($res_genres))
			{
				$genres[] = $res['name_g'];
			}
			return $genres;
		}
		public function GetExpertsRate($id) // получение списка эксепрт-оценка
		{
			$experts = array();
			$exp_q = "SELECT `id_rate`, `id_meet`, `id_exp`, `avatar`, `name`, `rate` from `expert` join `expert_rate` on `id_e`=`id_exp` join `meeting` using(`id_meet`)  where `id_m`=".$id." order by `rate` desc";  
			$res_experts = $this->Query_try($exp_q);
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
		public function GetAllThirds()  //получения списка пользовательских троек
		{
			$thirds = array();
			$query = "SELECT `movie`.*, `name`, `name_d`, `thirds`.`selected` from `movie` join `thirds` on `id_m`=`first` or `id_m`=`second` or `id_m`=`third` join `expert` using(`id_e`) join `director` on `director`=`id_d` order by `id_t` desc, `id_m` asc";
			$query_g = "SELECT name_g, id_m from movie join thirds on id_m=first or id_m=second or id_m=third join gen_to_mov using(id_m) join genre using(id_g) order by id_t desc, id_m asc ";
			$gen_res = $this->Query_try($query_g);
			$thirds_res = $this->Query_try($query);
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

		public function GetAcceptedRate($id)  //получение списка фильмов, на которых разрешено поставить оценку
		{
			$query = "select name_m, id_meet from movie join meeting using(id_m) left join (select * from expert_rate where id_exp = '$id') as e using(id_meet) where id_rate is NULL;";
			$res = $this->Query_try($query);
			return $res;
		}
		public function GetUserRates($id)  //получение оценок одного пользователя
		{
			$query_m = "SELECT  `name_m`, `our_rate`, `rate`, `id_meet`, `url` FROM `movie` join `meeting` USING(`id_m`) join `expert_rate` using(`id_meet`) where `id_exp` = '$id' and rate is not null  order by rate desc";
			$res_m = $this->Query_try($query_m);
			return($res_m);
		}

		
		public function GetAllRates()  //получение оценок
		{
			$query_u = "SELECT `name_m`, `our_rate`,`rating`,`rating_kp`, `rate`, `name` FROM `movie` join `meeting` USING(`id_m`) join `expert_rate` using(`id_meet`) join expert on id_e=id_exp order by name, id_m";
			$query = "select count(*) as n from meeting";
			$res = mysqli_fetch_assoc($this->Query_try($query));
			$num =  $res['n'];
			$res_u = $this->Query_try($query_u);
			$res_m = array(
				'user'=> array(),
				'avg'=> array(),
				'movies'=>array());
				
					
			$i=0;
			while($i<6)
			{
				for($j = 0; $j<$num; ++$j)
				{
					$res = mysqli_fetch_assoc($res_u);
					$res_m['user'][$i]['data'][]=$res['rate'];
					$res_m['user'][$i]['name'] = $res['name'];

				}
				++$i;
					
			}
			for($j = 0; $j<$num; ++$j)
				{
					$res = mysqli_fetch_assoc($res_u);
					$res_m['user'][$i]['data'][]=$res['rate'];
					$res_m['user'][$i]['name'] = $res['name'];
					$res_m['avg']['data'][]= $res['our_rate'];
					$res_m['avg']['name']= "Оценка сообщества";
					$res_m['movies'][]=$res['name_m'];
					$res_m['kp']['name']="Кинопоиск";
					$res_m['kp']['data'][] = $res['rating_kp'];
					$res_m['imdb']['name']="IMDB";
					$res_m['imdb']['data'][] = $res['rating'];


				}
			//debug($res_m);
			return($res_m);
		}

		public function GetUserChartRates($id)  //получение оценок одного пользователя
		{
			$query_u = "SELECT  `name_m`, `rate`, `name`, `our_rate` FROM `movie` join `meeting` USING(`id_m`) join `expert_rate` using(`id_meet`) join expert on id_e=id_exp where id_exp = '$id'";
			$res_u = $this->Query_try($query_u);
			$res_m = array(
				'user'=>array(
					'data'=> array()
				),
				'avg'=>array(
					'data'=> array(),
					'name'=>"Средний балл сообщества",
				),
				'movie'=>array()
			);
				
				

			while ($row = mysqli_fetch_assoc($res_u))
			{
				$res_m['user']['data'][]=$row['rate'];
				$res_m['user']['name']=$row['name'];
				$res_m['avg']['data'][]=$row['our_rate'];
				//$res_m['avg']['name']="Средний балл сообщества";
				$res_m['movie'][]=$row['name_m'];	
			}
			return($res_m);
		}
		public function GetUserInfo($id)  //получение информации о польователе
		{
			$query_test = "SELECT count(*) as a from expert_rate WHERE id_exp = '$id'";
			$res_nam = $this->Query_try($query_test);
			$nam = mysqli_fetch_assoc($res_nam);
			if($nam['a']==0){ 	
				$query_data = "SELECT name, avatar from expert where id_e = '$id'";
				$res_data = $this->Query_try($query_data);
				$dat = mysqli_fetch_assoc($res_data);
				$dat['module']=0;
				$dat['amount']=0;
			} else 
			{
			$query_data = "SELECT ROUND(AVG(rate), 1) as module, count(id_meet) as amount, name, avatar from expert_rate join expert on id_e=id_exp where id_exp = '$id'";
					$res_data = $this->Query_try($query_data);
			$dat = mysqli_fetch_assoc($res_data); 
			}
			return $dat;
		}

		function __destruct()
		{
			parent::__destruct();
		}
	}
	
	function debug($arr)
	{
		echo "<pre>";
		print_r($arr);
		echo "</pre>";
	}

?>

