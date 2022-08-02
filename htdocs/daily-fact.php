<?php
require_once '../vendor/autoload.php';

use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Symfony\Component\HttpFoundation\Request;

$loader = new FilesystemLoader('../templates');
$twig = new Environment($loader);

$responseCode = 200;

if(isset($_GET['day']) && false) {
    $currentDay = $_GET['day'];
} else {
    $responseCode = 400;
    $errorMessage = "Error code 400: Missing 'day' parameter from URL.";
}

if(isset($_GET['month'])) {
    $currentMonth = $_GET['month'];
} else {
    $responseCode = 400;
    $errorMessage = "Error code 400: Missing 'month' parameter from URL.";
}

if($responseCode == 200) {
    $databaseSearcher = new DatabaseSearcher();
    $dailyFactInfo = $databaseSearcher->returnDailyFact($currentDay, $currentMonth);
} else {
    $dailyFactInfo = $errorMessage;
}


echo $twig->render('daily-fact.template.html.twig', [
    'page' => 'Daily Fact',
    'dailyFactInfo' => $dailyFactInfo,
    
]);

?>
