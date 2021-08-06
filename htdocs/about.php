<?php
require_once '../vendor/autoload.php';

use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Symfony\Component\HttpFoundation\Request;

$loader = new FilesystemLoader('templates');
$twig = new Environment($loader);

$page = $_SERVER['REQUEST_URI'];
$page = ltrim($page, "/");
$page = substr($page, 0 , strpos($page, "."));

echo $twig->render('about.template.html.twig', [
    'page' => $page
]);