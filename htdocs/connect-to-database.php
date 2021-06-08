<?php
$host = 'localhost';
$dbname = 'interestingfacts';
$user = 'root';
$password = 'password';
$charset = 'utf8';
$dbc = mysqli_connect($host, $user, $password, $dbname);
mysqli_set_charset($dbc, $charset);
?>