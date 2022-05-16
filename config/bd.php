<?php 
$conn = new mysqli("localhost", "root", "admin", "kino");
			if($conn->connect_error){
			die("Ошибка: " . $conn->connect_error);
			}
	if($conn->connect_error) die("ERROROROR");
?>