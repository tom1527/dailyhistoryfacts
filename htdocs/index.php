<?php
    require 'includes/autoloader.inc.php';
?>

<!DOCTYPE HTML>
<html>
    <head>
        <title>Index</title>
        <link rel="stylesheet" href="assests/style.css">
        <style>

        </style>
    </head>    

    <header>
        <h1>
            Tom's website thing
        </h1>        
    </header>

    <div class="navbar">
        <nav>
            <ul>
                <li><a class="active" href="index.php">Index</a></li>
                <li><a href="form.php">Form</a></li>
                <li><a href="daily-fact.php">Daily Fact</a></li>
                <li><a href="test.php">Test</a></li>
                <li><a href="insert-form.php">Insert Test</a></li>
                <li><a href="archive.php">Archive</a></li>
                <li><a href="about.php">About me</a></li>
            </ul>    
        </nav>
    </div>  

   
    <body>
        <div>
            <br>
            <form action="Home.php" method="get">
                <input type="submit" value="Hello">
                <label for="button"></label>
            </form>
            <br>
            <form action="test.php" method="get">
                <input type="submit" value="Test">
                <label for="button"></label>
            </form>
            <br>
            <form action="daily-fact.php" method="get">
                <input type="submit" value="Daily Fact">
                <label for="button"></label>
            </form>
            <br>
            <form action="navigational-buttons.php" method="get">
                <input type="submit" value="Navigational Buttons">
                <label for="button"></label>
            </form>
            <br>
            <form action="insert-form.php" method="get">
                <input type="submit" value="Insert Form">
                <label for="button"></label>
            </form>
            <br>
        </div>

        <?php
            $tom = new person("Tom", "blue", 22);
            echo $tom->getName();
            echo person :: $drinkingAge;
            person :: setDrinkingAge(18);
            echo person :: $drinkingAge
        ?>

    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    blah
    <?php
        require "footer.html";
    ?>
    </body>
</html>