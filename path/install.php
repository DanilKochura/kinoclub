<?php 
session_start();
	 $path = $_FILES['file-to-parse']['name'];
        if (!move_uploaded_file($_FILES['file-to-parse']['tmp_name'], "../parser/pages/".$path)) {
        		error_log("d");
        }
$_SESSION['file'] = $path;
      header('Location: ../admin.php?name='.$path);
?>