<?php
header("Content-Type:application/json");
require_once '../vendor/autoload.php';

$search = $_GET['search'];
$day = $_GET['day'];
$month = $_GET['month'];

$factInfo = setJSONResponse($search, $day, $month);
ob_clean();

if(empty($factInfo)) {
    echo "No results matching those terms.";
} else { 
    $json_response = json_encode($factInfo); 
    echo $json_response;
}

function setJSONResponse($search, $day, $month) {
    if($search){
        $searchTermExtractor = new SearchTermExtractor($search, '---', 1, 10);
        $searchTerms = $searchTermExtractor->extractSearchTerms();
        $dataBaseSearcher = new DatabaseSearcher();
        $results = $dataBaseSearcher->getSearchResults($searchTerms);
        return $results;
    }

    if($day && $month) {
        $databaseSearcher = new DatabaseSearcher();
        $dailyFactInfo = $databaseSearcher->returnDailyFact($day, $month);
        return $dailyFactInfo;
    }
}

?>
