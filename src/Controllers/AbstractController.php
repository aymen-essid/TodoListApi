<?php

namespace App\Controllers;

use App\Service\ApiException;
use App\Service\ApiHandler;
use App\Service\AuthHandler;
use App\Service\DbHandler;
use App\Service\RouterService;
use Exception;
use stdClass;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

require_once 'conf.php';

Abstract Class AbstractController
{

    public $db;
    public AuthHandler $auth;
    public ApiHandler $api;
    public $controller ;
    public $method;
    public $entity;
    public $twig; 
    public $route;
    

    const ACTIVATE_CACHE = false;
    const VIEWS_PATH  = 'src/Views';

    public function __construct()
    {
        $initDb = new DbHandler();
        $this->db = $initDb->connect();
        $this->api = new ApiHandler();
        $this->auth = new AuthHandler();
        $this->route = new RouterService($_SERVER['REQUEST_URI']);
    }


    public function render(string $tplFile, array $params=[]) : void 
    {

        $loader = new FilesystemLoader(self::VIEWS_PATH);
        $twig = new Environment($loader, [
            'cache' => Self::ACTIVATE_CACHE,
        ]);
        
        $twig->addGlobal('rootDirectory' , dirname(__FILE__, 3));
        echo $twig->render($tplFile, $params);
    }


    public function getUrlParams()
    {
        $url = $_SERVER['REQUEST_URI'];
        $routeWithoutParams = strtok($url, '?');
        $route = substr($routeWithoutParams, strpos($routeWithoutParams, '/')+1);
        $routeParts = explode('/' , $route);

        if(count($routeParts) == 2)
            list( $this->controller, $this->method ) = $routeParts;
        elseif(count($routeParts) == 3)
            list( $this->controller, $this->method, $this->entity ) = $routeParts;
        
        $result = new stdClass();
        $result->controller = $this->controller;
        $result->method = $this->method;
        $result->entity = $this->entity;

        return $result;
    }

    public function isAuthorized()
    {
       return ($this->auth->decodeJWT($this->auth->getToken())) ?? false ;
    }

}