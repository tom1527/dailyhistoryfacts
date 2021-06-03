<!DOCTYPE HTML>
<html>
    <head>
        <title>Hello</title>
        <link rel="stylesheet" href="assests/style.css">
    </head>    
    <body>

<?php
var_dump(function_exists('mysqli_connect'));
$host = 'localhost';
$dbname = 'test';
$user = 'root';
$password = 'password';
$charset = 'utf8';
$dbc = mysqli_connect($host, $user, $password, $dbname);

echo (mysqli_connect_error() );
mysqli_set_charset($dbc, 'charset');
if (mysqli_ping($dbc)) { echo "Hello there"; }
$results = mysqli_query($dbc, "SELECT * FROM table1 WHERE recordNumber = 2;");
$row = mysqli_fetch_assoc($results);
echo ($row['message']); 
?>

    </body>
</html>