<?php
require_once '../vendor/autoload.php';

use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Symfony\Component\HttpFoundation\Request;

$loader = new FilesystemLoader('../templates');
$twig = new Environment($loader);

$value[] = "";
if(isset($_GET['day'])) {
    $currentDay = $_GET['day'];
} else {
    $currentDay = "Error";
}

if(isset($_GET['month'])) {
    $currentMonth = $_GET['month'];
} else {
    $currentMonth = "Error";
}

$databaseSearcher = new DatabaseSearcher($value);
$dailyFactInfo = $databaseSearcher->returnDailyFact($currentDay, $currentMonth);


echo $twig->render('daily-fact.template.html.twig', [
    'page' => 'Daily Fact',
    'dailyFactInfo' => $dailyFactInfo,
    
]);

?>
