<?php
require_once '../vendor/autoload.php';

use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Symfony\Component\HttpFoundation\Request;

$loader = new FilesystemLoader('../templates');
$twig = new Environment($loader);

echo $twig->render('test.template.html.twig', [
    'page' => 'test'
]);