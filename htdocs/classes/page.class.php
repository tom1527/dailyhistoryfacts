<?php
require_once '../../vendor/autoload.php';

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

$loader = new FilesystemLoader('..\templates');
$twig = new Environment($loader);

echo $twig->render('page.template.html.twig', [
    'pageTitle' => 'test', 
    'header' => 'Archive'
]);

?>