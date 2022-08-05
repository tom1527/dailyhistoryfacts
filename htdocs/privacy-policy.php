<?php
require_once '../vendor/autoload.php';

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

$loader = new FilesystemLoader('../templates');
$twig = new Environment($loader);

echo $twig->render('privacy-policy.template.html.twig', [
    'page' => 'Privacy Policy'
]);
