<?php

namespace App\Controllers;

use App\Service\ApiException;
use App\Service\ApiHandler;
use App\Service\DbHandler;
use App\Service\RouterService;
use Exception;
use stdClass;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;



Abstract Class AbstractController
{

    public $db;
    public ApiHandler $api;
    public $controller ;
    public $method;
    public $entity;
    public $twig; 

    const ACTIVATE_CACHE = false;
    const VIEWS_PATH  = 'src/Views';

    public function __construct()
    {
        $initDb = new DbHandler();
        $this->db = $initDb->connect();
        $this->api = new ApiHandler();
    }


    public function render(string $tplFile) : void 
    {

        $loader = new FilesystemLoader(self::VIEWS_PATH);
        $twig = new Environment($loader, [
            'cache' => Self::ACTIVATE_CACHE,
        ]);
        
        $twig->addGlobal('rootDirectory' , dirname(__FILE__, 3));
        $this->twig = $twig;
        $twig->load($tplFile);
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

}