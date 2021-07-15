<!DOCTYPE html>
<html>
<body>

    <head>
        <title>Fact of the Day</title>
        <link rel="stylesheet" href="assests/style.css">
    </head>

    <header>
        <h1>Fact of the day</h1>
    </header>

    <div class="navbar">
        <nav>
            <ul>
                <li><a href="index.php">Index</a></li>
                <li><a href="form.php">Form</a></li>
                <li><a class="active" href="daily-fact.php">Daily Fact</a></li>
                <li><a href="test.php">Test</a></li>
                <li><a href="insert-form.php">Insert Test</a></li>
                <li><a href="archive.php">Archive</a></li>
                <li><a href="about.php">About me</a></li>
            </ul>    
        </nav>
    </div> 


    <section class="dailyFactInfo">
        <h1>An Interesting Historical Fact</h1>
        <p>This page displays an interesting fact that occured on today's date sometime in the past. Although care has been taken to verify the information 
            below, it should be noted that I am not an historian. Refreshing the page may display an alternate fact for today. <br> If you wish to see facts from other dates,
            feel free to visit the archive page. Please bare in mind that some dates may not have an associated fact yet.</p>
        <h4>Today's date is: <?php echo date("F jS"); ?></h4>
    </section>
    
    <section class="dailyFact">
        <?php
            require ("connect-to-database.php");
            global $dbc;
            $currentDay = date("d");
            $currentMonth = date("m");
            $factResult = mysqli_query($dbc, "SELECT * FROM facts WHERE day = '$currentDay' && month = '$currentMonth' ORDER BY RAND();");
            $factInfo = mysqli_fetch_assoc($factResult);

            // Rather than using a random number, this could later be modified to be based on user region/culture.
        ?>

        <h1>On <?php echo date("F jS") ?> in the past...</h1>

        <b>
            <?php 
                if ($factInfo) {
                    echo $factInfo['fact'];
                } else {
                    echo "Error: the entry for this date is most likely empty. This will be fixed as the website is updated.";
                }
            ?>
        </b>

        <p>
            <?php
                if ($factInfo) {
                    ?> Click <a href="<?php echo $factInfo['link'];?>" target="blank"></b>here</a> to learn more about this event. <?php
                } else {
                    echo "Error: link not found.";
                }
            ?>
        </p>
    </section>

    <section>
        <img src="<?php echo $factInfo['image'] ?>" alt="associated image">
    </section>



    </body>

    <?php
        require "footer.html";
    ?>
</html>