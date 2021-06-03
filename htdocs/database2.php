<!DOCTYPE HTML>
<html>
    <head>
        <title>Market</title>
        <link rel="stylesheet" href="assests/style.css">
    </head>    
    
    <body>
    <h1>Market</h1>
<?php
$host = 'localhost';
$dbname = 'marketproject';
$user = 'root';
$password = 'password';
$charset = 'utf8';
$dbc = mysqli_connect($host, $user, $password, $dbname);

mysqli_set_charset($dbc, 'charset');
$results = mysqli_query($dbc, "SELECT * FROM table1 WHERE item = 'milk';");
$row = mysqli_fetch_assoc($results);
echo 'Price of selected item = ', $row['price']; 
?>

<h2>Items List</h2>
<?php
// $allItems = array();
$results2 = mysqli_query($dbc, "SELECT * FROM table1");
while ($row = mysqli_fetch_assoc($results2)) {
    $allItems[] = $row['item'];
}
echo 'does this even work';
// echo $results2;
foreach($allItems as $item){
    echo "<p>$item<p>";
}
var_dump($allItems);

?>

    </body>
</html>