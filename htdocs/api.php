<?php
header("Content-Type:application/json");
require_once '../vendor/autoload.php';

$search = isset($_GET['search']) ? $_GET['search'] : null;
$day = isset($_GET['day']) ? $_GET['day'] : null;
$month = isset($_GET['month']) ? $_GET['month'] : null;

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
        $searchTerms = SearchTermExtractor::extractSearchTerms($search, '---', 1, 10);
        $results = DatabaseSearcher::getSearchResults($searchTerms);
        return $results;
    }

    if($day && $month) {
        $results = DatabaseSearcher::getSearchResults($day, $month);
        return $dailyFactInfo;
    }
}

?>
