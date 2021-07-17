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
                <li><a href="index.php">Index</a></li>
                <li><a href="form.php">Form</a></li>
                <li><a href="daily-fact.php">Daily Fact</a></li>
                <li><a href="test.php">Test</a></li>
                <li><a href="insert-form.php">Insert Test</a></li>
                <li><a class="active" href="archive.php">Archive</a></li>
                <li><a href="about.php">About me</a></li>
            </ul>    
        </nav>
    </div>

    <span class="formSpan">
        <form action="" method="GET">
            <label for="search">Browse prior facts:</label><br>
            <input type="text" name="search" placeholder="Search">
            <label for="sortBy">Sort by:</label>
            <select id="sortBy" name="sortBy">
                <option value="---" selected>---</option>
                <option value="dateASC">Date Ascending</option>
                <option value="dateDES">Date Descending</option>              
            </select>
            <input type="submit" value="Search">
        </form>
    </span>

    <div>
        <?php 
        require ("connect-to-database.php");

        $searchTerm = extractSearchFromGET();
        if($searchTerm) {
            $results = getResultsFromDatabase($dbc, $searchTerm);
            $numberOfResults = count($results);
            echo "Search of $searchTerm returned $numberOfResults results.";
            displayResults($results);
        } else {
            echo "Please enter a search term";
        }

        function extractSearchFromGET(): ?string {
            if (isset($_GET['search'])) {
                return $_GET['search'];
            } else {
                return null;
            }
        }

        function getResultsFromDatabase($dbc, $searchTerm): array {            
            $mysqliResult = mysqli_query($dbc, "SELECT * FROM `facts` WHERE `fact` LIKE '%$searchTerm%'");
            $results = array();
            while($row = mysqli_fetch_assoc($mysqliResult)) {  
                $results[] = $row;
            } 
            mysqli_free_result($mysqliResult);
            return $results;
        }

        function displayResults(array $results): void {
            foreach ($results as $result) {
                echo "<h4 class='result'>$result[day]/$result[month]</h4>";
                echo "<p class='result'>$result[fact]</p>";
                if($result['link']) {
                    echo "<p>Click <a href='$result[link]' target='blank'>here</a> to learn more about this event.</p>";
                }
                if($result['image']) {
                    echo "<img src='$result[image]' alt='associated image' style='width:200px;height:200px'>";
                }
            }   
        }

    ?>
    </div>

    <?php require 'footer.html'; ?>

</body>
</html>
