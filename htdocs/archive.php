<?php
require_once '../vendor/autoload.php';
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
$loader = new FilesystemLoader('../templates');
$twig = new Environment($loader);

$searchBarValue = isset($_GET['search']) ? $_GET['search'] : "";

$sortBy = isset($_GET['sortBy']) ? $_GET['sortBy'] : "";

$sortByValues = [
    ['option' => '---', 'label' => '---'],
    ['option' => 'dateASC', 'label' => 'Date Ascending'],
    ['option' => 'dateDES', 'label' => 'Date Descending'] 
];

$pageNo = isset($_GET['pageNo']) ? $_GET['pageNo'] : "";

$limitBy = isset($_GET['limitBy']) ? $_GET['limitBy'] : "";

$limitByValues = [
    ['option' => '5'],
    ['option' => '10'],
    ['option' => '15'],
    ['option' => '20']
];

if($searchBarValue){
    $searchTerms = SearchTermExtractor::extractSearchTerms($searchBarValue, $sortBy, $pageNo, $limitBy);
    try {
        $pdo = DatabaseConn::connect();
    } catch(DatabaseConnectionException $exception) {
        http_response_code(500);
        $error = "Sorry, the archive is not available right now.";
        echo $twig->render('archive.template.html.twig', [
            'page' => 'Archive',
            'error' => $error
        ]);
        die;
    }
    $dataBaseSearcher = new DatabaseSearcher($pdo);
    $results = $dataBaseSearcher->getSearchResults($searchTerms);
    $resultCountSoFar = ($pageNo - 1) * $limitBy;
    $totalResults = $dataBaseSearcher->countSearchResults($searchTerms);
    $totalPages = ceil($totalResults/$limitBy);
} 

echo $twig->render('archive.template.html.twig', [
    'page' => 'Archive',
    'searchBarValue' => $searchBarValue,
    'sortBy' => $sortBy,
    'pageNo' => $pageNo,
    'sortByValues' => $sortByValues,
    'limitBy' => $limitBy,
    'limitByValues' => $limitByValues,
    'searchTerms' => $searchTerms,
    'totalResults' => $totalResults,
    'resultCountSoFar' => $resultCountSoFar,
    'totalPages' => $totalPages,
    'results' => $results,
]);

?>
