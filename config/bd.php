<?php 
$conn = new mysqli("localhost", "root", "admin", "kino");
			if($conn->connect_error){
			die("Ошибка: " . $conn->connect_error);
			}
	if($conn->connect_error) die("ERROROROR");
function Query_try($query) //запрос к бд и прерывание в случае ошибки
{
	if(!($result = mysqli_query($GLOBALS['conn'], $query)))
	{
		die("Query error");
	}
	return $result;
}
?>