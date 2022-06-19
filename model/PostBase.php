<?php 

	require '../config/bd.php';

	class PostBase extends DB 
	{
		function __construct()
		{
			parent::__construct();
		}

		public function AddMeet()
		{
			$id=$_POST['film'];
			$q = "INSERT INTO meeting values(NULL, '$id')";
			$q = $this->Query_try($q);
			header('Location: ../admin.php');
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
			header('Location: ../admin.php?name='.$id);
		}
		public function AddParseFile()
		{
		 	$path = $_FILES['file-to-parse']['name'];
        	if (!move_uploaded_file($_FILES['file-to-parse']['tmp_name'], "../parser/pages/".$path)) 
        	{
        		echo "Err";
       		}
			$_SESSION['file'] = $path;
      		header('Location: ../admin.php?name='.$path);
		}

		public function AddMovie()
		{
			$name = $_POST['name']; 
			$or = $_POST['original']; 
			$dir = $_POST['director']; 
			$ye = $_POST['year']; 
			$dur = $_POST['duration']; 
			$url = $_POST['url']; 
			$kp = $_POST['kinopoisk']; 
			$imdb = $_POST['imdb']; 
			$file = $_POST['file'];
			$descr = $_POST['descr'];
			echo $file;
		    $path = "image/".$or.".jpg";
		        if (!move_uploaded_file($_FILES['avatar']['tmp_name'], "../".$path)) {
		        		error_log("d");
		        }
		    $increment = "SELECT id_m from movie order by id_m desc limit 1";
		    $increment = $this->Query_try($increment);
		    $increment = mysqli_fetch_assoc($increment);
		    $i = $increment['id_m']+1;

		    $query = "INSERT INTO `movie` (`id_m`, `name_m`, `rating`, `rating_kp`, `year_of_cr`, `duration`, `director`, `our_rate`, `original`, `poster`, `url`, `description`) VALUES ('$i', '$name', '$imdb', '$kp', '$ye', '$dur', '$dir', NULL, '$or', '$path', '$url', '$descr')";
		    $d = $this->Query_try($query);
		    if(!$d) {die("TI SUKA TUPOY CHTOLE");}
		    foreach($_POST['check'] as $gen)
		    {
		    	$q = "INSERT INTO `gen_to_mov` (`id_s`, `id_g`, `id_m`) VALUES (NULL, '$gen', '$i')";
		    	$d = $this->Query_try($q);
			}
			unlink('../parser/pages/'.$name.'.html');
		    header('Location: ../admin.php');
		}
		
		public function AddRate()
		{
			$meet = $_POST['movie'];
			$rate = $_POST['rating'];
			$id = $_SESSION['user']['id'];
			$query = "INSERT INTO `expert_rate`(`id_rate`, `id_meet`, `id_exp`, `rate`) VALUES(NULL, '$meet', '$id', '$rate')";

			$d = $this->Query_try($query);
			if(!$d) {die("Query Error!");}
			header("Location: ../profile.php?id=".$_SESSION['user']['id']);
		}

		public function Unrate()
		{
			$id=$_SESSION['user']['id'];
			if(!isset($_GET['id']))
			{
				header('Location: ../profile.php?id='.$id);
			}
			$id_m = $_GET['id'];

			$query = "DELETE FROM `expert_rate` where `id_meet` = '$id_m' and `id_exp` = '$id'";
			$res = $this->Query_try($query);
			if(!$res)
			{
				echo "Fatal error";
			} else
			{
				header('Location: ../profile.php?id='.$id);
			}
		}
			
		public function UpdateProfile()
		{
			if(!$_POST['name'])
			{
				$name = $_SESSION['user']['name'];
			}
			else 
			{
				$name = $_POST['name'];
			}
            $id = $_SESSION['user']['id'];
			if(!$_POST['old-pass'])
				{
					header('Location: ../profile.php?id='.$id);
				}
			//$id = $_SESSION['user']['id'];
			$q = "SELECT password from expert where id_e ='$id'";
			$pw = $this->Query_try($q);
			$pw = mysqli_fetch_assoc($pw);

			if($pw['password']!=md5($_POST['old-pass']))
				{
					header('Location: ../profile.php?id='.$id);
				}
			$pass = $pw['password'];
			echo $pass;
			if(isset($_POST['new-pass']))
			{
				if($_POST['new-pass']==$_POST['new-pass-confirm'])
				{
					$pass = md5($_POST['new-pass']);
				}
				else
				{
					header('Location: ../profile.php?id='.$id);
				}
			}
			
			print_r($_FILES['avatar']);
		    $path = $_SESSION['user']['login'].".jpg";
		    if(isset($_FILES['avatar']))
		    {
			    if (!move_uploaded_file($_FILES['avatar']['tmp_name'], "../uploads/".$path))
			    {
			        $_SESSION['message'] = $path;
			        header('Location: ../profile.php');
			    }
			}	
		    $query = "UPDATE `expert` set `avatar` = '$path', `name`= '$name', `password` = '$pass' where `id_e` = '$id';";
		    $d = $this->Query_try($query);
	        $_SESSION['user']['avatar'] = $path;
	        $_SESSION['user']['name'] = $name;
	        header('Location: ../profile.php?id='.$id);
		}	

        public function NewMessage()
        {
            $user = $_POST['id'];
            $re = $_POST['re'];
            $text = $_POST['text'];
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
            header('Location: ../feedback.php?page=1&type='.$type);
        }

        function __destruct()
		{
			parent::__destruct();
		}
	}