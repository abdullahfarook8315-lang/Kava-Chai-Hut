<?php

class Router
{
    private $routes = [];

    public function get($path, $controller, $method)
    {
        $this->routes['GET'][$path] = ['controller' => $controller, 'method' => $method];
    }

    public function post($path, $controller, $method)
    {
        $this->routes['POST'][$path] = ['controller' => $controller, 'method' => $method];
    }

    public function dispatch($url)
    {
        $method = $_SERVER['REQUEST_METHOD'];

        if (isset($this->routes[$method][$url])) {
            $controllerName = $this->routes[$method][$url]['controller'];
            $actionName = $this->routes[$method][$url]['method'];

            require_once "../controllers/$controllerName.php";
            $controller = new $controllerName();
            $controller->$actionName();
        } else {
            // Simple 404
            echo "404 Not Found";
        }
    }
}
