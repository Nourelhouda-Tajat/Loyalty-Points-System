<?php
namespace Core;
class Router
{
    private $routes = [];
    private $method;
    private $uri;

    public function __construct()
    {
        $this->method = $_SERVER['REQUEST_METHOD'];

        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        $basePath = '/Loyalty%20Points%20System/public';
        $uri = str_replace($basePath, '', $uri);

        $uri = rtrim($uri, '/');
        $this->uri = $uri ?: '/';
    }

    public function add($method, $path, $controller, $action)
    {
        $this->routes[$method][$path] = [$controller, $action];
    }

    public function run()
    {
        if (isset($this->routes[$this->method][$this->uri])) {
            [$controllerName, $action] = $this->routes[$this->method][$this->uri];
            $controller = new $controllerName();
            $controller->$action();
            return;
        }

        http_response_code(404);
        echo "page not found";
    }
}

?>