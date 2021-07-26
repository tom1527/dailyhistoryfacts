<?php require "includes/autoloader.inc.php"; ?>
<!DOCTYPE HTML>


<html>
    <body>
    <head>
        <title>TEST</title>
        <link rel="stylesheet" href="assests/style.css">
    </head>

    <header>
    <h1>TEST</h1>
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
                    <option value="---">---</option>
                    <option value="dateASC">Date Ascending</option>
                    <option value="dateDES">Date Descending</option>              
                </select>
            </div>
            <input type="hidden" name="pageNo" value="1"/>
            <div class="archiveForm">
            <label class= "selectBarTitle" for='limitBy'>Limit results per page:</label><br>
                <select class="selectBar" id="limitBy" name="limitBy">
                    <option value= "5">5</option>
                    <option value= "10">10</option>
                    <option value= "15">15</option>              
                    <option value= "20">20</option> 
                </select>
            </div>
            <div>
                <input class="submit" type="submit" value="Search">
            </div>
        </form>
    </span>

  
    <?php
    if(isset($_GET['search'])){
        $searchTermExtractor = new SearchTermExtractor($_GET['search'], $_GET['sortBy'], $_GET['pageNo'], $_GET['limitBy']);
        $searchTerms = $searchTermExtractor->extractSearchTerms();
        $dataBaseSearcher = new DatabaseSearcher($searchTerms);
        $results = $dataBaseSearcher->getSearchResults();
        $totalResults = $dataBaseSearcher->countSearchResults();
        $displayResults = new ResultsDisplayer($searchTerms, $results, $totalResults);
        $displayResults->resultDisplayer();
    }
     ?>  