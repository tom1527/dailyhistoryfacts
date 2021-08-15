<?php
require_once '../vendor/autoload.php';

use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Symfony\Component\HttpFoundation\Request;

$loader = new FilesystemLoader('../templates');
$twig = new Environment($loader);

if(isset($_GET['search'])){
    $searchBarValue = (string) $_GET['search'];
} else {
    $searchBarValue = "";
}

if(isset($_GET['sortBy'])) {
    $sortBy = (string) $_GET['sortBy'];
} else {
    $sortBy="";
}

if(isset($_GET['pageNo'])) {
    $pageNo = (int) $_GET['pageNo'];
} else {
    $pageNo="";
}

$sortByValues = [
    ['option' => '---', 'label' => '---'],
    ['option' => 'dateASC', 'label' => 'Date Ascending'],
    ['option' => 'dateDES', 'label' => 'Date Descending'] 
];

if(isset($_GET['limitBy'])) {
    $limitBy = $_GET['limitBy'];
} else {
    $limitBy = "";
}

$limitByValues = [
    ['option' => '5'],
    ['option' => '10'],
    ['option' => '15'],
    ['option' => '20']
];

if(isset($_GET['search'])){
    $search = $_GET['search'];
    if($search){
        $searchTermExtractor = new SearchTermExtractor($_GET['search'], $_GET['sortBy'], $_GET['pageNo'], $_GET['limitBy']);
        $searchTerms = $searchTermExtractor->extractSearchTerms();
        $dataBaseSearcher = new DatabaseSearcher($searchTerms);
        $results = $dataBaseSearcher->getSearchResults();
        $totalResults = $dataBaseSearcher->countSearchResults();
        $totalPages = ceil($totalResults/$limitBy);
    } else {
        $searchTerms = "";
        $totalResults = "";
        $results = "";
        $totalPages = "";
    }
} else {
    $searchTerms = "";
    $totalResults = "";
    $results = "";
    $totalPages = "";
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
    'totalPages' => $totalPages,
    'results' => $results,
]);

?>
