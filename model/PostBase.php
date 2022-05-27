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
			
			
		function __destruct()
		{
			parent::__destruct();
		}
	}