<!DOCTYPE HTML>
<html>

    <head>
        <title>Hello</title>
        <link rel="stylesheet" href="assests/style.css">
    </head>

    <div class="navbar">
        <nav>
            <ul>
                <li><a href="index.html">Index</a></li>
                <li><a href="form.php">Form</a></li>
                <li><a href="daily-fact.php">Daily Fact</a></li>
                <li><a href="test.php">Test</a></li>
                <li><a href="insert-form.php">Insert Test</a></li>
                <li><a href="archive.php">Archive</a></li>
                <li><a class="active" href="about.php">About me</a></li>
            </ul>    
        </nav>
    </div>  

    <h3>Hello</h3>
    <body>
        Hello <?php echo $_GET["name"];?>
    </body>
</html>