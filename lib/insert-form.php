<!DOCTYPE HTML>
<html>
    <head>
        <title>Insert-Form</title>
        <link rel="stylesheet" href="assests/style.css">
    </head>
    
    <div class="navbar">
        <nav>
            <ul>
                <li><a href="index.php">Index</a></li>
                <li><a href="form.php">Form</a></li>
                <li><a href="index.php">Daily Fact</a></li>
                <li><a href="test.php">Test</a></li>
                <li><a class="active" href="insert-form.php">Insert Test</a></li>
                <li><a href="archive.php">Archive</a></li>
                <li><a href="about.php">About me</a></li>
            </ul>    
        </nav>
    </div> 
    
    <h1>Insert Form Test</h1>
    <p>Insert database stuff here.</p>
    <h3>Form Inserter:</h3>
    <form action="" method="post">
        <label for="insertName">Type value in here:</label><br>
        <input name="insertName" type="text" value="<?php if (array_key_exists('insertName', $_POST)) ECHO $_POST['insertName']; ?>"/>
        <input type="submit">
    </form>

<?php
require ("connect-to-database.php");
global $dbc;

if(array_key_exists('insertName', $_POST)) {
    $insertName = $_POST['insertName'];
    if (empty($insertName)) {
        echo "<p>Error: Please enter a value.</p>";
    } else {
        $queryResult = mysqli_query($dbc, "SELECT COUNT(*) AS numRows FROM inserts WHERE comment = '$insertName';");
        if($queryResult) {
            $numRows = mysqli_fetch_assoc($queryResult)['numRows'];
            if($numRows > 0) {
                echo "<p>Error: Insert already exists.</p>";
            } else {
                $insertQuery = "INSERT INTO inserts (comment) VALUES ('$insertName')";
                $result = mysqli_query($dbc, $insertQuery);
                if($result) {
                    echo "<p>Insert added.</p>";
                } else {   
                    echo "<p>Something went very wrong. Contact the administrator.</p>";
                    echo (mysqli_error($dbc));
                }
            }
        } else {
            echo (mysqli_error($dbc));
        }
    }
}
?>
</html>

