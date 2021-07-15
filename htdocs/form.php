<!DOCTYPE html>
<html>

    <head>
        <title>Form Test</title>
        <link rel="stylesheet" href="assests/style.css">
    </head>

    <div class="navbar">
        <nav>
            <ul>
                <li><a href="index.html">Index</a></li>
                <li><a class="active" href="form.php">Form</a></li>
                <li><a href="daily-fact.php">Daily Fact</a></li>
                <li><a href="test.php">Test</a></li>
                <li><a href="insert-form.php">Insert Test</a></li>
                <li><a href="archive.php">Archive</a></li>
                <li><a class="active" href="about.php">About me</a></li>
            </ul>    
        </nav>
    </div>  


    <h1>Simple form</h1>

    <h3>Enter your name below</h3>
    <br>
    <form action="Hello.php" method="get">
        Name: <input type=text" name="name">
        <input type="submit">
    </form>
</html>
