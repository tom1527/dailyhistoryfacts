<!DOCTYPE html>
<html>
    <body>
    <head>
        <title>Archive</title>
        <link rel="stylesheet" href="assests/style.css">
    </head>

    <header>
    <h1>Archive</h1>
    </header>

    <div class="navbar">
        <nav>
            <ul>
                <li><a href="index.html">Index</a></li>
                <li><a href="form.php">Form</a></li>
                <li><a href="daily-fact.php">Daily Fact</a></li>
                <li><a href="test.php">Test</a></li>
                <li><a href="insert-form.php">Insert Test</a></li>
                <li><a class="active" href="archive.php">Archive</a></li>
                <li><a href="about.php">About me</a></li>
            </ul>    
        </nav>
    </div>

    <section>
        <form action="" method="GET">
            <label for="search">Browse prior facts:</label><br>
            <input type="text" name="search" placeholder="Search">
            <input type="submit" value="Search">
        </form>
    </section>

    <section>
        <?php 
            require ("connect-to-database.php");
            global $dbc;
            if (isset($_GET['search'])) {
                $search = $_GET['search'];
                $query = mysqli_query($dbc, "SELECT * FROM `facts` WHERE `fact` LIKE '%$search%'");
                $noResults = mysqli_num_rows($query);
                if($search)  {
                    echo "Search returned $noResults results.";
                    while($row = mysqli_fetch_assoc($query)) {      
                        ?>
                        <h4  class="result"><?php echo $row['day'], "/", $row['month']; ?></h4>
                        <p class="result"><?php echo $row['fact']; ?> </p>
                        <?php
                            if($row['link']) {
                                ?><p>Click <a href="<?php echo $row['link'];?>" target="blank"></b>here</a> to learn more about this event.</p><?php
                            }
                            if($row['image']) {
                                ?><img src="<?php echo $row['image'] ?>" alt="associated image" style="width:200px;height:200px"><?php
                            }
                    } 
                    mysqli_free_result($query);
                } else {
                    echo "Error: please enter a search term.";
                }
            }
        ?>
    </section>

</body>
</html>
