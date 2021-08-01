<?php
require_once '../../vendor/autoload.php';

use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Symfony\Component\HttpFoundation\Request;

$loader = new FilesystemLoader('..\templates');
$twig = new Environment($loader);

$date = date("F jS");

$page = $_SERVER['REQUEST_URI'];
$page = ltrim($page, "/");
$page = substr($page, 0 , strpos($page, "."));
$value[] = "";
$dataBaseSearcher = new DatabaseSearcher($value);
$currentDay = date("d");
$currentMonth = date("m");
$dailyFactInfo = $dataBaseSearcher->returnDailyFact($currentDay, $currentMonth);


echo $twig->render('daily-fact.template.html.twig', [
    'pageTitle' => 'Daily Fact',
    'header' => 'Fact of the day',
    'page' => $page,
    'date' => $date,
    'dailyFactInfo' => $dailyFactInfo
]);

?>