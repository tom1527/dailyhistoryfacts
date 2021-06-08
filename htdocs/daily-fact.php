<!DOCTYPE html>
<html>  
    <head>
        <title>Fact of the Day</title>
        <link rel="stylesheet" href="assests/style.css">
    </head>
    <body>
        <h1>Interesting Fact</h1>
    </body>

<?php

require ("connect-to-database.php");
global $dbc;
echo date("jS F");
?> <br> <?php
echo "test";
?> <br> <?php
$currentDate = date("Y-m-d");
echo $currentDate;
?> <br> <?php
$result = mysqli_query($dbc, "SELECT * FROM facts WHERE date = '$currentDate';");
$factInfo = mysqli_fetch_assoc($result);
if ($row) {
    echo $factInfo['fact'];
} else {
    echo "error";
}

?>




</html>