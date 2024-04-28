<?php

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
// rest of the code

// phpinfo(); die;


require 'vendor/autoload.php';


use App\Entity\User;
use App\Service\DbConnect;
use Twig\Loader\FilesystemLoader;
use Twig\Environment;

require_once('database/config.php');

$dbConnexion = new DbConnect();



var_dump($dbConnexion); die;

$loader = new FilesystemLoader('src/Views');
$twig = new Environment($loader, [
    // 'cache' => 'cache',
    'cache' => false,
]);

$template = $twig->load('home.html.twig');

// echo $twig->render($template);

$twig->display($template);

?>
