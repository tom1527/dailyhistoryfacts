<?php
require_once '../vendor/autoload.php';

use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Symfony\Component\HttpFoundation\Request;

$loader = new FilesystemLoader('../templates');
$twig = new Environment($loader);

$date = date("F jS");

$value[] = "";
$dataBaseSearcher = new DatabaseSearcher($value);
$currentDay = date("d");
$currentMonth = date("m");
$dailyFactInfo = $dataBaseSearcher->returnDailyFact($currentDay, $currentMonth);


echo $twig->render('index.template.html.twig', [
    'pageTitle' => 'Daily Fact',
    'header' => 'Fact of the day',
    'page' => 'index',
    'date' => $date,
    'dailyFactInfo' => $dailyFactInfo
]);

?>
