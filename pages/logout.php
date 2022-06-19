<?php
session_start();
unset($_SESSION['user']);
echo 'logout';
header('Location: /');