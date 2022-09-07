<?php
define('DB_HOST',"localhost");
define('DB_USER',"root");
define('DB_PASS',"admin");
define('DB_NAME', "kin");
Class DB
	{
		private $conn;
		function __construct()
		{
			$this->conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
			if($this->conn->connect_error) 
			{
				die("Failed to connect with database");
			}
		}

		public function Query_try($query) //запрос к бд и прерывание в случае ошибки
		{
			if(!($result = mysqli_query($this->conn, $query)))
			{
                echo $query;
				die("Query error");
			}
			return $result;
		}
        public function insrtid()
        {
            return $this->conn->insert_id;
        }
        public function affected()
        {
            return $this->conn->affected_rows;
        }
		function __destruct()
		{
			mysqli_close($this->conn);
		}

	}

function debug($array)
{
    echo '<pre>';
    print_r($array);
    echo '</pre>';
}
?>