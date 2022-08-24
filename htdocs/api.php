<?php
require_once '../vendor/autoload.php';

$searchTerm = $_GET['search'] ?? null;
$day = $_GET['day'] ?? null;
$month = $_GET['month'] ?? null;

ob_clean();
try {
    $pdo = DatabaseConn::connect();
} catch(DatabaseConnectionException $exception) {
    http_response_code(500);
    echo "Sorry, this API is not available right now.";
    die;
}

if($searchTerm != null) {
    $factInfo = searchDataBaseBySearchTerm($searchTerm, $pdo);
} else if($day != null && $month != null) {
    $factInfo = searchDataBaseByDate($day, $month, $pdo);
} else {
    http_response_code(400);
    echo "Please specify a search term, or a day and a month.";
    die;
}

if(empty($factInfo)) {
    echo "No results matching those terms.";
} else { 
    header("Content-Type:application/json");
    echo json_encode($factInfo); 
}

function searchDataBaseBySearchTerm(string $searchTerm, $pdo) {
    $searchArray = ["searchTerm" => $searchTerm, "sortBy" => null, "limitBy" => 10, "offset" => null];
    $databaseSearcher = new DatabaseSearcher($pdo);
    return $databaseSearcher->getSearchResults($searchArray);
}

function searchDataBaseByDate($day, $month, $pdo) {
    $databaseSearcher = new DatabaseSearcher($pdo);
    return $databaseSearcher->returnDailyFact($day, $month);
}

?>
