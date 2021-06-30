<!DOCTYPE html>
<html>
    <div class="navbar">
        <a class="active" href="form.php">Form</a>
        <a href="daily-fact.php">Daily Fact</a>
        <a href="test.php">Test</a>
    </div>  
    <head>
        <title>Fact of the Day</title>
        <link rel="stylesheet" href="assests/style.css">
    </head>
    <body>
        <h1>Interesting Fact</h1>
        <p>This page displays an interesting fact that occured on today's date sometime in the past.</p>
        <h4>Today's date is <?php echo date("F jS"); ?></h4>
        <h4>On this date in the past:</h4>

        <?php
            require ("connect-to-database.php");
            global $dbc;
            $currentDate = date("Y-m-d");
            $result = mysqli_query($dbc, "SELECT * FROM facts WHERE date = '$currentDate';");
            $factInfo = mysqli_fetch_assoc($result);
        ?>

        <p>
            <?php 
                if ($factInfo) {
                    echo $factInfo['fact'];
                } else {
                    echo "error";
                }
            ?>
        </p>
    </body>

</html>