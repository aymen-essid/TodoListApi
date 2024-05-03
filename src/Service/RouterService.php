<?php

namespace App\Service;



class RouterService
{

    private string $uri;
    private string $controller;
    private string $method;
    private string $entity;
    private array  $routes;

    public function __construct($uri, $routes=[])
    {
        $this->uri = $uri;
        $this->routes = $routes;
        $this->method = '';
        $this->entity = '';
    }


    public function dispatch()
    {

        $routeWithoutParams = strtok($this->uri, '?');
        $route = substr($routeWithoutParams, strpos($routeWithoutParams, '/')+1);
        $routeParts = explode('/' , $route);


        // Match the URI to a route
        if (in_array($routeWithoutParams, $this->routes)) {

            if(count($routeParts) == 2)
                list( $this->controller, $this->method ) = $routeParts;
            elseif(count($routeParts) == 3)
                list( $this->controller, $this->method, $this->entity ) = $routeParts;
            elseif(empty($this->controller) || empty($this->method) ){
                http_response_code(404);
                echo 'Route not found Check your method or Entity<br>';
                require '././src/Views/404.php';
            }

            $controllerClassName = "App\Controllers\\" . ucfirst(basename($this->controller)) . 'Controller';
            $controller = new $controllerClassName();
            $method = $this->method;
            ($this->method) ? $controller->$method() : '';
        }
        else 
        {
            // Route not found, handle appropriately (e.g., show a 404 page)
            http_response_code(404);
            echo 'Route not found or not Configured <br>';
            require  '././src/Views/404.php';
        }
    }

    public function getMethod()
    {
        return $this->method;
    }

    public function getEntity()
    {
        return $this->entity;
    }
    
    
}