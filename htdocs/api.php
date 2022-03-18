<?php
header("Content-Type:application/json");
require_once '../vendor/autoload.php';

$search = $_GET['search'];
$day = $_GET['day'];
$month = $_GET['month'];

$factInfo = setJSONResponse($search, $day, $month);

if(empty($factInfo) {
    $factInfo = "No results matching those terms";
} else { 
    ob_clean();
    $json_response = json_encode($results);
    echo $json_response;   
}

function setJSONResponse($search, $day, $month) {
    if($search){
        if(empty($search)) {
            $error = "Invalid search parameter";
            return;
        }
        $searchTermExtractor = new SearchTermExtractor($search, '---', 1, 10);
        $searchTerms = $searchTermExtractor->extractSearchTerms();
        $dataBaseSearcher = new DatabaseSearcher($searchTerms);
        $results = $dataBaseSearcher->getSearchResults();
        return $results;
    }

    if($day && $month) {
        if(empty($day) || emtpty($month)) {
            $error = "Invalid day or month parameters";
            return;
        }
        $databaseSearcher = new DatabaseSearcher($value);
        $dailyFactInfo = $databaseSearcher->returnDailyFact($currentDay, $currentMonth);
        return $dailyFactInfo;
    }
}

?>
