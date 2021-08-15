<?php
require_once '../vendor/autoload.php';

use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Symfony\Component\HttpFoundation\Request;

$loader = new FilesystemLoader('../templates');
$twig = new Environment($loader);

$date = date("F jS");

$value[] = "";
$databaseSearcher = new DatabaseSearcher($value);
$currentDay = date("d");
$currentMonth = date("m");
$dailyFactInfo = $databaseSearcher->returnDailyFact($currentDay, $currentMonth);


echo $twig->render('index.template.html.twig', [
    'page' => 'Daily Fact',
    'date' => $date,
    'dailyFactInfo' => $dailyFactInfo
]);

?>
