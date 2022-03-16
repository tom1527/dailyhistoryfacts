<?php
header("Content-Type:application/json");
require_once '../vendor/autoload.php';

$search = $_GET['search'];
if($search){
    $searchTermExtractor = new SearchTermExtractor($_GET['search'], '---', 1, 10);
    $searchTerms = $searchTermExtractor->extractSearchTerms();
    $dataBaseSearcher = new DatabaseSearcher($searchTerms);
    $results = $dataBaseSearcher->getSearchResults();
}

if(empty($search) || count($results) == 0) {
    $results = "No results matching those terms";
}


ob_clean();
$json_response = json_encode($results);

echo $json_response;

?>
