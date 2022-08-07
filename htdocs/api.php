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
    try {
        $pdo = DatabaseConn::connect();
    } catch(DatabaseConnectionException $exception) {
        http_response_code(500);
        $error = "Sorry, this API is not available right now.";
        echo $error;
        die;
    }

    if($search){
        $searchTerms = SearchTermExtractor::extractSearchTerms($search, '---', 1, 10);
        $databaseSearcher = new DatabaseSearcher($pdo);
        $results = $databaseSearcher->getSearchResults($searchTerms);
        return $results;
    }

    if($day && $month) {
        $databaseSearcher = new DatabaseSearcher($pdo);
        $dailyFactInfo = $databaseSearcher->returnDailyFact($day, $month);
        return $dailyFactInfo;
    }
}

?>
