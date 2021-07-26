<?php require "includes/autoloader.inc.php"; ?>
<!DOCTYPE HTML>


<html>
    <body>
    <head>
        <title>Archive</title>
        <link rel="stylesheet" href="assests/style.css">
    </head>

    <header>
    <h1>Archive</h1>
    </header>

    <?php require 'includes/navBar.inc.php'; ?>

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

  
    <?php
    if(isset($_GET['search'])){
        $search = $_GET['search'];
        if($search){
            $searchTermExtractor = new SearchTermExtractor($_GET['search'], $_GET['sortBy'], $_GET['pageNo'], $_GET['limitBy']);
            $searchTerms = $searchTermExtractor->extractSearchTerms();
            $dataBaseSearcher = new DatabaseSearcher($searchTerms);
            $results = $dataBaseSearcher->getSearchResults();
            $totalResults = $dataBaseSearcher->countSearchResults();
            $displayResults = new ResultsDisplayer($searchTerms, $results, $totalResults);
            $displayResults->resultDisplayer();
        } else {
            echo "Please enter a search term.";
        }
    }


    function sortBySelected($value) {
        if(isset($_GET['sortBy'])) {
            $sortBy = $_GET['sortBy'];
            if($value == $sortBy){
                return "selected";
            }
        }
    }

    function limitBySelected($value) {
        if(isset($_GET['limitBy'])) {
            $limitBy = (int) $_GET['limitBy'];
            if($value == $limitBy){
                return "selected";
            }
        }
    }

     ?>  

    <?php 
    if(isset($_GET['search'])){
        $search = $_GET['search'];
        if($search){
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
    }
    ?>

    <?php require 'includes/footer.inc.html'; ?>

</body>
</html>