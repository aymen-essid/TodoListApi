<?php

namespace App;

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

// phpinfo(); die;

require 'vendor/autoload.php';


use App\Service\DbHandler;
use App\Service\RouterService;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

require_once('conf.php');

# Init Db Connexion
$dbConnexion = new DbHandler();

# Init Routing
$route = new RouterService( $_SERVER['REQUEST_URI'], $routesConf );
$route->dispatch();

?>
