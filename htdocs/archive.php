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
            <div class="archiveForm">
                <label class="searchBarTitle" for="search">Browse prior facts:</label><br>
                <input class="searchBar" type="text" name="search" placeholder="Search" value="<?php echo (isset($_GET['search']) ? $_GET['search'] : '') ?>">
                
            </div>
            <div class="archiveForm">
                <label class= "selectBarTitle for="sortBy">Sort by:</label><br>
                <select class="selectBar" id="sortBy" name="sortBy"">
                    <option value="---" <?php if(isset($_GET['sortBy']) == '---') {echo 'selected="true"';}; ?>>---</option>
                    <option value="dateASC" <?php if(isset($_GET['sortBy']) == 'dateASC') {echo 'selected="true"';}; ?>>Date Ascending</option>
                    <option value="dateDES" <?php if(isset($_GET['sortBy']) == 'dateDES') {echo 'selected="true"';}; ?>>Date Descending</option>              
                </select>
            </div>
            <input type="hidden" name="pageNo" value="1"/>
            <div >
                <input class="submit" type="submit" value="Search">
            </div>
        </form>
    </span>




    <div>
        <?php 
        require ("connect-to-database.php");


        $searchTerm = extractSearchFromGET();
        if($searchTerm) {
            $totalRows = mysqli_query($dbc, "SELECT * FROM `facts` WHERE `fact` LIKE '%$searchTerm%'");
            $numberOfResults = mysqli_num_rows($totalRows);
            $sortBy = $_GET['sortBy'];
            $sqlOrderBy = extractSortByFromGET();
            $pageNo = isset($_GET['pageNo']) ? (int) $_GET['pageNo'] : 1;
            $pagination = limitResultsPerPage($pageNo);
            $results = getResultsFromDatabase($dbc, $searchTerm, $sqlOrderBy, $pagination);
            $totalPages = calculateTotalPages($numberOfResults);
            echo "Search of \"$searchTerm\" returned $numberOfResults results.";
            displayResults($results);
        } else {
            echo "Please enter a search term.";
        }

        function extractSearchFromGET(): ?string {
            if (isset($_GET['search'])) {
                return htmlspecialchars($_GET['search']);
            } else {
                return null;
            }
        }

        function extractSortByFromGET(): ?string {
            if ($_GET['sortBy'] == "dateASC") {
                return "ORDER BY `day` ASC, `month` ASC";
            } elseif ($_GET['sortBy'] == "dateDES") {
                return "ORDER BY `day` DESC, `month` DESC";
            } else {
                return "";
            }
        } 

        function limitResultsPerPage($pageNo) {
            $limit = 10;
            $offset = ($pageNo - 1) * $limit;
            return "LIMIT $limit OFFSET $offset";
            //needs reworking to seperate sql from php
        }

        function calculateTotalPages($numberOfResults) {
            $totalPages = ceil($numberOfResults / 10);
            return $totalPages;
        }


        function getResultsFromDatabase($dbc, $searchTerm, $sqlOrderBy, $pagination): array {            
            $mysqliResult = mysqli_query($dbc, "SELECT * FROM `facts` WHERE `fact` LIKE '%$searchTerm%' $sqlOrderBy $pagination");
            $results = array();
            while($row = mysqli_fetch_assoc($mysqliResult)) {  
                $results[] = $row;
            } 
            mysqli_free_result($mysqliResult);
            return $results;
        }

        function displayResults(array $results): void {
            foreach ($results as $result) {
                echo "<div class='archiveResults'><h4 class='result'>$result[day]/$result[month]</h4>";
                echo "<p class='result'>$result[fact]</p>";
                if($result['link']) {
                    echo "<p>Click <a href='$result[link]' target='blank'>here</a> to learn more about this event.</p>";
                }
                if($result['image']) {
                    echo "<img src='$result[image]' alt='associated image' style='width:200px;height:200px'>";
                }
                echo "</div>";
            }   
        }




        
        ?>
    </div>

    <?php 
    if($searchTerm) {
        ?>
        <div  class="pagination">
            <ul>
                <li><a href="<?php echo "?search=$searchTerm&sortBy=$sortBy&pageNo=1" ?>">First</a></li>
                <li class="<?php if($pageNo <= 1){ echo 'disabled'; } ?>">
                    <a href="<?php if($pageNo <= 1){ echo '#'; } else { echo "?search=$searchTerm&sortBy=$sortBy&pageNo=".($pageNo - 1); } ?>">Prev</a>
                </li>
                <li class="<?php if($pageNo >= $totalPages){ echo 'disabled'; } ?>">
                    <a href="<?php if($pageNo >= $totalPages){ echo '#'; } else { echo "?search=$searchTerm&sortBy=$sortBy&pageNo=".($pageNo + 1); } ?>">Next</a>
                </li>
                <li><a href="<?php echo "?search=$searchTerm&sortBy=$sortBy&pageNo=$totalPages; "?>">Last</a></li>
            </ul>
        </div>
        <?php
    }
    ?>


    <?php require 'footer.html'; ?>

</body>
</html>
