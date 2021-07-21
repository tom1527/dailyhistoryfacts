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
                <label class= "selectBarTitle" for='sortBy'>Sort by:</label><br>
                <select class="selectBar" id="sortBy" name="sortBy">
                    <option value="---" <?php echo sortBySelected("---") ?>>---</option>
                    <option value="dateASC" <?php echo sortBySelected("dateASC") ?>>Date Ascending</option>
                    <option value="dateDES" <?php echo sortBySelected("dateDES") ?>>Date Descending</option>              
                </select>
            </div>
            <input type="hidden" name="pageNo" value="1"/>
            <div class="archiveForm">
            <label class= "selectBarTitle" for='limitBy'>Limit results per page:</label><br>
                <select class="selectBar" id="limitBy" name="limitBy">
                    <option value= "5" <?php echo limitBySelected(5); ?>>5</option>
                    <option value= "10" <?php echo limitBySelected(10); ?>>10</option>
                    <option value= "15" <?php echo limitBySelected(15); ?>>15</option>              
                    <option value= "20" <?php echo limitBySelected(20); ?>>20</option> 
                </select>
            </div>
            <div>
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
            $limitResults = isset($_GET['limitBy']) ? (int) $_GET['limitBy'] : 5;
            $sqlPagination = limitResultsPerPage($pageNo, $limitResults);
            $results = getResultsFromDatabase($dbc, $searchTerm, $sqlOrderBy, $sqlPagination);
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
            $sqlOrderBy = "--";
            if ($_GET['sortBy'] == "dateASC") {
                $sqlOrderBy = "ORDER BY `day` ASC, `month` ASC";
            } 
            if ($_GET['sortBy'] == "dateDES") {
                $sqlOrderBy = "ORDER BY `day` DESC, `month` DESC";
            }
            return $sqlOrderBy;
        } 

        function sortBySelected($value) {
            if(isset($_GET['sortBy'])) {
                $sortBy = $_GET['sortBy'];
                if($value == $sortBy){
                    return "selected";
                }
            }
        }

        function limitResultsPerPage($pageNo, $limitResults)  {
            $offset = ($pageNo - 1) * $limitResults;
            $sqlPagination = "LIMIT $limitResults OFFSET $offset";
            return $sqlPagination;
        }

        function limitBySelected($value) {
            if(isset($_GET['limitBy'])) {
                $limitBy = (int) $_GET['limitBy'];
                if($value == $limitBy){
                    return "selected";
                }
            }
        }

        function calculateTotalPages($numberOfResults) {
            $totalPages = ceil($numberOfResults / 10);
            return $totalPages;
        }


        function getResultsFromDatabase($dbc, $searchTerm, $sqlOrderBy, $sqlPagination): array {            
            $mysqliResult = mysqli_query($dbc, "SELECT * FROM `facts` WHERE `fact` LIKE '%$searchTerm%' $sqlOrderBy $sqlPagination");
            $results = array();
            while($row = mysqli_fetch_assoc($mysqliResult)) {  
                $results[] = $row;
            } 
            mysqli_free_result($mysqliResult);
            return $results;
        }

        function displayResults(array $results): void {
            $i = 1;
            foreach ($results as $result) {
                echo "<div class='archiveResults'>Result: $i";
                echo "<h4 class='result'>$result[day]/$result[month]</h4>";
                echo "<p class='result'>$result[fact]</p>";
                if($result['link']) {
                    echo "<p>Click <a href='$result[link]' target='blank'>here</a> to learn more about this event.</p>";
                }
                if($result['image']) {
                    echo "<img src='$result[image]' alt='associated image' style='width:200px;height:200px'>";
                }
                echo "</div>";
                $i++;
            }   
        }




        
        ?>
    </div>

    <?php 
    if($searchTerm) {
        ?>
        <div  class="pagination">
            <ul>
                <li><a href="<?php echo "?search=$searchTerm&sortBy=$sortBy&pageNo=1&limitBy=$limitResults" ?>">First</a></li>
                <li class="<?php if($pageNo <= 1){ echo 'disabled'; } ?>">
                    <a href="<?php if($pageNo <= 1){ echo '#'; } else { echo "?search=$searchTerm&sortBy=$sortBy&pageNo=".($pageNo - 1)."&limitBy=$limitResults"; } ?>">Prev</a>
                </li>
                <li class="<?php if($pageNo >= $totalPages){ echo 'disabled'; } ?>">
                    <a href="<?php if($pageNo >= $totalPages){ echo '#'; } else { echo "?search=$searchTerm&sortBy=$sortBy&pageNo=".($pageNo + 1)."&limitBy=$limitResults"; } ?>">Next</a>
                </li>
                <li><a href="<?php echo "?search=$searchTerm&sortBy=$sortBy&pageNo=$totalPages&limitBy=$limitResults; "?>">Last</a></li>
            </ul>
        </div>
        <?php
    }
    ?>


    <?php require 'footer.html'; ?>

</body>
</html>
