<?php 
	require 'config/bd.php';
	

	Class GetBase extends DB
	{
		function __construct()
		{
			parent::__construct();
		}

		public function GetAllMovies($sort , $order) //функция получения супер-массива с данными о всех встречах
		{
			$meetings= array();
			$descr_q = "SELECT id_meet, url, id_m, name_m, original, year_of_cr, name_d,duration,rating, our_rate,rating_kp, poster from movie
					join director on id_d=director join meeting using(id_m) order by ".$sort." ".$order;  //получение карточки фильма

			$exp_q = "SELECT id_rate, id_meet, id_exp, avatar, name, rate from expert join expert_rate on id_e=id_exp join meeting USING(id_meet) join movie using(id_m) where rate is not null order by ".$sort." ".$order;  // получение списка эксепрт-оценка

			$genre_q ="SELECT name_g, id_meet from genre  join gen_to_mov using(id_g) join meeting using(id_m) join movie using(id_m) order by  ".$sort." ".$order; //получение списка жанров для фильма
			$citates = "SELECT text, author, id_meet from citate join movie using(id_m) join meeting using(id_m) order by ".$sort." ".$order;
			$citates = $this->Query_try($citates);

			$res_description=$this->Query_try($descr_q);
			$res_experts = $this->Query_try($exp_q);
			$res_genres = $this->Query_try($genre_q);
			$i=0;
			while ($movie = mysqli_fetch_assoc($res_description)) 
			{
				$movie['num'] = $movie['id_meet'];
				$movie['rates']=array();
				$movie['genre']=array();
				$movie['citate']=array();

				$meetings[$movie['id_meet']] = $movie;
				++$i;


		
			}
			while($cit = mysqli_fetch_assoc($citates))
			{
				$meetings[$cit['id_meet']]['citate'] = array(
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
		public function GetMoviesPage($sort , $order, $start, $limit=null) //функция получения супер-массива с данными о встречах постранично
		{
			$meetings= array();

			//$start = $limit ? $limit*($page-1) : 0;
			$page = ($limit == 'all') ? "" : " LIMIT ".$limit." OFFSET ".$start;
			$descr_q = "SELECT id_meet, url, id_m, name_m, original, year_of_cr, name_d,duration,rating, our_rate,rating_kp, poster from movie
					join director on id_d=director join meeting using(id_m) order by ".$sort." ".$order.$page;  //получение карточки фильма

			$res_description=$this->Query_try($descr_q);

			$i=0;
			while ($movie = mysqli_fetch_assoc($res_description))
			{
				$movie['num'] = $movie['id_meet'];
				$movie['rates']=array();
				$movie['genre']=array();
				$movie['citate']=array();


				$id = $movie['id_m'];
				++$i;
				$exp_q = "SELECT id_rate, id_meet, id_exp, avatar, name, rate from expert join expert_rate on id_e=id_exp join meeting USING(id_meet) join movie using(id_m) where rate is not null and id_m='$id' order by rate desc";;
				// получение списка эксепрт-оценка
				$res_experts = $this->Query_try($exp_q);
				while($res = mysqli_fetch_assoc($res_experts))
				{
					$expert = [
						'avatar' => $res['avatar'],
						'name' => $res['name'],
						'id' => $res['id_exp'],
						'rate' =>$res['rate']];
					$movie['rates'][] = $expert;

				}

				$genre_q ="SELECT name_g, id_meet from genre  join gen_to_mov using(id_g) join meeting using(id_m) join movie using(id_m) where id_m='$id'";
				$res_genres = $this->Query_try($genre_q);
				while($res = mysqli_fetch_assoc($res_genres))
				{
					$movie['genre'][] = $res['name_g'];
				}

				$citates = "SELECT text, author, id_meet from citate join movie using(id_m) join meeting using(id_m) where id_m='$id'";;
				$citates = $this->Query_try($citates);
				while($cit = mysqli_fetch_assoc($citates))
				{
					$movie['citate'] = array(
						'text'=> $cit['text'],
						'author' =>$cit['author']);
				}
				$meetings[$movie['id_meet']]=$movie;




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
			$query = "SELECT `movie`.*, `name`, `name_d`, `thirds`.`selected` from `movie` join `thirds` on `id_m`=`first` or `id_m`=`second` or `id_m`=`third` join `expert` using(`id_e`) join `director` on `director`=`id_d`  where checked = 1 order by `id_t` desc, `id_m` asc";
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
				$query_g = "select name_g from genre join gen_to_mov using(id_g) where id_m='{$res['id_m']}'";
				$res_g=$this->Query_try($query_g);
				$gen = array();
				while($roow = mysqli_fetch_assoc($res_g))
				{
					$gen[]=$roow['name_g'];
				}
				$res['genre'] = $gen;


				$thirds[$j][]=$res;
				++$i;
					
			}

			return $thirds;
		}



		public function GetMeetRates($id)
		{
			$rates = [];
			$r = $this->Query_try("SELECT name, id_e, rate FROM `expert` join expert_rate on id_e=id_exp where id_meet = '$id' order by id_e");
			while($res = mysqli_fetch_assoc($r))
			{
				$rates[$res['id_e']] = $res['rate'];
			}
			return $rates;
		}
		public function GetAllRates()  //получение оценок
		{
			$query_u = "SELECT `name_m`, `our_rate`,`rating`,`rating_kp`, `rate`, `name` FROM `movie` join `meeting` USING(`id_m`) join `expert_rate` using(`id_meet`) join expert on id_e=id_exp order by name, id_meet";
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

		public function GetSomeMessages($page, $type)
		{
			$result = array();
			$p = intval($page)-1;
			$limit = 10;
			$start = $limit * $p;
			$query = "SELECT * from forum join expert on id_u=id_e where part='$type' limit ". $limit ." OFFSET ".$start;
			$res = $this->Query_try($query);
			while($row = mysqli_fetch_assoc($res))
			{
				$result[]=$row;
			}
			return $result;

		}

		public function GetGameFilms()
		{
			$films = array();
			$res = $this->Query_try("SELECT name_m as name, id_m as id, poster from movie join meeting USING(id_m)");
			while($row = $res->fetch_assoc())
			{
				$i =  (int)$row['id'];
				$films[]= $row;
			}
			return json_encode($films);
		}

		function __destruct()
		{
			parent::__destruct();
		}
	}
	


?>

