<?php
require_once '../vendor/autoload.php';

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

$loader = new FilesystemLoader('../templates');
$twig = new Environment($loader);


if (empty($_GET['day'])) {
    http_response_code(400);
    $errorTitle = 'Sorry, we couldn\'t load a fact.';
    $errorDescription = "Error: request missing 'day' parameter.";

} else if (empty($_GET['month'])) {
    http_response_code(400);
    $errorTitle = 'Sorry, we couldn\'t load a fact.';
    $errorDescription = "Error: request missing 'month' parameter.";

} else {

    $pdo = DatabaseConn::connect();
    $databaseSearcher = new DatabaseSearcher($pdo);

    $dailyFactInfo = $databaseSearcher->returnDailyFact($_GET['day'], $_GET['month']);

    if (empty($dailyFactInfo)) {
        http_response_code(404);
        $errorDescription = "Error: the entry for this date is most likely empty. This will be fixed as the website is updated.";
    }
    echo $twig->render('daily-fact.template.html.twig', [
        'page' => 'Daily Fact',
        'dailyFactInfo' => $dailyFactInfo,
        'errorTitle' => $errorTitle,
        'errorDescription' => $errorDescription
    ]);

}

?>
