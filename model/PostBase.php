<?php 

	require '/var/www/u131898/data/www/imdibil.ru/config/bd.php';

	class PostBase extends DB 
	{
		function __construct()
		{
			parent::__construct();
		}

        public function QuizResult($type, $id_u, $id_m)
        {
            $this->Query_try("INSERT INTO `quiz_results`(`type`, `id_e`, `id_m`) VALUES('$type', '$id_u', '$id_m')");
        }
        public function AddThird($id1, $id2, $id3, $id_e)
        {

            $event = uniqid();
            $this->Query_try("INSERT INTO thirds(first, second, third, selected, id_e, checked, id_event) values ('$id1','$id2','$id3',NULL, '$id_e', 0, '$event')");
//            header('Location: ../admin');
        }

		public function AddMeet()
		{
			$id=$_POST['film'];
			$q = "INSERT INTO meeting values(NULL, '$id')";
			$q = $this->Query_try($q);
			header('Location: ../admin/');
		}

		public function AddDirector()
		{
			$id=$_POST['name'];
			$val = "SELECT COUNT(*) as co FROM director WHERE name_d='$id'";
			$increment = "SELECT id_d from director order by id_d desc limit 1";
			$increment = $this->Query_try($increment);
			$i = mysqli_fetch_assoc($increment);
			$num = $i['id_d']+1;
			$query = "INSERT INTO director values('$num', '$id')";
			$test = $this->Query_try($val);
			$test = mysqli_fetch_assoc($test);
			if($test['co']==0)
			{
				$id=$this->Query_try($query);
			}
			header('Location: ../admin?name='.$id);
		}

		public function AddParseFile()
		{
		 	$path = $_FILES['file-to-parse']['name'];
        	if (!move_uploaded_file($_FILES['file-to-parse']['tmp_name'], "../parser/pages/".$path)) 
        	{
        		echo "Err";
       		}
			$_SESSION['file'] = $path;
      		header('Location: ../admin?name='.$path);
		}

		public function AddMovie()
		{
			$name = $_POST['name']; 
			$or = $_POST['original'] ?: '';
			$dir = $_POST['director']; 
			$ye = $_POST['year']; 
			$dur = $_POST['duration']; 
			$url = $_POST['url']; 
			$kp = $_POST['kinopoisk']; 
			$imdb = $_POST['imdb']; 
			$file = $_POST['file'];
			$descr = $_POST['descr'];
            $fname = $or ?: uniqid();
			echo $file;
            $pa = '../';
            $root = 'https://imdibil.ru/';
		    $path = "image/".$fname.".jpg";
		        if (!move_uploaded_file($_FILES['avatar']['tmp_name'], $pa.$path)) {
		        		error_log("d");
                        echo $pa.$path;
                        exit;
		        }
		    $increment = "SELECT id_m from movie order by id_m desc limit 1";
		    $increment = $this->Query_try($increment);
		    $increment = mysqli_fetch_assoc($increment);
		    $i = $increment['id_m']+1;

		    $query = "INSERT INTO `movie` (`id_m`, `name_m`, `rating`, `rating_kp`, `year_of_cr`, `duration`, `director`, `our_rate`, `original`, `poster`, `url`, `description`) VALUES ('$i', '$name', '$imdb', '$kp', '$ye', '$dur', '$dir', NULL, '$or', '".$root.$path."', '$url', '$descr')";
		    $d = $this->Query_try($query);
		    if(!$d) {die("TI SUKA TUPOY CHTOLE");}
		    foreach($_POST['check'] as $gen)
		    {
		    	$q = "INSERT INTO `gen_to_mov` (`id_s`, `id_g`, `id_m`) VALUES (NULL, '$gen', '$i')";
		    	$d = $this->Query_try($q);
			}
			unlink('../parser/pages/'.$name.'.html');
		    header('Location: ../admin');
		}
		
		public function AddRate($rate, $meet, $id)
		{

			$query = "INSERT INTO `expert_rate`(`id_rate`, `id_meet`, `id_exp`, `rate`) VALUES(NULL, '$meet', '$id', '$rate')";

			$d = $this->Query_try($query);
			if(!$d) {
                die("Query Error!");
            }

//			header("Location: ../profile/".$_SESSION['user']['id']);
		}

		public function Unrate()
		{
			$id=$_SESSION['user']['id'];
			if(!isset($_GET['id']))
			{
				header('Location: ../profile/'.$id);
			}
			$id_m = $_GET['id'];

			$query = "DELETE FROM `expert_rate` where `id_meet` = '$id_m' and `id_exp` = '$id'";
			$res = $this->Query_try($query);
			if(!$res)
			{
				echo "Fatal error";
			} else
			{
				header('Location: ../profile/'.$id);
			}
		}
			
		public function UpdateProfile()
		{
            $id = $_SESSION['user']['id'];
            if(!$_POST['old-pass'])
            {
                header('Location: ../profile/'.$id);
                exit;
            }
			if(!$_POST['name'])
			{
				$name = $_SESSION['user']['name'];
			}
			else 
			{
				$name = trim(html_entity_decode($_POST['name']), ';');
			}



			//$id = $_SESSION['user']['id'];
			$q = "SELECT password from expert where id_e ='$id'";
			$pw = $this->Query_try($q);
			$pw = mysqli_fetch_assoc($pw);

			if($pw['password']!=md5($_POST['old-pass']))
				{
					header('Location: ../profile/'.$id);
                    exit;
				}

			$pass = $pw['password'];
			//echo $pass;
			if($_POST['new-pass'])
			{

				if($_POST['new-pass']==$_POST['new-pass-confirm'])
				{

					$pass = md5($_POST['new-pass']);

				}
				else
				{
					header('Location: ../profile/'.$id);
                    exit;
				}
			}
			
			print_r($_FILES['avatar']);
		    $path = $_SESSION['user']['login'].".jpg";
		    if($_FILES['avatar']['name'])
		    {

			    if (!move_uploaded_file($_FILES['avatar']['tmp_name'], "../uploads/".$path))
			    {
			        $_SESSION['message'] = $path;
			        header('Location: ../profile');
			    }
			}	
		    $query = "UPDATE `expert` set `avatar` = '$path', `name`= '$name', `password` = '$pass' where `id_e` = '$id';";
           
            $d = $this->Query_try($query);
	        $_SESSION['user']['avatar'] = $path;
	        $_SESSION['user']['name'] = $name;
	        header('Location: ../profile/'.$id);
		}	

        public function NewMessage()
        {
            $user = $_POST['id'];
            $re = $_POST['re'];
            $text = html_entity_decode($_POST['text']);
            //$file = $_POST['id'];
            $type=$_POST['type'];
            $path = null;
            debug($_FILES);
            if(isset($_FILES['atatch']))
            {
                echo 'ok';
                $path = uniqid('photo').'.jpg';
                echo '<br>'.$path.'<br>';
                if (!move_uploaded_file($_FILES['atatch']['tmp_name'], "../uploads/messages/".$path))
                {
                    echo 'pizdec';
                }
            }

            $query = "INSERT INTO `forum` 
    (`id`, `id_u`, `re_m`, `text_m`, `date_o`, `part`, `attachments`)
VALUES (NULL, '$user', '$re', '$text', CURRENT_TIMESTAMP, '$type', '$path')";
            echo $query;
            $t = $this->Query_try($query);
            header('Location: ../feedback?page=1&type='.$type);
        }

        public function DeleteThird($id)
        {
           $res =  $this->Query_try("DELETE from thirds where id_e = '$id' and checked = 0");
            if($this->affected() == 0)
            {
                echo json_encode(array('state'=>0, 'text'=>'Произошла ошибка. Пожалуйста, обновите страницу!'));
                exit;
            }
        }
        public function DeletePair($id)
        {
           $res =  $this->Query_try("DELETE from pairs where id_exp = '$id'");
            if($this->affected() == 0)
            {
                echo json_encode(array('state'=>0, 'text'=>'Произошла ошибка.. Пожалуйста, обновите страницу!'));
                exit;
            }
        }
        public function NewRates()
        {

            $id_m = $_POST['meet'];
//            debug($_POST);
//            echo $id_m;
//            exit;
            for($i=1; $i<count($_POST['rate'])+1; $i++){
                $rate = $_POST['rate'][$i-1];
                $this->Query_try("INSERT INTO `expert_rate`(`id_meet`, `id_exp`, `rate`) VALUES ('$id_m', '$i', '$rate')");
                header('Location: ../admin');
            }
        }

        public function vote($id_event, $id_m, $id_e)
        {
            $class = $this->Query_try("SELECT class from expert where id_e='$id_e'");
            $user = $class->fetch_assoc();
            if($user['class']!=1)
            {
                echo json_encode(array('state'=> 0, 'text' => 'Нерезиденты не могут голосовать в этой тройке'));
                exit;
            }
            $third_check = $this->Query_try("SELECT * from vote where id_event = '$id_event' and state = 1");
            if($third_check->num_rows == 0)
            {
                echo json_encode(array('state'=> 0, 'text'=>'Голосование уже завершилось!'));
                exit;
            }
            $id_vote = ($third_check->fetch_assoc())['id_v'];
            $check_adv = $this->Query_try("SELECT expert.id_e from expert join thirds using(id_e) where id_event = '$id_event'");
            if(($check_adv->fetch_assoc())['id_e'] == $id_e)
            {
                echo json_encode(array('state'=> 0, 'text' => 'Ты не можешь голосовать в этой тройке'));
                exit;
            }
            $check_voted = $this->Query_try("SELECT * from votelist where id_vote = '$id_vote' and id_e = '$id_e'");
            if($check_voted->num_rows > 0)
            {
                echo json_encode(array('state'=> 0, 'text' => 'Ты уже проголосовал, мудила!'));
                exit;
            }
            $this->Query_try("INSERT INTO votelist(id_e, id_vote, choise) values('$id_e', '$id_vote', '$id_m')");
        }

        public function AddPair($f1, $f2, $id, $event = null)
        {
            $vote = uniqid();
            $this->Query_try("INSERT into pairs(id_exp, first, second, id_event, id_event_vote) values ('$id', '$f1', '$f2', '$event', '$vote')");
        }

        public function Shuffle()
        {
            $pairs = $this->Query_try("SELECT poster, url, name_m, id_m   from pairs join movie on (first = id_m or second = id_m) where id_exp is not null");
            while($row = $pairs->fetch_assoc())
            {
                $movs1[] = $row;
                $movs2[] = $pairs->fetch_assoc();
            }
//debug($movs1);
//debug($movs2);
            shuffle($movs1);
            shuffle($movs2);
            $total = [$movs1, $movs2];
//debug($total);

            foreach ($total as $ar)
            {
//    debug($ar);
                for($k=0; $k<8; $k+=2)
                {
                    $a = $k+1;
                    $id = uniqid();
                    $this->Query_try("INSERT INTO pairs(id_exp, first, second, id_event, id_event_vote) values(null, '{$ar[$k]['id_m']}', '{$ar[$a]['id_m']}', 'first', '$id')");
                }
            }
        }
        function __destruct()
		{
			parent::__destruct();
		}
	}