<?php
require_once '../../vendor/autoload.php';

use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Symfony\Component\HttpFoundation\Request;

$loader = new FilesystemLoader('..\templates');
$twig = new Environment($loader);

if(isset($_GET['search'])){
    $searchBarValue = (string) $_GET['search'];
} else {
    $searchBarValue = "";
}

$sortByValueDEF = "";
$sortByValueASC = "dateASC";
$sortByValueDES = "dateDES";


if(isset($_GET['sortBy'])) {
    $sortBy = (string) $_GET['sortBy'];
} else {
    $sortBy="";
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


echo $twig->render('page.template.html.twig', [
    'pageTitle' => 'test', 
    'header' => 'Archive',
    'searchBarValue' => $searchBarValue,
    'sortBy' => $sortBy,
    'sortByValues' => $sortByValues,
    'limitBy' => $limitBy,
    'limitByValues' => $limitByValues
]);




?>


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